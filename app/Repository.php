<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// 知识清单模型，对应 repositories 数据表。
class Repository extends Model
{
    protected $table = 'repositories';

    protected $fillable = [
    'title', 'description', 'content', 'category_level_1', 'category_level_2', 'copyright', 'is_private'
  ];

    // 指明一个知识清单只能由一个用户创建。
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 指明一个知识清单只能属于一个类别。
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
