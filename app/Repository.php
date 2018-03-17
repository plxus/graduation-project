<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// 知识清单模型，对应 repositories 数据表。
class Repository extends Model
{
    protected $fillable = [
      'title', 'description', 'content', 'is_private', 'copyright',
    ];

    // 指明一个知识清单只能由一个用户创建。
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
