<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Notification;
use App\User;

class NotificationsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth', [
      'except' => []
    ]);
  }

  // 通知与私信视图
  public function show()
  {
    // 系统通知
    $notifications = Notification::join('users', 'users.id', '=', 'notifications.send_id')
    ->select('notifications.*', 'users.is_admin')
    ->where('users.is_admin', true)
    ->where('notifications.receive_id', 0)
    ->latest('notifications.created_at')
    ->get();

    // 当前用户收到的私信
    $received_msg = Notification::join('users','users.id','=','notifications.send_id')
    ->select('notifications.*', 'users.name')
    ->where('receive_id', Auth::user()->id)
    ->latest()
    ->get();

    // 当前用户发出的私信
    $sent_msg = Notification::join('users','users.id','=','notifications.receive_id')
    ->select('notifications.*', 'users.name')
    ->where([
      ['send_id', Auth::user()->id],
      ['receive_id', '<>', 0]
    ])
    ->latest()
    ->get();

    return view('notification', compact('notifications', 'received_msg', 'sent_msg'));
  }

  // 处理发送通知私信表单提交的数据
  public function store(User $user, Request $request)
  {
    $this->validate($request, [
      'msg_subject' => 'nullable|string|max:128',
      'msg_content' => 'required|string|max:191',
    ]);

    Notification::create([
      'send_id' => Auth::user()->id,
      'receive_id' => $user->id,
      'subject' => $request->msg_subject,
      'content' => str_replace(["\r\n", "\n"], "<br />", $request->msg_content),
    ]);

    session()->flash('success', '发送成功');

    return redirect()->route('users.show', $user->id);
  }

  // 处理删除通知私信表单提交的数据
  public function delete()
  {

  }
}
