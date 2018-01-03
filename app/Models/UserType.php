<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
  	protected $fillable = ['user_id' , 'user_type'];
  	public $timestamps = false;
}
