<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Category;
use App\Repository;

class RepositoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 通过 app() 方法来获取一个 Faker 容器的实例，并借助 randomElement 方法来取出用户 id 数组中的任意一个元素并赋值给知识清单的 user_id 字段，使得每个用户都拥有随机数量的知识清单。
        $user_ids = ['1','2','3','4','5'];  // 为前四个用户添加知识清单假数据
        $category_ids = Category::pluck('id')->toArray();  // 获取知识清单类别的 ID。
        $faker = app(Faker\Generator::class);

        $repositories = factory(Repository::class)->times(80)->make()->each(function ($repository) use ($faker, $user_ids, $category_ids) {
            $repository->user_id = $faker->randomElement($user_ids);
            $repository->category_id = $faker->randomElement($category_ids);
        });

        Repository::insert($repositories->toArray());
    }
}
