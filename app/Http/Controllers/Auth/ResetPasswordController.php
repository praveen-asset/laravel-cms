<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\UserType;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;



class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function redirectTo()
    {
        $email      =  Auth::user()->email;
        $user_type  =  Auth::user()->UserType->user_type;

        if($user_type == 2)
            return '/admin';  
        else
            return '/home';  
    }
    public function showResetForm(Request $request, $token = null)
    {   
         $email = '';       
          if ($request->has('em')) {            
            $email =  decrypt($request->get('em'));        
        }
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $email]
        );
    }


    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token'         => 'required',
            'email'         => getRule('email', true),
            'password'      => getRule('password', true),
        ];
    }
}
