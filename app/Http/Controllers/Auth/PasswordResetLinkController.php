<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * パスワードリセットリンクリクエスト画面を表示
     */
    public function create(): View
    {
        // パスワードリセットリンクリクエストビューを返す
        return view('auth.forgot-password');
    }

    /**
     * パスワードリセットリンクリクエストを処理
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 入力データのバリデーション
        $request->validate([
            'email' => ['required', 'email'], // 登録済みのメールアドレス
        ]);

        // パスワードリセットリンクを送信
        $status = Password::sendResetLink(
            $request->only('email') // リクエストからメールアドレスを取得
        );

        // 成功時または失敗時に応じてレスポンスを返す
        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status)) // 成功ステータス
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]); // エラーメッセージ
    }
}
