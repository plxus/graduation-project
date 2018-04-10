<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Repository;

class RepositoryPolicy
{
  use HandlesAuthorization;
  use VoyagerPolicyTrait;

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

  // 用户修改知识清单时的授权策略。
  public function update(User $user, Repository $repository)
  {
    return $user->id === $repository->user_id || $user->is_admin;
  }
}

trait VoyagerPolicyTrait
{
  public function browse(User $user)
  {
    return $user->is_admin;
  }

  public function edit(User $user)
  {
    return $user->is_admin;
  }

  public function add(User $user)
  {
    return $user->is_admin;
  }

  public function delete(User $user)
  {
    return $user->is_admin;
  }

  public function read(User $user)
  {
    return $user->is_admin;
  }
}
