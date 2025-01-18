<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // id=77 のテストユーザを作成
        $user = User::firstOrCreate(
            ['id' => 77],
            [
                'name' => 'Test User 77',
                'email' => 'test77@example.com',
                'password' => bcrypt('password111'),
            ]
        );

        // テストデータを一括登録
        // 作成したユーザに紐づく会社100件を作成
        Company::factory(100)->create([
            'user_id' => $user->id,
        ]);

        // 作成したユーザに紐づく人物100件を作成
        Person::factory(100)->create([
            'user_id' => $user->id,
        ]);
    }
}
