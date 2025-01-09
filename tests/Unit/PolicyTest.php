<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Person;
use App\Models\User;
use Tests\TestCase;

class PolicyTest extends TestCase
{
    /**
     * 他のユーザの会社情報にアクセスできないことを確認するテスト
     */
    public function test_user_cannot_access_other_users_company()
    {
        // ログインユーザと別のユーザ、およびその会社情報を作成
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $otherUser->id]);

        // ログイン状態で他ユーザの会社編集画面にアクセス
        $this->actingAs($user);
        $response = $this->get("/companies/{$company->id}/edit");

        // アクセスが禁止されることを確認
        $response->assertForbidden();
    }

    /**
     * 他のユーザの人物情報にアクセスできないことを確認するテスト
     */
    public function test_user_cannot_access_other_users_person()
    {
        // ログインユーザと別のユーザ、およびその人物情報を作成
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $person = Person::factory()->create(['user_id' => $otherUser->id]);

        // ログイン状態で他ユーザの人物編集画面にアクセス
        $this->actingAs($user);
        $response = $this->get("/people/{$person->id}/edit");

        // アクセスが禁止されることを確認
        $response->assertForbidden();
    }
}
