<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Repository;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
    'repository_id', 'name'
  ];

    // 指明一个标签只能对应一个知识清单
    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }
}
