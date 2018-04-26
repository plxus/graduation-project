<?php

use Illuminate\Database\Seeder;
use App\Notification;

class NotificationsTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    Notification::create([
      'send_id' => 1,
      'receive_id' => 0,  // 全部用户
      'subject' => '欢迎来到知识清单管理系统',
      'content' => '你好，欢迎来到知所，一个面向大学生的知识清单管理系统。让我们一起在这里探索与分享新知。',
    ]);
  }
}
