<?php

namespace App\Policies;

use App\Models\Person;
use App\Models\User;

class PersonPolicy
{
    /**
     * ユーザが特定の人物を更新できるかどうかを判定
     *
     * @param User $user
     * @param Person $person
     * @return bool
     */
    public function update(User $user, Person $person): bool
    {
        return $user->id === $person->user_id;
    }

    /**
     * ユーザが特定の人物を削除できるかどうかを判定
     *
     * @param User $user
     * @param Person $person
     * @return bool
     */
    public function delete(User $user, Person $person): bool
    {
        return $user->id === $person->user_id;
    }
}
