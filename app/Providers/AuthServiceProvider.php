<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Person;
use App\Policies\CompanyPolicy;
use App\Policies\PersonPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * アプリケーションで使用されるポリシーのマッピング
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Company::class => CompanyPolicy::class, // Companyモデルに対応するポリシー
        Person::class => PersonPolicy::class,   // Personモデルに対応するポリシー
    ];

    /**
     * 認証・認可サービスの登録
     *
     * 必要に応じてカスタムの認証ロジックやポリシーを登録します。
     */
    public function boot(): void
    {
        // 登録済みポリシーを有効化
        $this->registerPolicies();

        // 必要に応じてGateやその他のカスタマイズを追加可能
        // Gate::define('custom-gate', function ($user, $param) {
        //     return $user->id === $param->user_id;
        // });
    }
}
