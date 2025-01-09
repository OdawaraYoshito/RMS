<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

class Person extends Model
{
    use HasFactory;

    /**
     * 一括割り当て可能な属性のリスト
     *
     * @var array
     */
    protected $fillable = [
        'name',        // 必須: 名前 (最大255文字)
        'company_id',  // 任意: 所属会社ID (NULLを許容)
        'user_id',     // 必須: ユーザID (外部キー)
        'contact',     // 任意: 連絡先 (有効なメール形式)
        'status',      // 必須: ステータス ("active" または "inactive")
        'remarks',     // 任意: 備考 (最大1000文字)
    ];

    /**
     * 所属する会社を取得するリレーション
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * 所属するユーザを取得するリレーション
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * クエリスコープ: ユーザによるフィルタリング
     */
    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * クエリスコープ: 条件によるフィルタリング
     */
    public function scopeFilter($query, array $filters)
    {
        // 必要なフィルタ条件のみ取得
        $filters = Arr::only($filters, ['name', 'company_id', 'status']);

        if (!empty($filters['name'])) {
            $query->where('name', 'LIKE', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['company_id'])) {
            $query->where('company_id', $filters['company_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query;
    }
}
