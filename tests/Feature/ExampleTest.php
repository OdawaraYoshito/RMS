<?php

/**
 * サンプルテスト
 * Laravelでの基本的なテスト記述の例
 */
it('returns a successful response', function () {
    // ホームページにアクセスしてステータスコード200（成功）を確認
    $response = $this->get('/');

    $response->assertStatus(200);
});
