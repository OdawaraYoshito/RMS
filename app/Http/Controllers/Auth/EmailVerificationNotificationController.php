<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * 新しいメール認証通知を送信
     */
    public function store(Request $request): RedirectResponse
    {
        // すでに認証済みのユーザの場合、ダッシュボードにリダイレクト
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // 認証メールを送信
        $request->user()->sendEmailVerificationNotification();

        // 成功ステータスと共に元のページにリダイレクト
        return back()->with('status', 'verification-link-sent');
    }
}
