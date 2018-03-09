<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;

class UsersController extends Controller
{
  // 用户注册
  // public function create()
  // {
  //     return view('users.create');
  // }

  // 用户个人主页
  public function show(User $user)
  {
    return view('users.show', compact('user'));
    // 用户对象 $user 通过 compact 方法转化为一个关联数组，并作为第二个参数传递给 view 方法，将数据与视图进行绑定。
  }

  // 用户个人信息修改
  public function edit(User $user)
  {
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

    // 更新用户对象
    $data = [
      'name' => $request->name,
      'bio' => $request->bio
      // 'email' => $request->email
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
