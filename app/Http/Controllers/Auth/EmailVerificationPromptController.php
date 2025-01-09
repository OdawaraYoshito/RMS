<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * メール認証プロンプトを表示
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // すでにメール認証済みの場合、ダッシュボードにリダイレクト
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('dashboard', absolute: false))
            : view('auth.verify-email'); // 未認証の場合、メール認証ビューを表示
    }
}
