<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Category;
use App\Revision;
use App\Tag;
use App\Star;

class Repository extends Model
{
    protected $table = 'repositories';

    protected $fillable = [
    'title', 'description', 'content', 'category_id', 'copyright', 'is_private', 'star_num'
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
        return $this->hasMany(Tag::class, 'repository_id', 'id');
    }

    // 指明一个知识清单可以有多个修订。
    public function revisions()
    {
        return $this->hasMany(Revision::class, 'repository_id', 'id');
    }

    // 获取知识清单的收藏数。
    public function starNum()
    {
        return Star::where('repository_id', '=', $this->id)->get()->count();
    }
}
