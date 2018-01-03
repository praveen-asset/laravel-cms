<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }


    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? $this->username()
            : 'username';

        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }


    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if($user->status == '2'){
            Auth::logout();
                $request->session()->flash('alert-danger', 'Your account is Inactive. Please contact to Administrator');

                return back();
        }

        if($user->status == '3'){
            Auth::logout();
                $request->session()->flash('alert-danger', 'Your account is Blocked. Please contact to Administrator');

                return back();
        }

        if($user->status == '0'){
            if($user->email_info){
                if($user->email_info->status == '0'){
                    Auth::logout();
                    $request->session()->flash('alert-danger', 'Your account is not active. Please activate your account first. If you did not receive confirmation email then click <a href="'.(route('resendverification', encrypt($user->id))).'">here</a> to resend.');

                    return back();
                }
            }
        }

        // Log the last login time
        $user->user_last_login = Carbon::now()->timestamp;
        $user->save();

        if($user->userType->user_type === '2') {
            return redirect()->intended('/admin');
        }
    }
}
