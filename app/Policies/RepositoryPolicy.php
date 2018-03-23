<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Repository;

class RepositoryPolicy
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

    // 用户删除知识清单时的授权策略。
    public function destroy(User $user, Repository $repository)
    {
        return $user->id === $repository->user_id || $user->is_admin;
    }

}
