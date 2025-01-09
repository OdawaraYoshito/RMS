<?php

use App\Models\User;

/**
 * プロフィールページの表示に関するテスト
 */
test('profile page is displayed', function (): void {
    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // プロフィールページにアクセス
    $response = $this
        ->actingAs($user) // ログイン状態を設定
        ->get('/profile');

    // ステータスコード200（成功）を確認
    $response->assertOk();
});

/**
 * プロフィール情報を更新できることをテスト
 */
test('profile information can be updated', function (): void {
    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // プロフィール更新リクエストを送信
    $response = $this
        ->actingAs($user) // ログイン状態を設定
        ->patch('/profile', [
            'name' => 'Test User',           // 新しい名前
            'email' => 'test@example.com',   // 新しいメールアドレス
        ]);

    // エラーが発生していないこととリダイレクトを確認
    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    // ユーザー情報が更新されていることを確認
    $user->refresh(); // モデルの最新状態を取得
    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);

    // メールアドレスの確認状態がリセットされていることを確認
    $this->assertNull($user->email_verified_at);
});

/**
 * メールアドレスが変更されていない場合、メール確認ステータスが保持されることをテスト
 */
test('email verification status is unchanged when the email address is unchanged', function (): void {
    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // プロフィール更新リクエスト（メールアドレスを変更しない）
    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User', // 新しい名前
            'email' => $user->email, // 既存のメールアドレスをそのまま使用
        ]);

    // エラーが発生していないこととリダイレクトを確認
    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    // メール確認ステータスが保持されていることを確認
    $this->assertNotNull($user->refresh()->email_verified_at);
});

/**
 * ユーザーがアカウントを削除できることをテスト
 */
test('user can delete their account', function (): void {
    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // アカウント削除リクエストを送信
    $response = $this
        ->actingAs($user) // ログイン状態を設定
        ->delete('/profile', [
            'password' => 'password', // 正しいパスワードを送信
        ]);

    // エラーが発生していないこととリダイレクトを確認
    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    // ユーザーが削除され、認証状態が解除されていることを確認
    $this->assertGuest();
    $this->assertNull($user->fresh());
});

/**
 * アカウント削除時に正しいパスワードが必要であることをテスト
 */
test('correct password must be provided to delete account', function (): void {
    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // アカウント削除リクエスト（間違ったパスワードを送信）
    $response = $this
        ->actingAs($user)
        ->from('/profile') // 元のページを設定
        ->delete('/profile', [
            'password' => 'wrong-password', // 間違ったパスワード
        ]);

    // エラーが発生していることとリダイレクトを確認
    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password') // パスワードエラーを確認
        ->assertRedirect('/profile'); // 元のページにリダイレクト

    // ユーザーが削除されていないことを確認
    $this->assertNotNull($user->fresh());
});
