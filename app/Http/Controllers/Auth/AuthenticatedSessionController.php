<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * ログイン画面を表示
     */
    public function create(): View
    {
        // ログインビューを返す
        return view('auth.login');
    }

    /**
     * 認証リクエストを処理
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 認証を実行
        $request->authenticate();

        // セッションを再生成してセッション固定攻撃を防止
        $request->session()->regenerate();

        // 現在の認証ユーザーを取得
        $user = Auth::user();

        // ユーザーがメール認証を完了しているかを確認し、未認証なら認証画面にリダイレクト
        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')->with('status', 'Please verify your email before accessing the system.');
        }

        // ダッシュボードまたは直前のURLにリダイレクト
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * 認証済みのセッションを破棄
     */
    public function destroy(Request $request): RedirectResponse
    {
        // ログアウト処理
        Auth::guard('web')->logout();

        // セッションを無効化
        $request->session()->invalidate();

        // 新しいセッショントークンを生成
        $request->session()->regenerateToken();

        // ホーム画面にリダイレクト
        return redirect('/');
    }
}
