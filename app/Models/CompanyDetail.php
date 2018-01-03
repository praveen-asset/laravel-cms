<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    protected $fillable = ['type', 'label', 'value', 'default'];

    public $timestamps  = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->updated_at = time();
        });

        static::updating(function ($model) {
            $model->updated_at = time();
        });
    }
}
