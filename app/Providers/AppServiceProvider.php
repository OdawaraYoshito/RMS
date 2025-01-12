<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

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
     *
     * @param UrlGenerator $url
     */
    public function boot(UrlGenerator $url): void
    {
        // HTTPSを強制する設定を追加
        // 本番環境（production）の場合、すべてのURLをHTTPSスキームで生成するように設定
        if (env('APP_ENV') === 'production') {
            $url->forceScheme('https');
        }

        // 必要に応じて設定を追加
        // 例: ページネーションのデフォルトスタイル変更など
        // Paginator::useBootstrap();
    }
}
