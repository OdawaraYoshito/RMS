<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Person;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // 対象ユーザーIDを指定
        $userId = 5;

        // 会社100件を作成
        Company::factory(100)->create([
            'user_id' => $userId, // ユーザーIDを指定
        ])->each(function ($company) use ($userId) {
            // 各会社に関連する人物を作成
            Person::factory(1)->create([
                'company_id' => $company->id,
                'user_id' => $userId, // ユーザーIDを指定
            ]);
        });
    }
}
