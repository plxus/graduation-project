<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Repository;

class Revision extends Model
{
  protected $table = 'revisions';

  protected $fillable = [
    'repository_id', 'log'
  ];

  // 指明一个修订只能属于一个知识清单。
  public function repository()
  {
    return $this->belongsTo(Repository::class);
  }
}
