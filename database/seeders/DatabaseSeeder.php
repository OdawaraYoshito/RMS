<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // 本番環境用の初期データ
        $this->call(ProductionSeeder::class);

        // テストデータ
        $this->call(TestDataSeeder::class);
    }
}
