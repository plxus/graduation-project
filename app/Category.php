<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'repo_categories';

    protected $fillable = [
      'category_level_1','category_level_2',
    ];

    // 指明一个类别中可以有多个知识清单。
    public function repositories()
    {
        return $this->hasMany(Repository::class);
    }
}
