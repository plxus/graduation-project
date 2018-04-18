<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreferredCategory extends Model
{
  protected $table = 'preferred_categories';

  protected $fillable = [
  'user_id', 'category_id',
];

}
