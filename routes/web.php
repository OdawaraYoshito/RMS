<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| アプリケーションのWebルートを定義します。
| これらのルートは RouteServiceProvider によってロードされます。
|--------------------------------------------------------------------------
*/

// トップページ（認証不要）
Route::get('/', WelcomeController::class)->name('welcome');

// 会社の管理機能（認証が必要）
Route::resource('companies', CompanyController::class)
    ->middleware(['auth']);

// 人物の管理機能（認証が必要）
Route::resource('people', PersonController::class)
    ->middleware(['auth']);

// ダッシュボード（認証＆メール認証が必要）
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// プロフィール設定（認証が必要）
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // プロフィール編集
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // プロフィール更新
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // プロフィール削除
});

// Breeze の認証関連ルート（auth.phpで定義）
require __DIR__ . '/auth.php';
