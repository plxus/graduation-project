<?php

use Illuminate\Database\Seeder;
use App\Repository;
use App\User;

class StarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = ['1','2','3','4'];  // 为前四个用户添加收藏知识清单的假数据
        $repository_ids = Repository::pluck('id');

        foreach ($user_ids as $user_id) {
            $user = User::find($user_id);
            $user->star($repository_ids);
        }
    }
}
