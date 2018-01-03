<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailChange extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email' , 'remember_token' , 'user_id' , 'status'
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = time();
        });
    }
}
