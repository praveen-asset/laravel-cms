<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\City;
use App\Models\EmailChange;
use Auth;
use Hash;
use Mail;
use Common;
use EmailProvider;

class HomeController extends Controller
{
    protected $redirectTo = '/register/confirm';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {   
        $data = [ "page_title"    => "Admin | Dashboard" ];
        return view('admin.dashboard' , $data);
    }

    /**
     * profile to show profile edit.
     * 
     * @return void
    */
    public function profile()
    {
        $user      = Auth::user();
        $user_city = Auth::user()->city;

        $input     = ['name'=>'', 'state' =>'', 'country'=>'', 'google_id'=>'', 'google_place_id'=>''];

        if($user_city!=NULL) {
            $input['name']       = $user_city->name;
            $input['state']      = $user_city->state;
            $input['country']    = $user_city->country;
            $input['google_id']  = $user_city->google_id;
            $input['google_place_id']  = $user_city->google_place_id;    
        }
        
        $data = [
            "page_title"    => "Admin | Profile",
            'user'          => $user, 
            'user_city'     => $input
        ];
        return view('admin.profile', $data);
    }

    /**
     * updateProfile to update profile.
     * params Request $request
     * @return void
    */
    public function updateProfile(Request $request)
    {
        $input = $request->all();
        $id = Auth::user()->id;

        $validator =  Validator::make($input, [
            'first_name'  => getRule('first_name', true),
            'last_name'   => getRule('last_name', false, true),
            'phone'       => getRule('phone', false, true),
            'username'    => getRule('username', true).'|unique:users,username,'.$id,
            'email'       => getRule('email', true).'|unique:users,email,'.$id,
            'gender'      => getRule('gender', true),
            'dob'         => getRule('dob', true),   
            'google_id'   => getRule('google_id', true),
            'address_one' => getRule('address_one', true),
            'zip'         => getRule('zip', true) 

        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            return back()->withErrors($errors)->withInput();
        }
        else {
            try {
                $user = User::findOrFail( $id );
               
                $city = City::getCityByGoogleLocation($input);

                $user->city_id      =  $city->id;
                $user->first_name   =  $input['first_name'];
                $user->last_name    =  $input['last_name'];
                $user->email        =  $input['email'];
                $user->phone_code   =  empty($input['phone']) ? null : $input['phone_code']; 
                $user->phone        =  db_phone($input['phone']);
                $user->username     =  $input['username'];
                $user->user_dob     =  $input['dob'];
                $user->status       =  '1';
                $user->gender       =  $input['gender'];
                $user->address_one  =  $input['address_one'];
                $user->address_two  =  $input['address_two'];
                $user->zip          =  $input['zip'];
              
                $user->save();
                $request->session()->flash('alert-success', 'Admin profile updated successfully.');
                return redirect('admin/profile');
            }
            catch(ModelNotFoundException $e) {   
                $request->session()->flash('alert-danger', 'Failed to update , Please try again.');
            }
        }
    }

    /**
     * updateEmail to update email of admin user.
     * params Request $request
     * @return void
    */
    public function updateEmail(Request $request)
    {
        $input = $request->all();
        $input['password_confirmation'] = $input['password'];

        $id       = Auth::user()->id;
        $email    = $input['email'];
        $password = $input['password'];

        $validator =  Validator::make($input, [
            'email'    =>  getRule('email', true).'|unique:users,email,'.$id.'|unique:email_changes,email,'.$id.',user_id',
            'password' => getRule('password', true),
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            return [
                'status'    => false,
                'message'   => $errors
            ];
        }
        else {
            try {
                $user = User::findOrFail( $id );
                
                if(Hash::check($password,$user['password'])) 
                {
                    /* Send Confirmation mail to change email */
                    $email_changes_message = '';

                    $new_email         = $input['email'];
                    $confirmation_code = str_random(30);
                    $existing_email    = EmailChange::whereEmail($new_email)->whereUserId($user->id)->first();

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
                                'email'                     => $new_email,
                                'url'   => [
                                    'verify_url'        => 'register/verify/'.$confirmation_code
                                ]
                            ]
                        );
                        
                        $email_changes_message = 'You have changed your email. Verify your email('.$input['email'].') address to activate. We have sent a link on your email. You can just click that URL. Click <a href="'.(route('resendverification', encrypt($user->id))).'">here</a> to resend verification email.';
                    }
                    else {
                        if($existing_email->status == '0'){
                            $existing_email->remember_token = $confirmation_code;
                            $existing_email->save();

                            EmailProvider::sendMail('user-verification-mail', 
                                [
                                    'confirmation_code'         => $confirmation_code,
                                    'first_name'                => $user->first_name,
                                    'last_name'                 => $user->last_name,
                                    'email'                     => $new_email,
                                    'url'   => [
                                        'verify_url'        => 'register/verify/'.$confirmation_code
                                    ]
                                ]
                            );

                            $email_changes_message = 'You have changed your email. Verify your email('.$input['email'].') address to activate. We have sent a link on your email. You can just click that URL. Click <a href="'.(route('resendverification', encrypt($user->id))).'">here</a> to resend verification email.';
                        }
                        else{
                            $user->email = $new_email;
                            $user->save();
                            $email_changes_message = "Email id chnaged successfully.";
                        }
                    }
                  
                    $request->session()->flash('alert-success', $email_changes_message); 
                    return [
                        'status'    => true
                    ];
                } 
                else {
                    return [
                        'status'    => false,
                        'message'   => ['password' => 'You have entered wrong password']
                    ];
                }
            }
            catch(ModelNotFoundException $e) {   
                return [
                    'status'    => false,
                    'message'   => ['error'=>'Some Internal Error occured']
                ];
            }
        }

    }

    /**
     * changePassword to change password of admin panel.
     * params Request $request
     * @return void
     */
    public function changePassword(Request $request) {
        $input = $request->all();
        $id    = Auth::user()->id;

        $validator =  Validator::make($input, [
            'current_password'  =>  getRule('current_password', true),
            'password'          =>  getRule('password', true),
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            return [
                'status'    => false,
                'message'   => $errors
            ];
        }
        else {
            try {
                $old_pwd = $input['current_password'];
                $new_pwd = $input['password'];
                
                $user = User::findOrFail( $id );

                if(Hash::check($old_pwd,$user['password'])) 
                {
                    $user->password = bcrypt($new_pwd);
                    $user->save();

                    // send confirmation email
                    EmailProvider::sendMail('user-change-password-mail', 
                        [
                            'first_name'    => $user->first_name,
                            'email'         => $user->email,
                        ]
                    );

                    $request->session()->flash('alert-success', 'Password Changed successfully.');
                    return ['status' => true];
                }
                else{
                    return [
                        'status'    => false,
                        'message'   => ['current_password' => 'Current password is wrong.']
                    ];
                }
            }
            catch(ModelNotFoundException $e) {   
                return [
                    'status'    => false,
                    'message'   => ['error'=>'Some Internal Error occured']
                ];
            }
        }   
    }

}
