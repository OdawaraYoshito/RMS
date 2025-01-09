<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * パスワードが正常に更新されることをテスト
 */
test('password can be updated', function (): void {
    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // パスワード更新リクエストを送信
    $response = $this
        ->actingAs($user) // ログイン中のユーザーとしてアクションを実行
        ->from('/profile') // リクエスト前のページ
        ->put('/password', [ // パスワード更新エンドポイント
            'current_password' => 'password', // 現在のパスワード
            'password' => 'new-password', // 新しいパスワード
            'password_confirmation' => 'new-password', // 新しいパスワード（確認用）
        ]);

    // エラーがないことと、プロフィールページへのリダイレクトを確認
    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    // 新しいパスワードが正しく設定されたことを確認
    $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
});

/**
 * 正しい現在のパスワードを入力しないと更新できないことをテスト
 */
test('correct password must be provided to update password', function (): void {
    // テスト用ユーザーを作成
    $user = User::factory()->create();

    // 誤った現在のパスワードを使用して更新リクエストを送信
    $response = $this
        ->actingAs($user) // ログイン中のユーザーとしてアクションを実行
        ->from('/profile') // リクエスト前のページ
        ->put('/password', [ // パスワード更新エンドポイント
            'current_password' => 'wrong-password', // 間違った現在のパスワード
            'password' => 'new-password', // 新しいパスワード
            'password_confirmation' => 'new-password', // 新しいパスワード（確認用）
        ]);

    // エラーが表示され、プロフィールページにリダイレクトされることを確認
    $response
        ->assertSessionHasErrorsIn('updatePassword', 'current_password')
        ->assertRedirect('/profile');
});
