<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

/**
 * パスワードリセットリンク画面が正しく表示されることをテスト
 */
test('reset password link screen can be rendered', function (): void {
    // パスワードリセットリンク画面にアクセス
    $response = $this->get('/forgot-password');

    // ステータスコード200（成功）を確認
    $response->assertStatus(200);
});

/**
 * パスワードリセットリンクがリクエストできることをテスト
 */
test('reset password link can be requested', function (): void {
    // 通知をモック化
    Notification::fake();

    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // パスワードリセットリンクをリクエスト
    $this->post('/forgot-password', ['email' => $user->email]);

    // リセットパスワード通知が送信されたことを確認
    Notification::assertSentTo($user, ResetPassword::class);
});

/**
 * パスワードリセット画面が正しく表示されることをテスト
 */
test('reset password screen can be rendered', function (): void {
    // 通知をモック化
    Notification::fake();

    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // パスワードリセットリンクをリクエスト
    $this->post('/forgot-password', ['email' => $user->email]);

    // リセットパスワード通知が送信されたことを確認
    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        // パスワードリセット画面にアクセス
        $response = $this->get('/reset-password/' . $notification->token);

        // ステータスコード200（成功）を確認
        $response->assertStatus(200);

        return true;
    });
});

/**
 * 有効なトークンでパスワードがリセットできることをテスト
 */
test('password can be reset with valid token', function (): void {
    // 通知をモック化
    Notification::fake();

    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // パスワードリセットリンクをリクエスト
    $this->post('/forgot-password', ['email' => $user->email]);

    // リセットパスワード通知が送信されたことを確認
    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        // パスワードリセットを実行
        $response = $this->post('/reset-password', [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // エラーがないことと、ログイン画面へのリダイレクトを確認
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));

        return true;
    });
});
