<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * パスワード確認画面を表示
     */
    public function show(): View
    {
        // パスワード確認ビューを返す
        return view('auth.confirm-password');
    }

    /**
     * ユーザのパスワードを確認
     */
    public function store(Request $request): RedirectResponse
    {
        // 入力されたパスワードで認証を実行
        if (!Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            // 認証に失敗した場合、例外をスロー
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        // パスワード確認時刻をセッションに保存
        $request->session()->put('auth.password_confirmed_at', time());

        // ダッシュボードまたは直前のURLにリダイレクト
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
