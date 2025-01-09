<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * 現在ファクトリで使用されているパスワード
     */
    protected static ?string $password;

    /**
     * モデルのデフォルト状態を定義
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),                          // ユーザの名前
            'email' => fake()->unique()->safeEmail(),          // ユニークなメールアドレス
            'email_verified_at' => now(),                     // メール確認日時
            'password' => static::$password ??= Hash::make('password'), // ハッシュ化されたパスワード
            'remember_token' => Str::random(10),              // "Remember Me" トークン
        ];
    }

    /**
     * モデルのメールアドレスが未確認であることを示す状態を定義
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null, // メール確認日時をリセット
        ]);
    }
}
