<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

// define 定义了一个指定数据模型（如此例子 User）的模型工厂。define 方法接收两个参数，第一个参数为指定的 Eloquent 模型类，第二个参数为一个闭包函数，该闭包函数接收一个 Faker PHP 函数库的实例，让我们可以在函数内部使用 Faker 方法来生成假数据并为模型的指定字段赋值。
$factory->define(App\User::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    static $password;
    
    return [
    'name' => $faker->unique()->name,
    'email' => $faker->unique()->safeEmail,
    'password' => $password ?: $password = bcrypt('secret'),
    'bio' => $faker->sentence,
    'remember_token' => str_random(10),
    'created_at' => $date_time,
    'updated_at' => $date_time,
  ];
});
