<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/**
 * Artisanコマンドを定義するファイル
 *
 * このファイルは、Artisan CLIに新しいコマンドを追加するために使用されます。
 * ArtisanはLaravelのコマンドラインツールで、タスクの自動化やメンテナンス作業に役立ちます。
 */

/**
 * `inspire` コマンド
 *
 * 実行するとランダムな名言を表示します。たとえば、以下のコマンドで使用できます:
 * php artisan inspire
 */
Artisan::command('inspire', function () {
    // ランダムな名言を取得して表示
    $this->comment(Inspiring::quote());
})
    ->purpose('ランダムな名言を表示') // コマンドの目的を説明（`php artisan list`で表示される）
    ->hourly(); // 毎時実行するようスケジュール可能
