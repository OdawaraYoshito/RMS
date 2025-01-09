<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/**
 * アプリケーションの初期設定を行い、インスタンスを生成
 *
 * @return Application
 */
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // Webルートとコンソールルートを設定
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up', // ヘルスチェック用のエンドポイント
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ミドルウェアの登録処理を記述
        return Application::getInstance(); // アプリケーションインスタンスを返す
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // 例外ハンドリングの設定を記述
        return Application::getInstance(); // アプリケーションインスタンスを返す
    })
    ->create();
