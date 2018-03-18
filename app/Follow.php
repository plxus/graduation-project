<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
  protected $table = 'follows';

  protected $fillable = [
  'user_id', 'following_user_id'
];
}
