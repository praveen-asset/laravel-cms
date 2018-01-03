<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class EmailTemplate extends Model
{
	protected $fillable = ['slug', 'subject', 'email_body', 'text_tag'];
    public $timestamps  = false;

    public static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->created_at = time();
        });
    }

    public static function getEmailTemplate($limit, $offset, $search, $orderby,$order)
    {
        $orderby  = $orderby ? $orderby : 'id';
        $order    = $order ? $order : 'desc';
        
       // DB::enableQueryLog(true);
        $q        = EmailTemplate::where('id', '!=', '');
        
        if($search && !empty($search)){
            $q->where(function($query) use ($search) {
                $query->where('slug', 'LIKE', $search.'%')
                    ->orWhere('subject', 'LIKE', $search.'%');
            });
        }

        $response   =   $q->orderBy($orderby, $order)
                            ->offset($offset)
                            ->limit($limit)
                            ->get();
        
       //print_r(DB::getQueryLog());die;
        $response   =   json_decode(json_encode($response));
        return $response;
    }
}
