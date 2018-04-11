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
    public function destroy(User $user, Request $request)
    {
        if (Auth::user()->id === $user->id) {
            return redirect('/');
        }

        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);  // 取消关注操作
        }

        if ($request->input('ajax') === 'unfollow') {
            return response()->json(['status' => 'success']);  // JSON 响应
        }
        else {
            return redirect()->route('users.show', $user->id);
        }
    }

    // 处理取消关注的 Ajax 请求
    public function ajax_destroy(Request $request)
    {
    }
}
