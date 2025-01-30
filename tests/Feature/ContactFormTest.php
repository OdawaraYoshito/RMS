<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

/**
 * お問い合わせフォームに関連する機能のテストクラス
 */
class ContactFormTest extends TestCase
{
    // テスト実行時にデータベースをリフレッシュするトレイトを使用
    use RefreshDatabase;

    /**
     * ユーザーが正しい情報でお問い合わせフォームを送信できることをテスト
     *
     * @return void
     */
    public function test_user_can_submit_contact_form(): void
    {
        // テスト用ユーザーを作成し認証状態に設定
        $user = User::factory()->create();
        $this->actingAs($user);

        // フォーム送信リクエストを送信
        $response = $this->post('/contact', [
            'name' => 'Test User',                     // 名前
            'email' => 'test@example.com',             // メールアドレス
            'subject' => 'Test Subject',               // 件名
            'message' => 'This is a test message.',    // メッセージ
        ]);

        // セッションにエラーがないことを確認
        $response->assertSessionHasNoErrors();

        // フォーム送信後のリダイレクトを確認
        $response->assertRedirect('/contact');
    }

    /**
     * フォームに無効なデータが送信された場合、バリデーションエラーが発生することをテスト
     *
     * @return void
     */
    public function test_contact_form_requires_valid_data(): void
    {
        // バリデーションエラーを想定してリクエストを送信（すべてのフィールドを空にする）
        $response = $this->post('/contact', []);

        // バリデーションエラーが発生することを確認
        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

        // 無効なメールアドレスを送信
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'invalid-email', // 無効な形式のメールアドレス
            'subject' => 'Test Subject', // 件名
            'message' => 'Test message',
        ]);

        // emailフィールドでバリデーションエラーが発生することを確認
        $response->assertSessionHasErrors(['email']);
    }

    /**
     * 未認証ユーザーでもお問い合わせフォームを送信できることをテスト
     *
     * @return void
     */
    public function test_guest_can_submit_contact_form(): void
    {
        // 未認証状態でフォーム送信リクエストを送信
        $response = $this->post('/contact', [
            'name' => 'Guest User',                   // 名前
            'email' => 'guest@example.com',           // メールアドレス
            'subject' => 'Guest Subject',             // 件名
            'message' => 'Guest test message.',       // メッセージ
        ]);

        // フォーム送信後のリダイレクトを確認
        $response->assertRedirect('/contact');
    }
}
