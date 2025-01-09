<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * 会社情報に関連する機能のテストクラス
 */
class CompanyTest extends TestCase
{
    // テスト実行時にデータベースをリフレッシュするトレイトを使用
    use RefreshDatabase;

    /**
     * ユーザーが新しい会社を作成できることをテスト
     *
     * @return void
     */
    public function test_user_can_create_company(): void
    {
        // テスト用ユーザーを作成してログイン
        $user = User::factory()->create();
        $this->actingAs($user);

        // 会社作成リクエストを送信
        $response = $this->post('/companies', [
            'name' => 'Test Company',          // 会社名
            'url' => 'https://example.com',    // 会社URL
            'status' => 'active',              // ステータス
            'remarks' => 'Test remarks',       // 備考
        ]);

        // 一覧ページへのリダイレクトを確認
        $response->assertRedirect('/companies');

        // データベースに新しい会社が存在することを確認
        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
        ]);
    }

    /**
     * ユーザーが会社情報を閲覧できることをテスト
     *
     * @return void
     */
    public function test_user_can_view_companies(): void
    {
        // テスト用ユーザーを作成
        $user = User::factory()->create();

        // テスト用会社を作成
        $company = Company::factory()->create(['user_id' => $user->id]);

        // ユーザーをログイン状態に設定
        $this->actingAs($user);

        // 一覧ページにアクセス
        $response = $this->get('/companies');

        // レスポンスが成功（200）であることを確認
        $response->assertOk();

        // レスポンスに会社名が含まれていることを確認
        $response->assertSee($company->name);
    }

    /**
     * ユーザーが会社情報を更新できることをテスト
     *
     * @return void
     */
    public function test_user_can_update_company(): void
    {
        // テスト用ユーザーと会社を作成
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);

        // ユーザーをログイン状態に設定
        $this->actingAs($user);

        // 会社更新リクエストを送信
        $response = $this->put("/companies/{$company->id}", [
            'name' => 'Updated Company',       // 更新後の会社名
            'url' => $company->url,           // 既存のURL
            'status' => 'inactive',           // ステータスを変更
            'remarks' => $company->remarks,   // 既存の備考
        ]);

        // 一覧ページへのリダイレクトを確認
        $response->assertRedirect('/companies');

        // データベースに更新後の情報が存在することを確認
        $this->assertDatabaseHas('companies', [
            'name' => 'Updated Company',
        ]);
    }

    /**
     * ユーザーが会社情報を削除できることをテスト
     *
     * @return void
     */
    public function test_user_can_delete_company(): void
    {
        // テスト用ユーザーと会社を作成
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);

        // ユーザーをログイン状態に設定
        $this->actingAs($user);

        // 会社削除リクエストを送信
        $response = $this->delete("/companies/{$company->id}");

        // 一覧ページへのリダイレクトを確認
        $response->assertRedirect('/companies');

        // データベースに会社情報が存在しないことを確認
        $this->assertDatabaseMissing('companies', [
            'id' => $company->id,
        ]);
    }
}
