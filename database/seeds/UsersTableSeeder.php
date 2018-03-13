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
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = User::find(1);
        $user->name = 'plusxu';
        $user->email = 'xplusxu@163.com';
        $user->password = bcrypt('123456');
        $user->bio='示例用户个人简介。';
        $user->is_admin=true;
        $user->save();
    }
}
