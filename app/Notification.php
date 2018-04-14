<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
  protected $table = 'notifications';

  protected $fillable = [
    'send_id', 'receive_id', 'subject', 'content', 'is_delete'
  ];

}
