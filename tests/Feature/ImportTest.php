<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * インポート機能に関するテストクラス
 */
class ImportTest extends TestCase
{
    // テスト実行時にデータベースをリフレッシュするトレイトを使用
    use RefreshDatabase;

    /**
     * ユーザーがCSVファイルをアップロードして会社データをインポートできることをテスト
     *
     * @return void
     */
    public function test_user_can_import_companies_data(): void
    {
        // テスト用ユーザーを作成
        $user = User::factory()->create();

        // ユーザーをログイン状態に設定
        $this->actingAs($user);

        // 仮想ストレージを設置
        Storage::fake('local');

        // テスト用CSVファイルを作成（ヘッダー行を含むデータ）
        $file = UploadedFile::fake()->createWithContent(
            'companies.csv',
            "Name,URL,Status,Remarks,User ID\n" . // ヘッダー行
            "CompanyA,http://www.company-a.com,active,none,{$user->id}\n" . // データ行
            "CompanyB,http://www.company-b.com,inactive,none,{$user->id}" // データ行
        );

        // インポートリクエストを送信（会社データのアップロード）
        $response = $this->post('/import/companies', [
            'file' => $file,
        ]);

        // セッションにエラーがないことを確認
        $response->assertSessionHasNoErrors();

        // インポート処理完了後のリダイレクト先を確認
        $response->assertRedirect('/');

        // データベースにインポートされたデータが存在することを確認
        $this->assertDatabaseHas('companies', [
            'name' => 'CompanyA',
            'url' => 'http://www.company-a.com',
            'status' => 'active',
            'remarks' => 'none',
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('companies', [
            'name' => 'CompanyB',
            'url' => 'http://www.company-b.com',
            'status' => 'inactive',
            'remarks' => 'none',
            'user_id' => $user->id,
        ]);
    }

    /**
     * ユーザーがCSVファイルをアップロードして人物データをインポートできることをテスト
     *
     * @return void
     */
    public function test_user_can_import_people_data(): void
    {
        // テスト用ユーザーを作成
        $user = User::factory()->create();

        // ユーザーをログイン状態に設定
        $this->actingAs($user);

        // 仮想ストレージを設置
        Storage::fake('local');

        // テスト用CSVファイルを作成（ヘッダー行を含むデータ）
        $file = UploadedFile::fake()->createWithContent(
            'people.csv',
            "Person Name,Contact,Status,Remarks,Company Name\n" . // ヘッダー行
            "John Doe,john@example.com,active,none,\n" . // データ行
            "Jane Smith,jane@example.com,inactive,none," // データ行
        );

        // インポートリクエストを送信（人物データのアップロード）
        $response = $this->post('/import/people', [
            'file' => $file,
        ]);

        // セッションにエラーがないことを確認
        $response->assertSessionHasNoErrors();

        // インポート処理完了後のリダイレクト先を確認
        $response->assertRedirect('/');

        // データベースにインポートされたデータが存在することを確認
        $this->assertDatabaseHas('people', [
            'name' => 'John Doe',
            'contact' => 'john@example.com',
            'status' => 'active',
            'remarks' => 'none',
        ]);
        $this->assertDatabaseHas('people', [
            'name' => 'Jane Smith',
            'contact' => 'jane@example.com',
            'status' => 'inactive',
            'remarks' => 'none',
        ]);
    }

    /**
     * 不正なファイルがアップロードされた場合にエラーが返されることをテスト
     *
     * @return void
     */
    public function test_invalid_file_upload_throws_error(): void
    {
        // テスト用ユーザーを作成
        $user = User::factory()->create();

        // ユーザーをログイン状態に設定
        $this->actingAs($user);

        // 仮想ストレージを設置
        Storage::fake('local');

        // テスト用の無効なファイルを作成（CSVではないファイル）
        $file = UploadedFile::fake()->create('test.txt', 100, 'text/plain');

        // 無効なファイルをアップロードしてリクエストを送信（会社データ）
        $response = $this->post('/import/companies', [
            'file' => $file,
        ]);

        // セッションにエラーが存在することを確認
        $response->assertSessionHasErrors(['file']);

        // データベースに新しいデータが作成されていないことを確認
        $this->assertDatabaseCount('companies', 0);

        // 無効なファイルをアップロードしてリクエストを送信（人物データ）
        $response = $this->post('/import/people', [
            'file' => $file,
        ]);

        // セッションにエラーが存在することを確認
        $response->assertSessionHasErrors(['file']);

        // データベースに新しいデータが作成されていないことを確認
        $this->assertDatabaseCount('people', 0);
    }
}
