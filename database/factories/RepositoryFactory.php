<?php

use Faker\Generator as Faker;
use App\Repository;

$factory->define(App\Repository::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;

    return [
      'title' => $faker->sentence(),
      'description' => $faker->paragraph(),
      'content' => $faker->text(),
      'is_private' => false,
      'copyright' => 'allow',  // allow 允许转载，limit 需授权，forbid 禁止转载。
      'created_at' => $date_time,
      'updated_at' => $date_time,
  ];
});
