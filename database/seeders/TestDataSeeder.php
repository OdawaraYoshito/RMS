<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Person;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // テストデータを一括登録
        // 会社100件を作成
        Company::factory(100)->create();

        // 人物100件を作成
        Person::factory(100)->create();
    }
}
