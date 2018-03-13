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

    // 用户修改个人信息时的授权策略。授权策略类中方法的返回值是 true（通过授权）或 false（禁止访问）。
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    // 管理员访问用户列表时的授权策略
    public function userIndex(User $currentUser)
    {
        return $currentUser->is_admin;
    }

    // 管理员删除用户时的授权策略
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
