<?php

use App\Models\User;

/**
 * ログイン画面が正しく表示されることをテスト
 */
test('login screen can be rendered', function (): void {
    // ログイン画面にアクセス
    $response = $this->get('/login');

    // ステータスコード200（成功）を確認
    $response->assertStatus(200);
});

/**
 * ユーザーがログイン画面を使用して認証できることをテスト
 */
test('users can authenticate using the login screen', function (): void {
    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // ログインリクエストを送信
    $response = $this->post('/login', [
        'email' => $user->email,    // 有効なメールアドレス
        'password' => 'password',  // 有効なパスワード
    ]);

    // ユーザーが認証されていることを確認
    $this->assertAuthenticated();

    // ダッシュボードにリダイレクトされていることを確認
    $response->assertRedirect(route('dashboard', absolute: false));
});

/**
 * ユーザーが無効なパスワードで認証できないことをテスト
 */
test('users can not authenticate with invalid password', function (): void {
    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // 無効なパスワードでログインリクエストを送信
    $this->post('/login', [
        'email' => $user->email,        // 有効なメールアドレス
        'password' => 'wrong-password', // 無効なパスワード
    ]);

    // ユーザーが認証されていないことを確認
    $this->assertGuest();
});

/**
 * ユーザーがログアウトできることをテスト
 */
test('users can logout', function (): void {
    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // ログアウトリクエストを送信
    $response = $this->actingAs($user)->post('/logout');

    // 認証が解除されていることを確認
    $this->assertGuest();

    // ホームページにリダイレクトされていることを確認
    $response->assertRedirect('/');
});
