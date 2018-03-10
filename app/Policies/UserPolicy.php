<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // 用户修改个人信息时的授权策略。update 方法的返回值是 true（通过授权）或 false（禁止访问）。
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}
