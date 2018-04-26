<?php

use Illuminate\Database\Seeder;
use App\Tag;
use App\Repository;

class TagsTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    $tags = ['分析方法'];
    $repository_ids = Repository::pluck('id')->toArray();
    foreach ($repository_ids as $repository_id) {
      foreach ($tags as $tag) {
        Tag::create([
          'repository_id' => $repository_id,
          'name' => $tag,
        ]);
      }
    }
  }
}
