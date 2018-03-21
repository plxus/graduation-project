<?php

use Illuminate\Database\Seeder;
use App\User;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();  // 包含所有用户实例
        $user = $users->first();  // 第一个用户
        $user_id = $user->id;

        // 获取去除掉 ID 为 1 的所有用户 ID 数组
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        // 关注除 ID 为 1 的用户以外的所有用户
        $user->follow($follower_ids);

        // 除 ID 为 1 的用户以外的所有用户都关注 ID 为 1 的用户
        foreach ($followers as $follower) {
            $follower->follow($user_id);
        }
    }
}
