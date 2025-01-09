<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * アプリケーションサービスを登録
     *
     * このメソッドはサービスコンテナにアプリケーション固有のサービスをバインドします。
     */
    public function register(): void
    {
        // 必要に応じてサービスを登録
    }

    /**
     * アプリケーションサービスの初期設定
     *
     * アプリケーション起動時に必要な設定を行います。
     */
    public function boot(): void
    {
        // 必要に応じて設定を追加
        // 例: ページネーションのデフォルトスタイル変更など
        // Paginator::useBootstrap();
    }
}
