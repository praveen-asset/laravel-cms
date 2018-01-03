<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    protected $fillable = ['slug', 'title', 'content', 'meta_title', 'meta_description', 'meta_tags', 'status'];

    public $timestamps  = false;

    public static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->updated_at = time();
        });
    }

    public static function getCmsModel($limit, $offset, $search, $orderby,$order)
    {
        $orderby  = $orderby ? $orderby : 'id';
        $order    = $order ? $order : 'desc';

        $q        = Cms::where('id', '!=', '');
        
        if($search && !empty($search)){
            $q->where(function($query) use ($search) {
                $query->where('title', 'LIKE', $search.'%');
            });
        }

        $response   =   $q->orderBy($orderby, $order)
                            ->offset($offset)
                            ->limit($limit)
                            ->get();

        $response   =   json_decode(json_encode($response));
        return $response;
    }


    /**
     * get will get page by slug
     * @param  string $page_slug
     * @return array $page
     */
    public static function get($page_slug)
    {
        return Cms::whereSlug($page_slug)->first();
    }
}
