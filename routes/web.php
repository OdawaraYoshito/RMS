<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HelpController;
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

// お問い合わせページ（認証不要）
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send'); // お問い合わせフォーム送信

// ヘルプページ（認証不要）
Route::get('/help', [HelpController::class, 'index'])->name('help');

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

// インポート/エクスポート機能（認証が必要）
Route::middleware(['auth'])->group(function () {
    // エクスポートルート
    Route::get('/export/companies', [ImportExportController::class, 'exportCompanies'])
        ->name('export.companies'); // format=xlsx または format=csv をクエリに指定
    Route::get('/export/people', [ImportExportController::class, 'exportPeople'])
        ->name('export.people'); // format=xlsx または format=csv をクエリに指定

    // インポートルート
    Route::post('/import/companies', [ImportExportController::class, 'importCompanies'])->name('import.companies');
    Route::post('/import/people', [ImportExportController::class, 'importPeople'])->name('import.people');
});

// Breeze の認証関連ルート（auth.phpで定義）
require __DIR__ . '/auth.php';
