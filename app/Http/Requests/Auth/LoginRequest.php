<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * このリクエストが認可されているかを判断
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * リクエストに適用されるバリデーションルールを取得
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'], // メールアドレス: 必須、文字列、正しい形式
            'password' => ['required', 'string'],       // パスワード: 必須、文字列
        ];
    }

    /**
     * リクエストの認証情報を基に認証を試行
     *
     * @throws \Illuminate\Validation\ValidationException 認証失敗時
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited(); // レート制限を確認

        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // 認証に失敗した場合、レート制限を増加
            RateLimiter::hit($this->throttleKey());

            // エラーメッセージをスロー
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // 認証成功時にレート制限をクリア
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * レート制限を確認し、超過した場合にエラーをスロー
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        // ロックアウトイベントを発火
        event(new Lockout($this));

        // 次回利用可能までの時間を取得
        $seconds = RateLimiter::availableIn($this->throttleKey());

        // エラーメッセージをスロー
        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * レート制限の対象キーを生成
     *
     * @return string
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
