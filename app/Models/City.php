<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'state', 'country', 'google_id', 'google_place_id'];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = time();
        });
    }

    protected function getDateFormat()
    {
        return 'U';
    }

    public static function getCityByGoogleLocation($input)
    {
        if(!isset($input['google_id']))
        {
            return (object) ['id' => null];
        }

        $city = City::whereGoogleId($input['google_id'])->first();
        if($city)
        {
            return $city;
        }
        
        if(!isset($input['city']) && !isset($input['state']) && 
            !isset($input['country']) && !isset($input['google_id']) && 
            !isset($input['place_id'])
        )
        {
            return (object) ['id' => null];
        }
                
        $city = City::create([
            'name'              => $input['city'],
            'state'             => $input['state'],
            'country'           => $input['country'],
            'google_id'         => $input['google_id'],
            'google_place_id'   => $input['place_id'],
        ]);

        return $city;
    }
}
