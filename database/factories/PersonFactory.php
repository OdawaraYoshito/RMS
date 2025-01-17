<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * このファクトリで対応するモデルクラス.
     *
     * @var string
     */
    protected $model = Person::class;

    /**
     * モデルのデフォルト状態を定義.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 5, // ユーザID（必要に応じて変更可能）
            'name' => $this->faker->name, // 人物名
            'company_id' => Company::inRandomOrder()->first()->id ?? null, // ランダムな会社に紐付け（存在しない場合はnull）
            'contact' => $this->faker->safeEmail, // メールアドレス
            'status' => $this->faker->randomElement(['active', 'inactive']), // ステータス（activeまたはinactive）
            'remarks' => $this->faker->sentence, // 備考（1文）
        ];
    }
}
