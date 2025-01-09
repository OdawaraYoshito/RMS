<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * 認証済みユーザのメールアドレスを検証済みとしてマーク
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // すでにメール認証済みの場合、ダッシュボードにリダイレクト
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        // 初回認証時にメールを検証済みとしてマークし、イベントを発火
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user())); // メール認証イベント
        }

        // 成功時にダッシュボードへリダイレクト
        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
