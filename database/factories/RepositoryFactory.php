<?php

use Faker\Generator as Faker;

$factory->define(App\Repository::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;

    return [
      'title' => $faker->sentence(),
      'description' => $faker->paragraph(),
      'content' => $faker->realText(1000),
      'copyright' => 'limit',  // allow 允许转载，limit 需授权，forbid 禁止转载。
      'is_private' => false,
      'created_at' => $date_time,
      'updated_at' => $date_time,
  ];
});
