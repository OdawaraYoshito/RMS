<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Company;
use App\Models\Person;

/**
 * エクスポート機能に関するテストクラス
 */
class ExportTest extends TestCase
{
    // テスト実行時にデータベースをリフレッシュするトレイトを使用
    use RefreshDatabase;

    /**
     * 認証ユーザー
     *
     * @var User
     */
    protected User $user;

    /**
     * 各テストの事前準備
     */
    protected function setUp(): void
    {
        parent::setUp();

        // テスト用ユーザーを作成し認証状態に設定
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /**
     * 会社情報をエクスポートする機能のテスト
     */
    public function testExportCompanies()
    {
        // ダミーの会社情報を作成
        Company::factory()->count(5)->create(['user_id' => $this->user->id]);

        // エクスポート用ルートにリクエストを送信
        $response = $this->get('/export/companies?format=xlsx');

        // レスポンスが成功することを確認
        $response->assertStatus(200);

        // 正しいファイルタイプが返されることを確認
        $this->assertTrue($response->headers->get('content-type') === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /**
     * 人物情報をエクスポートする機能のテスト
     */
    public function testExportPeople()
    {
        // ダミーの会社と人物情報を作成
        $company = Company::factory()->create(['user_id' => $this->user->id]);
        Person::factory()->count(5)->create([
            'user_id' => $this->user->id,
            'company_id' => $company->id,
        ]);

        // エクスポート用ルートにリクエストを送信
        $response = $this->get('/export/people?format=xlsx');

        // レスポンスが成功することを確認
        $response->assertStatus(200);

        // 正しいファイルタイプが返されることを確認
        $this->assertTrue($response->headers->get('content-type') === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /**
     * 未対応のフォーマットでエクスポートする場合のテスト
     */
    public function testExportCompaniesWithUnsupportedFormat()
    {
        // ダミーの会社情報を作成
        Company::factory()->count(5)->create(['user_id' => $this->user->id]);

        // 未対応のフォーマットでリクエストを送信
        $response = $this->get('/export/companies?format=txt');

        // レスポンスがエラーになることを確認
        $response->assertStatus(500);
    }
}
