<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Category;
use App\Tag;
use App\Star;

// 知识清单模型，对应 repositories 数据表。
class Repository extends Model
{
    protected $table = 'repositories';

    protected $fillable = [
    'title', 'description', 'content', 'category_id', 'copyright', 'is_private'
  ];

    // 指明一个知识清单只能由一个用户创建。
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 指明一个知识清单可以被多个用户收藏。
    public function stars()
    {
        return $this->belongsToMany(User::class, 'stars', 'repository_id', 'user_id');
    }

    // 指明一个知识清单只能属于一个类别。
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 指明一个知识清单可以有多个标签。
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags', 'repository_id', 'name');
    }

    // 获取知识清单的收藏数。
    public function starNum()
    {
        return Star::where('repository_id', '=', $this->id)->get()->count();
    }
}
