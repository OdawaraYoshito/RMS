<?php

/**
 * 登録画面が正常に表示されることをテスト
 */
test('registration screen can be rendered', function (): void {
    // 登録画面にGETリクエストを送信
    $response = $this->get('/register');

    // ステータスコード200（成功）を確認
    $response->assertStatus(200);
});

/**
 * 新しいユーザーが正常に登録できることをテスト
 */
test('new users can register', function (): void {
    // ユーザー登録リクエストを送信
    $response = $this->post('/register', [
        'name' => 'Test User', // テスト用ユーザー名
        'email' => 'test@example.com', // テスト用メールアドレス
        'password' => 'password', // パスワード
        'password_confirmation' => 'password', // パスワード確認
    ]);

    // 認証されていることを確認
    $this->assertAuthenticated();

    // ダッシュボードへのリダイレクトを確認
    $response->assertRedirect(route('dashboard', absolute: false));
});
