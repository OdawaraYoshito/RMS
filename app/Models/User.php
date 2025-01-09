<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * 一括割り当て可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',      // 必須: ユーザ名 (最大255文字)
        'email',     // 必須: メールアドレス (ユニーク, 最大255文字)
        'password',  // 必須: ハッシュ化されたパスワード
    ];

    /**
     * シリアライズ時に非表示にする属性
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',        // パスワード
        'remember_token',  // "Remember Me" トークン
    ];

    /**
     * キャストを適用する属性
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // メール確認日時をDateTime型にキャスト
        'password' => 'hashed',           // パスワードを自動的にハッシュ化
    ];

    /**
     * ユーザが所有する会社を取得するリレーション
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    /**
     * ユーザが管理する人物を取得するリレーション
     */
    public function people(): HasManyThrough
    {
        return $this->hasManyThrough(Person::class, Company::class);
    }
}
