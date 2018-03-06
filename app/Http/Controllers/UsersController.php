<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class UsersController extends Controller
{
    // 创建用户
    // public function create()
    // {
    //     return view('users.create');
    // }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
        // 用户对象 $user 通过 compact 方法转化为一个关联数组，并作为第二个参数传递给 view 方法，将数据与视图进行绑定。
    }
}
