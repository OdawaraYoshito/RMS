<?php

use App\Models\User;

/**
 * パスワード確認画面が正しく表示されることをテスト
 */
test('confirm password screen can be rendered', function (): void {
    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // パスワード確認画面にアクセス
    $response = $this->actingAs($user)->get('/confirm-password');

    // ステータスコード200（成功）を確認
    $response->assertStatus(200);
});

/**
 * 正しいパスワードでパスワード確認が成功することをテスト
 */
test('password can be confirmed', function (): void {
    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // 正しいパスワードでパスワード確認リクエストを送信
    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'password',
    ]);

    // リダイレクトが発生し、エラーがないことを確認
    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

/**
 * 間違ったパスワードでパスワード確認が失敗することをテスト
 */
test('password is not confirmed with invalid password', function (): void {
    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // 間違ったパスワードでパスワード確認リクエストを送信
    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'wrong-password',
    ]);

    // セッションにエラーが記録されていることを確認
    $response->assertSessionHasErrors();
});
