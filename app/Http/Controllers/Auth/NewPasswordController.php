<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * パスワードリセット画面を表示
     */
    public function create(Request $request): View
    {
        // パスワードリセットビューを返す
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * 新しいパスワードを保存
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 入力データのバリデーション
        $request->validate([
            'token' => ['required'], // パスワードリセットトークン
            'email' => ['required', 'email'], // 登録済みメールアドレス
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // 新しいパスワード
        ]);

        // パスワードリセットを試行
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                // ユーザモデルのパスワードを更新
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60), // 新しいトークンを生成
                ])->save();

                // パスワードリセットイベントを発火
                event(new PasswordReset($user));
            }
        );

        // 成功時はログイン画面にリダイレクト、失敗時はエラーを返す
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}
