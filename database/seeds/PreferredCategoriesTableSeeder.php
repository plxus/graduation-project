<?php

use Illuminate\Database\Seeder;
use App\PreferredCategory;

class PreferredCategoriesTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    $preferred_category_ids = [1, 32, 43];
    foreach ($preferred_category_ids as $preferred_category_id) {
      PreferredCategory::create([
        'user_id' => 1,
        'category_id' => $preferred_category_id,
      ]);
    }
  }
}
