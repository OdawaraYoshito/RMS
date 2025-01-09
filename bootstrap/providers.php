<?php

/**
 * アプリケーションで使用するサービスプロバイダを登録するファイル
 *
 * この配列には、アプリケーション全体で必要なサービスプロバイダを指定します。
 * 各プロバイダは、Laravelのサービスコンテナを通じて自動的に解決されます。
 */

return [
    // 基本的なアプリケーションサービスを提供するプロバイダ
    App\Providers\AppServiceProvider::class,

    // 認証や認可関連のサービスを提供するプロバイダ
    App\Providers\AuthServiceProvider::class,
];
