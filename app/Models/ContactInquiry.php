<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    public $prefix = 'INQ-';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email' , 'phone' , 'subject' , 'message', 'user_ip'
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = time();
        });
    }


    public function getInquiries($limit, $offset, $search, $orderby, $order)
    {
        $q = ContactInquiry::where('id' , '!=', '');

        $orderby  = $orderby ? $orderby : 'created_at';
        $order    = $order ? $order : 'desc';
        
        if(strpos($search, $this->prefix) !== false){
            $search = str_replace($this->prefix, '', $search);
            $q->where(function($query) use ($search) {
                $query->where('id', '=', $search);
            });
        }else{
            if($search && !empty($search))
            {
                $q->where(function($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('email', 'LIKE', '%' . $search . '%')
                        ->orWhere('phone', 'LIKE', $search.'%')
                        ->orWhere('subject', 'LIKE', '%' . $search . '%')
                        ->orWhere('message', 'LIKE', '%' . $search . '%');
                });
            }
        }

        $response = $q->orderBy($orderby, $order)
                    ->offset($offset)
                    ->limit($limit)
                    ->get();

        $response = $response;
        return $response;
    }
}
