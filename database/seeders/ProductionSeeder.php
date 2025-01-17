<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Person;

class ProductionSeeder extends Seeder
{
    public function run()
    {
        // 管理ユーザー（テスト用）を作成
        $user = User::firstOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Admin User',
            'password' => bcrypt('password111'), // テスト用簡易パスワード。運用時には削除すること
        ]);

        // 初期会社データを作成
        $company = Company::firstOrCreate([
            'name' => 'Default Company'
        ], [
            'url' => 'https://default-company.com',
            'status' => 'active',
            'user_id' => $user->id,
        ]);

        // 初期人物データを作成
        Person::firstOrCreate([
            'name' => 'Default Person',
            'company_id' => $company->id,
        ], [
            'contact' => 'default.person@example.com',
            'status' => 'active',
            'user_id' => $user->id,
        ]);
    }
}
