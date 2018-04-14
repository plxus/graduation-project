<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Auth;

class NotificationsController extends Controller
{
    // 通知与私信视图
    public function show()
    {
        // 系统通知
        $notifications = Notification::join('users', 'users.id', '=', 'notifications.send_id')
        ->where('users.is_admin', true)
        ->where('notifications.receive_id', 0)
        ->latest('notifications.created_at')
        ->get();

        // 当前用户收到的私信
        $received_msg = Notification::where('receive_id', Auth::user()->id)->latest()->get();

        // 当前用户发出的私信
        $sent_msg = Notification::where('send_id', Auth::user()->id)->latest()->get();

        return view('notification', compact('notifications', 'received_msg', 'sent_msg'));
    }
}
