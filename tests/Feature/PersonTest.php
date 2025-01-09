<?php

namespace Tests\Feature;

use App\Models\Person;
use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * 人物情報に関連する機能のテストクラス
 */
class PersonTest extends TestCase
{
    // テスト実行時にデータベースをリフレッシュするトレイトを使用
    use RefreshDatabase;

    /**
     * ユーザーが新しい人物情報を作成できることをテスト
     *
     * @return void
     */
    public function test_user_can_create_person(): void
    {
        // テスト用ユーザーと会社を作成
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);

        // ユーザーをログイン状態に設定
        $this->actingAs($user);

        // 人物作成リクエストを送信
        $response = $this->post('/people', [
            'name' => 'John Doe',                 // 名前
            'company_id' => $company->id,         // 所属会社ID
            'contact' => 'john@example.com',      // 連絡先
            'status' => 'active',                 // ステータス
            'remarks' => 'Some remarks',          // 備考
        ]);

        // 一覧ページへのリダイレクトを確認
        $response->assertRedirect('/people');

        // データベースに新しい人物情報が存在することを確認
        $this->assertDatabaseHas('people', [
            'name' => 'John Doe',
        ]);
    }

    /**
     * ユーザーが人物情報を閲覧できることをテスト
     *
     * @return void
     */
    public function test_user_can_view_people(): void
    {
        // テスト用ユーザーと人物を作成
        $user = User::factory()->create();
        $person = Person::factory()->create(['user_id' => $user->id]);

        // ユーザーをログイン状態に設定
        $this->actingAs($user);

        // 人物一覧ページにアクセス
        $response = $this->get('/people');

        // レスポンスが成功（200）であることを確認
        $response->assertOk();

        // レスポンスに人物の名前が含まれていることを確認
        $response->assertSee($person->name);
    }

    /**
     * ユーザーが人物情報を更新できることをテスト
     *
     * @return void
     */
    public function test_user_can_update_person(): void
    {
        // テスト用ユーザーと人物を作成
        $user = User::factory()->create();
        $person = Person::factory()->create(['user_id' => $user->id]);

        // ユーザーをログイン状態に設定
        $this->actingAs($user);

        // 人物情報更新リクエストを送信
        $response = $this->put("/people/{$person->id}", [
            'name' => 'Jane Doe',                 // 更新後の名前
            'company_id' => $person->company_id, // 所属会社IDは既存のものを使用
            'contact' => 'jane@example.com',      // 更新後の連絡先
            'status' => 'inactive',               // ステータスを変更
            'remarks' => 'Updated remarks',       // 更新後の備考
        ]);

        // 一覧ページへのリダイレクトを確認
        $response->assertRedirect('/people');

        // データベースに更新後の情報が存在することを確認
        $this->assertDatabaseHas('people', [
            'name' => 'Jane Doe',
        ]);
    }

    /**
     * ユーザーが人物情報を削除できることをテスト
     *
     * @return void
     */
    public function test_user_can_delete_person(): void
    {
        // テスト用ユーザーと人物を作成
        $user = User::factory()->create();
        $person = Person::factory()->create(['user_id' => $user->id]);

        // ユーザーをログイン状態に設定
        $this->actingAs($user);

        // 人物削除リクエストを送信
        $response = $this->delete("/people/{$person->id}");

        // 一覧ページへのリダイレクトを確認
        $response->assertRedirect('/people');

        // データベースに削除された人物情報が存在しないことを確認
        $this->assertDatabaseMissing('people', [
            'id' => $person->id,
        ]);
    }
}
