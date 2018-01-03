<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailChange;
use App\Models\User;
use App\Models\City;
use App\Models\UserType;
use Auth;

class VerifyController extends Controller
{
    /**
     * verify to verify email via email link.
     * params string $confirmation_code, Request $request
     * @return void
     */
    public function verify($confirmation_code = 'get_from_request', Request $request)
    {
        
        $redirect_on_error = 'login';
        if($confirmation_code == 'get_from_request')
        {
            $redirect_on_error = 'back';
            $confirmation_code = $request->input('confirmation_code');
        }

        if( ! $confirmation_code)
        {
            $request->session()->flash('alert-danger', ('Invalid URL or Code, Please try again with valid URL or Code'));
            if($redirect_on_error == 'back'){
                return back();
            }
            return redirect($redirect_on_error);
        }

        $email = EmailChange::whereRememberToken($confirmation_code)->first();
        if ( ! $email)
        {
            $request->session()->flash('alert-danger', ('Invalid URL or Code, Please try again with valid URL or Code'));
            if($redirect_on_error == 'back'){
                return back();
            }
            return redirect($redirect_on_error);
        }

        $email->status = '1';
        $email->remember_token = null;
        $email->save();

        $user = User::find($email->user_id);
        $user->email = $email->email;
        if($user->status == '0'){
            $user->status = '1';
        }
        $user->save();

        $request->session()->flash('alert-success', ('You have successfully verified your account.'));

        if(Auth::check()) {
            if(Auth::user()->userType->user_type === '2') {
                return redirect('admin/profile');
            }
        }else {
            Auth::login($user);
        }

        return redirect('profile');
    }
}
