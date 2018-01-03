<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Mail;
use Common;
use App\Models\User;
use EmailProvider;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    

    /**
     * validUserId verify from encrypted id.
     *
     * @param  string  $user_id, Request $request, $redirect_to
     * @return \App\User
     */
    protected function validUserId($user_id, Request $request, $redirect_to = '')
    {
        if($redirect_to == ''){
            $redirect_to == back();
        }

        if( ! $user_id)
        {
            $request->session()->flash('alert-danger', ('Something went wrong. Please try again.'));
            return $redirect_to;
        }
        
        $user_id = decrypt($user_id);
        if( ! $user_id)
        {
            $request->session()->flash('alert-danger', ('Something went wrong. Please try again.'));
            return $redirect_to;
        }

        $user = User::find($user_id);

        if(!$user){
            $request->session()->flash('alert-danger', ('Something went wrong. Please try again.'));
            return $redirect_to;
        }

        $this->user = $user;
    }

    /**
     * resendVerification
     *
     * @param  string $user_id
     * @return None
     */
    public function resendVerification($user_id, Request $request){
        $this->validUserId($user_id, $request);

        $emails = $this->user->emails;
        $latest_email = $emails[$emails->reverse()->keys()->first()];

        if(empty($latest_email->remember_token)){
            $latest_email->remember_token = str_random(30);
            $latest_email->save();
        }

        EmailProvider::sendMail('user-verification-mail', 
            [
                'confirmation_code' => $latest_email->remember_token,
                'first_name'        => $this->user->first_name,
                'last_name'         => $this->user->last_name,
                'email'             => $latest_email->email,
                'url'   => [
                    'verify_url'        => '/register/verify/'.$latest_email->remember_token
                ]
            ]
        ); 

        //Common::sendVerificationEmail($slug, $latest_email->remember_token, $latest_email->email, $this->user->first_name);

        $request->session()->flash('alert-success', ('Confirmation email has been sent again. Please verify your account.'));

        return back();
    }


    /**
     * resetPwd to reset password when admin forgot its password and wants to change  
       password from admin panel.
     * @return void
    */
    public function forgotPasswordLogin()
    {
        $email = Auth::user()->email;
        Auth::logout();
        return redirect('password/reset?em='.encrypt($email));
    }
}
