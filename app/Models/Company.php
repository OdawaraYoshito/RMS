<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Company extends Model
{
    use HasFactory;

    /**
     * 一括割り当てを許可するフィールド
     *
     * @var array
     */
    protected $fillable = [
        'name',       // 必須: 会社名 (最大255文字)
        'url',        // 任意: 会社のURL (有効なURL形式)
        'status',     // 必須: ステータス ("active" または "inactive")
        'remarks',    // 任意: 備考 (最大1000文字)
        'user_id',    // 必須: 所有するユーザのID (外部キー)
    ];

    /**
     * リレーション: 会社に関連する人物を取得
     */
    public function people()
    {
        return $this->hasMany(Person::class);
    }

    /**
     * リレーション: この会社を所有するユーザを取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * スコープ: 指定されたユーザが所有する会社のみをクエリに適用
     */
    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * スコープ: フィルタ条件をクエリに適用
     */
    public function scopeFilter($query, array $filters)
    {
        // 必要なフィルタ条件のみ取得
        $filters = Arr::only($filters, ['name', 'status']);

        if (!empty($filters['name'])) {
            $query->where('name', 'LIKE', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query;
    }
}
