<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Auth;
use App\Follow;

class FollowsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 处理关注用户表单提交的数据。
    public function store(User $user)
    {
        if (Auth::user()->id === $user->id) {
            return redirect('/');
        }

        if (!Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);  // 关注操作
        }

        return redirect()->route('users.show', $user->id);
    }

    // 处理取消关注用户表单提交的数据。
    public function destroy(User $user)
    {
        if (Auth::user()->id === $user->id) {
            return redirect('/');
        }

        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);  // 取消关注操作
        }

        return redirect()->route('users.show', $user->id);
    }

    // 用户关注列表视图（后台管理）
    public function index(User $user)
    {
        // $this->authorize('userIndex', $user);
        $follows = Follow::paginate(10);
        // return view('users.index', compact('users'));
    }
}
