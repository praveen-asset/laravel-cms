<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\City;
use App\Models\EmailChange;
use App\Models\UserType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Common;
use EmailProvider;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register/confirm';

    protected $request;

    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest');

        $this->request = $request;
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'            =>  getRule('first_name', true),
            'last_name'             =>  getRule('last_name', true),
            'phone'                 =>  getRule('phone', false, true),
            'username'              =>  getRule('username', true).'|unique:users',
            'email'                 =>  getRule('email', true).'|unique:users',
            'password'              =>  getRule('password', true),
            'google_id'             =>  getRule('google_id', true),
            // 'g-recaptcha-response'  =>  getRule('g-recaptcha-response', false)
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $city = City::getCityByGoogleLocation($data);

        $user = User::create([
            'first_name'        => $data['first_name'],
            'last_name'         => $data['last_name'],
            'phone_code'        => $data['ccode'],
            'phone'             => db_phone($data['phone']),
            'username'          => $data['username'],
            'email'             => $data['email'],
            'password'          => bcrypt($data['password']),
            'city_id'           => $city->id,
        ]);

        UserType::create([
            'user_id'                 => $user->id
        ]);

        $confirmation_code = str_random(30);
        EmailChange::create([
            'email'                 => $data['email'],
            'remember_token'        => $confirmation_code,
            'user_id'               => $user->id
        ]);

        EmailProvider::sendMail('user-welcome-mail', 
            [
                'confirmation_code'         => $confirmation_code,
                'first_name'                => $data['first_name'],
                'last_name'                 => $data['last_name'],
                'email'                     => $data['email'],
                'url'   => [
                    'verify_url'        => 'register/verify/'.$confirmation_code
                ]
            ]
        );

        $this->redirectTo = $this->redirectTo.'/'.encrypt($user->id);

        $this->request->session()->flash('alert-success', ('You have successfully registered with '. env('APP_NAME', 'Laravel Basic App') .'. Verify your email('.$user->email.') address to login. We have sent a link and confirmation code on your email. You can just click that URL or put confirmation code in below text box. Click <a href="'.(route('resendverification', encrypt($user->id))).'">here</a> to resend verification email.'));

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);
        
        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * confirm account after click form verify email.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function confirm($user_id, Request $request)
    {
        $this->validUserId($user_id, $request, redirect('register'));

        return view('auth.confirm', array('user_id' => decrypt($user_id)));
    }


    /**
     * confirm account after click form verify email.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function changeEmail($user_id, Request $request)
    {
        $this->validUserId($user_id, $request, redirect('register'));
        
        $data = $request->all();
        $validator = Validator::make($data, [
            'email'       => getRule('email', true).'|unique:users,email,'.$user_id.'|unique:email_changes',
        ]);

        if($validator->fails())
        {
            $errors = $validator->errors();

            $request->session()->flash('alert-danger', 'Errors! Please correct the following errors and submit again.');

            return back()->withErrors($errors)->withInput();
        }else{

            $confirmation_code = str_random(30);
            EmailChange::create([
                'email'                 => $data['email'],
                'remember_token'        => $confirmation_code,
                'user_id'               => $this->user->id
            ]);

            EmailProvider::sendMail('user-verification-mail', 
                [
                    'confirmation_code'         => $confirmation_code,
                    'first_name'                => $this->user->first_name,
                    'last_name'                 => $this->user->last_name,
                    'email'                     => $data['email'],
                    'url'   => [
                        'verify_url'        => '/register/verify/'.$confirmation_code
                    ]
                ]
            );

            $request->session()->flash('alert-success', ('You have successfully registered with '. env('APP_NAME', 'Laravel Basic App') .'. Verify your email('.$data['email'].') address to login. We have sent a link and confirmation code on your email. You can just click that URL or put confirmation code in below text box. Click <a href="'.(route('resendverification', encrypt($this->user->id))).'">here</a> to resend verification email.'));

            return back();
        }
    }
}
