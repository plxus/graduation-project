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
            'except' => ['store']
        ]);
    }

  // 用户个人主页视图
  public function show(User $user)
  {
    return view('users.show', compact('user'));
    // 用户对象 $user 通过 compact 方法转化为一个关联数组，并作为第二个参数传递给 view 方法，将数据与视图进行绑定。
  }

  // 用户修改个人信息（设置）视图
  public function edit(User $user)
  {
    // 使用 authorize 方法验证用户授权策略。authorize 方法有两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据。
    $this->authorize('update', $user);
    return view('users.edit', compact('user'));
  }

  // 处理用户个人信息表单提交数据
  public function update(User $user, Request $request)
  {
    // 验证表单提交的数据
    if($user->name==$request->name){
      $this->validate($request, [
        'name' => 'required|string|max:32',
      ]);
    }
    else{
      $this->validate($request, [
        'name' => 'required|string|max:32|unique:users',
      ]);
    }

    if($user->email==$request->email){
      $this->validate($request, [
        'email' => 'required|string|email|max:255',
      ]);
    }
    else{
      $this->validate($request, [
        'email' => 'required|string|email|max:255|unique:users',
      ]);
    }

    $this->validate($request, [
      'bio' => 'nullable|string|max:128',
      'password' => 'nullable|confirmed|min:6'
    ]);

    $this->authorize('update', $user);

    // 更新用户对象
    $data = [
      'name' => $request->name,
      'email' => $request->email,
      'bio' => $request->bio,
    ];

    if ($request->password) {
      $data['password'] = bcrypt($request->password);
    }
    $user->update($data);

    // 向会话中添加闪存信息
    session()->flash('success', '个人信息更改成功！');

    return redirect()->route('users.show', $user->id);
  }
}
