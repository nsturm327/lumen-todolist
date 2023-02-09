<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoNote extends Model
{
   
   protected $fillable = ['user_id','description', 'completed_at'];
}