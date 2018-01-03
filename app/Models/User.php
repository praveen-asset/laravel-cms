<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\EmailChange;
use Auth;
use Common;
Use Carbon\Carbon;
use EmailProvider;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'first_name', 'last_name', 'profile_picture', 'username', 'phone' , 'phone_code' , 'email', 'password',  'city_id' , 'user_dob' , 'gender' , 'address_one' , 'address_two' , 'zip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    'password', 'remember_token',
    ];

    public $timestamps = false;

    // protected $dates = ['user_dob'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = time();
            $model->updated_at = time();
        });

        static::updating(function ($model) {
            if($model->user_dob){
                $model->user_dob = date('Y-m-d', strtotime($model->user_dob));
            }
        });
    }

    public function city()
    {
        return $this->belongsTo(City::Class);
    }

    public function getUserModel($limit, $offset, $search, $orderby, $order)
    {
        $q = User::select('users.*')->with('city')->where('users.id' , '<>', Auth::user()->id);

        $orderby  = $orderby ? $orderby : 'created_at';
        $order    = $order ? $order : 'desc';
        
        if($orderby == 'cities.name'){
            $q->leftJoin('cities', 'city_id', '=', 'cities.id');
        }

        if($search && !empty($search))
        {
            $q->where(function($query) use ($search) {
                $query->where('first_name', 'LIKE', '%'.$search.'%')
                ->orWhere('last_name', 'LIKE', '%'.$search.'%')
                ->orWhere('email', 'LIKE', '%'.$search.'%')
                ->orWhere('phone', 'LIKE', '%'.$search.'%')
                ->orWhereHas('City', function($query) use($search) {
                    $query->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('state', 'LIKE', '%'.$search.'%')
                    ->orWhere('country', 'LIKE', '%'.$search.'%');
                });
            });
        }

        $response = $q->orderBy($orderby, $order)
        ->offset($offset)
        ->limit($limit)
        ->get();
                   // echo "<pre>";print_r($q->toSql());dd($response);
        $response = json_decode(json_encode($response));
        return $response;
    }

    public function email_info()
    {
        return $this->hasOne(EmailChange::Class, 'email', 'email');
    }

    public function emails()
    {
        return $this->hasMany(EmailChange::Class);
    }

    public function userType()
    {
        return $this->hasOne(UserType::Class);
    }

    public static function change_email($user, $new_email)
    {
        // In case of email change
        $email_changes_message = '';
        if($user->email != $new_email){
            $confirmation_code = str_random(30);

            $existing_email = EmailChange::whereEmail($new_email)->whereUserId($user->id)->first();
            if(!$existing_email){
                EmailChange::create([
                    'email'                 => $new_email,
                    'remember_token'        => $confirmation_code,
                    'user_id'               => $user->id
                    ]);
                
                EmailProvider::sendMail('user-verification-mail', 
                    [
                    'confirmation_code'         => $confirmation_code,
                    'first_name'                => $user->first_name,
                    'last_name'                 => $user->last_name,
                    'email'                     => $user->email,
                    'url'   => [
                    'verify_url'        => '/register/verify/'.$confirmation_code
                    ]
                    ]
                    );

                $email_changes_message = 'You have changed your email. Verify your email('.$new_email.') address to activate. We have sent a link on your email. You can just click that URL. Click <a href="'.(route('resendverification', encrypt($user->id))).'">here</a> to resend verification email.';
            }else{
                if($existing_email->status == '0'){
                    $existing_email->remember_token = $confirmation_code;
                    $existing_email->save();

                    EmailProvider::sendMail('user-verification-mail', 
                        [
                        'confirmation_code'         => $confirmation_code,
                        'first_name'                => $user->first_name,
                        'last_name'                 => $user->last_name,
                        'email'                     => $user->email,
                        'url'   => [
                        'verify_url'        => '/register/verify/'.$confirmation_code
                        ]
                        ]
                        );
                    
                    $email_changes_message = 'You have changed your email. Verify your email('.$new_email.') address to activate. We have sent a link on your email. You can just click that URL. Click <a href="'.(route('resendverification', encrypt($user->id))).'">here</a> to resend verification email.';
                }else{
                    $user->email = $new_email;
                    $user->save();
                }
            }
        }

        return $email_changes_message;
    }

    /**     
    * Send a password reset email to the user    
    */    
    public function sendPasswordResetNotification($token){        EmailProvider::sendMail('user-resetpassword-mail',
            [                
                'email'  => $this->getEmailForPasswordReset(),
                'url'   => 
                    [
                    'reset_link' => 'password/reset/' . $token . '?em=' . encrypt($this->getEmailForPasswordReset())           
                    ]            
            ]        
        );    
}


}
