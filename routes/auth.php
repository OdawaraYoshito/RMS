<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| 認証に関連するルートを定義します。
| グループに分けてゲストまたは認証済みユーザー用のルートを整理しています。
|--------------------------------------------------------------------------
*/

// ゲストのみアクセス可能なルート
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register'); // 新規登録フォーム
    Route::post('register', [RegisteredUserController::class, 'store']); // 新規登録処理
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login'); // ログインフォーム
    Route::post('login', [AuthenticatedSessionController::class, 'store']); // ログイン処理
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request'); // パスワードリセットリンク要求フォーム
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email'); // リンク送信処理
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset'); // パスワードリセットフォーム
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store'); // パスワードリセット処理
});

// 認証済みユーザーのみアクセス可能なルート
Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice'); // メール認証案内
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify'); // メール認証処理
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send'); // 認証リンク再送信
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm'); // パスワード確認フォーム
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']); // パスワード確認処理
    Route::put('password', [PasswordController::class, 'update'])->name('password.update'); // パスワード更新
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout'); // ログアウト
});
