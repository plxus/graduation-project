<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    // times 接受一个参数用于指定要创建的模型数量，make 方法调用后将为模型创建一个集合。makeVisible 方法临时显示 User 模型里指定的隐藏属性 $hidden，接着我们使用了 insert 方法来将生成假用户列表数据批量插入到数据库中。最后我们还对第一位用户的信息进行了更新，方便后面我们使用此账号登录。
    $users = factory(User::class)->times(100)->make();
    User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

    // 管理员
    $admin = User::find(1);
    $admin->name = 'plus xu';
    $admin->email = 'xplusxu@163.com';
    $admin->avatar = 'users/plusxu.png';
    $admin->password = bcrypt('123456');
    $admin->bio = '让大学校园中的知识分享变得更加简单、高效、优雅。';
    $admin->url = 'https://github.com/plxus';
    $admin->is_admin = true;
    $admin->role_id = 1;  // 1：管理员，2：用户，3：内容运营
    $admin->save();

    // 内容运营
    $operator = User::find(2);
    $operator->name = '内容运营管理员';
    $operator->email = 'operator@mail.com';
    $operator->avatar = 'users/gravatar.jpg';
    $operator->password = bcrypt('123456');
    $operator->bio = '负责维护知识清单管理系统中的 UGC（用户生成内容）。';
    $operator->is_admin = true;
    $operator->role_id = 3;  // 1：管理员，2：用户，3：内容运营
    $operator->save();
  }
}
