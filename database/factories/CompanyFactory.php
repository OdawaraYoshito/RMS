<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * このファクトリで対応するモデルクラス.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * モデルのデフォルト状態を定義.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // データベース内のランダムなユーザIDを取得(ユーザが存在しない場合、新規作成)
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory()->create()->id,
            'name' => $this->faker->company, // 会社名
            'url' => $this->faker->url, // 会社のウェブサイトURL
            'status' => $this->faker->randomElement(['active', 'inactive']), // ステータス（activeまたはinactive）
            'remarks' => $this->faker->sentence, // 備考（1文）
        ];
    }
}
