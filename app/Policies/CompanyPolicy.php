<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    /**
     * ユーザが特定の会社を更新できるかどうかを判定
     *
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public function update(User $user, Company $company): bool
    {
        return $user->id === $company->user_id;
    }

    /**
     * ユーザが特定の会社を削除できるかどうかを判定
     *
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public function delete(User $user, Company $company): bool
    {
        return $user->id === $company->user_id;
    }
}
