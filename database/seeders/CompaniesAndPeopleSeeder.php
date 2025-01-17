<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Person;

class CompaniesAndPeopleSeeder extends Seeder
{
    public function run()
    {
        // テストユーザを作成
        $user = \App\Models\User::firstOrCreate([
            'email' => 'test@example.com'
        ], [
            'name' => 'Test User',
            'password' => bcrypt('password222')
        ]);

        // テスト会社を作成
        $company = Company::create([
            'name' => 'Test Company',
            'url' => 'https://example.com',
            'status' => 'active',
            'user_id' => $user->id,
        ]);

        // テスト人物を作成
        Person::create([
            'name' => 'Test Person',
            'company_id' => $company->id,
            'contact' => 'test@example.com',
            'status' => 'active',
            'user_id' => $user->id,
        ]);
    }
}

