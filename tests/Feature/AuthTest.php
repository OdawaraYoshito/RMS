<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * 認証に関するテストを行うクラス
 */
class AuthTest extends TestCase
{
    // テスト実行時にデータベースをリフレッシュするトレイトを使用
    use RefreshDatabase;

    /**
     * ユーザー登録が成功することをテスト
     *
     * @return void
     */
    public function test_user_can_register(): void
    {
        // ユーザー登録フォームにデータを送信
        $response = $this->post('/register', [
            'name' => 'Test User',                       // 名前
            'email' => 'test@example.com',              // メールアドレス
            'password' => 'password',                   // パスワード
            'password_confirmation' => 'password',      // パスワードの確認
        ]);

        // ダッシュボードへのリダイレクトを確認
        $response->assertRedirect('/dashboard');

        // ユーザーがデータベースに登録されていることを確認
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /**
     * ユーザーがログインできることをテスト
     *
     * @return void
     */
    public function test_user_can_login(): void
    {
        // テスト用ユーザーを作成
        $user = User::factory()->create([
            'password' => bcrypt('password'), // 暗号化されたパスワード
        ]);

        // ログインフォームにデータを送信
        $response = $this->post('/login', [
            'email' => $user->email,          // メールアドレス
            'password' => 'password',        // パスワード
        ]);

        // ダッシュボードへのリダイレクトを確認
        $response->assertRedirect('/dashboard');

        // ログイン状態を確認
        $this->assertAuthenticatedAs($user);
    }

    /**
     * ユーザーがログアウトできることをテスト
     *
     * @return void
     */
    public function test_user_can_logout(): void
    {
        // テスト用ユーザーを作成し、ログイン状態に設定
        $user = User::factory()->create();
        $this->actingAs($user);

        // ログアウトリクエストを送信
        $response = $this->post('/logout');

        // ホームページへのリダイレクトを確認
        $response->assertRedirect('/');

        // ゲスト状態を確認
        $this->assertGuest();
    }
}
