<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class UsersController extends Controller
{
  // 在构造函数中，使用身份认证（Auth）中间件过滤未登录用户的某些动作，“except”为排除的动作，“only”为限定的动作。
  // middleware 方法有两个参数，第一个为中间件的名称，第二个为要进行过滤的动作。
  public function __construct()
  {
    $this->middleware('auth', [
      'except' => []
    ]);
  }

  // 用户个人主页视图
  public function show(User $user)
  {
    $repositories = $user->repositories()->orderBy('created_at', 'desc')->paginate(20);  // 目标用户创建的所有知识清单
    // $repositories_star = $user->stars()->orderBy('created_at', 'desc')->paginate(20);  // 目标用户收藏的所有知识清单
    // $followings = $user->followings()->orderBy('created_at', 'desc')->paginate(20);  // 目标用户关注的其他用户
    // $followers = $user->followers()->orderBy('created_at', 'desc')->paginate(20);  // 目标用户的关注者

    return view('users.show', compact('user', 'repositories'));
    // 对象通过 compact 方法转化为一个关联数组，并作为第二个参数传递给 view 方法，将数据与视图进行绑定。
  }

  // 用户收藏的知识清单列表视图
  // 用户收藏信息流中包含自己发布的知识清单，也包含其他用户发布的私有的知识清单（只在信息流中可见）
  public function stars(User $user)
  {
    $repositories_star = $user->stars()
    ->orderBy('created_at', 'desc')
    ->paginate(20);  // 目标用户收藏的所有知识清单

    return view('users.stars', compact('user', 'repositories_star'));
  }

  // 关注的其他用户列表视图
  public function followings(User $user)
  {
    $followings = $user->followings()->orderBy('created_at', 'desc')->paginate(20);  // 目标用户关注的其他用户

    return view('users.followings', compact('user', 'followings'));
  }

  // 关注者列表视图
  public function followers(User $user)
  {
    $followers = $user->followers()->orderBy('created_at', 'desc')->paginate(20);  // 目标用户的关注者

    return view('users.followers', compact('user', 'followers'));
  }

  // 用户修改个人信息（设置）视图
  public function edit(User $user)
  {
    // 使用 authorize 方法验证授权策略。authorize 方法有两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据。
    $this->authorize('update', $user);
    return view('users.edit', compact('user'));
  }

  // 处理用户个人信息表单提交数据
  public function update(User $user, Request $request)
  {
    // 验证表单提交的数据
    if ($user->name === $request->name) {
      $this->validate($request, [
        'name' => 'required|string|max:64',
      ]);
    } else {
      $this->validate($request, [
        'name' => 'required|string|max:64|unique:users',
      ]);
    }

    if ($user->email === $request->email) {
      $this->validate($request, [
        'email' => 'required|string|email|max:191',
      ]);
    } else {
      $this->validate($request, [
        'email' => 'required|string|email|max:191|unique:users',
      ]);
    }

    $this->validate($request, [
      'bio' => 'nullable|string|max:128',
      'url' => 'nullable|string|max:128',
      'password' => 'nullable|confirmed|min:6'
    ]);

    $this->authorize('update', $user);

    $data = [
      'name' => $request->name,
      'email' => $request->email,
      'bio' => $request->bio,
      'url' => $request->url,
    ];

    if ($request->password) {
      $data['password'] = bcrypt($request->password);
    }

    // 更新用户对象
    $user->update($data);

    // 向会话中添加闪存信息
    session()->flash('success', '个人信息修改成功！');

    return redirect()->route('users.show', $user->id);
  }

  // 用户列表视图（后台管理）
  public function index(User $user)
  {
    $this->authorize('userIndex', $user);
    $users = User::paginate(10);
    return view('users.index', compact('users'));
  }

  // 处理删除用户表单提交的数据
  public function destroy(User $user)
  {
    $this->authorize('destroy', $user);
    // 删除用户对象
    $user->delete();
    session()->flash('success', '用户 '.$user->name.' 已删除。');
    return redirect()->route('users.index');
  }
}
