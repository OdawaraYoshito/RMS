<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Company;
use App\Models\User;
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
            // データベース内のランダムなユーザIDを取得(ユーザが存在しない場合、新規作成)
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory()->create()->id,
            'name' => $this->faker->name, // 人物名
            'company_id' => Company::inRandomOrder()->first()->id ?? null, // ランダムな会社に紐付け（存在しない場合はnull）
            'contact' => $this->faker->safeEmail, // メールアドレス
            'status' => $this->faker->randomElement(['active', 'inactive']), // ステータス（activeまたはinactive）
            'remarks' => $this->faker->sentence, // 備考（1文）
        ];
    }
}
