<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    protected $fillable = ['order_by', 'social_type', 'social_link', 'show_on'];

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

    public static $social_options = [
        'facebook' => [
            'title'         => 'Facebook', 
            'slug'          => 'facebook', 
            'fa-icon-class' => 'fa-facebook-official'
        ],
        'google_plus' => [
            'title'         => 'Google Plus', 
            'slug'          => 'google_plus',
            'fa-icon-class' => 'fa-google-plus-official',
        ],
        'linkedin' => [
            'title'         => 'Linkedin', 
            'slug'          => 'linkedin',
            'fa-icon-class' => 'fa-linkedin-square',
        ],
        'twitter' => [
            'title'         => 'Twitter', 
            'slug'          => 'twitter',
            'fa-icon-class' => 'fa-twitter-square',
        ],
        'pinterest' => [
            'title'         => 'Pinterest', 
            'slug'          => 'pinterest',
            'fa-icon-class' => 'fa-pinterest-square',
        ],
        'instagram' => [
            'title'         => 'Instagram', 
            'slug'          => 'instagram',
            'fa-icon-class' => 'fa-instagram',
        ],

        // add here to new social option
    ];
}
