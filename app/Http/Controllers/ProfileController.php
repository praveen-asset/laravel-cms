<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\City;
use App\Models\EmailChange;
use Auth;
use Hash;
use Common;
use EmailProvider;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ProfileController extends Controller
{
	 use SendsPasswordResetEmails;

    protected $upload_path = 'uploads/profile-picture/';

    function __construct(){
        $this->common = new Common;
    }

    /**
     * index to show profile edit.
     * 
     * @return void
     */
    public function index()
    {
    	$user = Auth::user();
        $user_city = Auth::user()->city;
        
    	return view('profile.profile', ['user' => $user, 'user_city' => $user_city]);
    }

    /**
     * updateProfile to update profile.
     * params Request $request
     * @return void
     */
    public function updateProfile(Request $request)
    {
        $input = $request->all();
        $user_id = Auth::user()->id;

        $validator =  Validator::make($input, [
            'first_name'    => getRule('first_name', true),
            'last_name'     => getRule('last_name', true),
            'profile_picture'=> getRule('photo'),
            'phone'         => getRule('phone', false, true),
            'username'      => getRule('username', true).'|unique:users,username,'.$user_id,
            'email'         => getRule('email', true).'|unique:users,email,'.$user_id.'|unique:email_changes,email,'.$user_id.',user_id',
            'gender'        => getRule('gender', true),
            'dob'           => getRule('dob', true),
            'google_id'     => getRule('google_id', true),
            'address_one'   => getRule('address_one', true),
            'zip'           => getRule('zip', false, true)
        ]);        
        if($validator->fails())
        {
            $request->session()->flash('alert-danger', ('Error! Please fix following errors first.'));

            $errors = $validator->errors();
            return back()->withErrors($errors)->withInput();
        }
        else
        {
            try
            {
                $user = User::findOrFail( $user_id );

                $uploaded_file = Common::upload('profile_picture', 'user_'. (str_replace(['@', '.'], '-', $user->email)), $this->upload_path);
                if($uploaded_file != ''){
                    $user->profile_picture = $uploaded_file;
                }

                // In case of email change
                $email_changes_message = User::change_email($user, $input['email']);

                $city = City::getCityByGoogleLocation($input);
                
                $user->first_name   = $input['first_name'];
                $user->last_name    = $input['last_name'];
                $user->phone_code   = $input['ccode'];
                $user->phone        = db_phone($input['phone']);
                $user->username     = $input['username'];
                $user->user_dob     = $input['dob'];
                $user->gender       = $input['gender'];
                $user->address_one  = $input['address_one'];
                $user->address_two  = $input['address_two'];
                $user->city_id      = $city->id;
                $user->zip          = $input['zip'];
                $user->updated_at   = time();
                $user->save();

                $request->session()->flash('alert-success', 'Profile updated successfully. ' . $email_changes_message);
                return redirect('profile');
            }
            catch(ModelNotFoundException $e)
            {
                $request->session()->flash('alert-danger', 'Failed to update , Please try again.');
            }
        }

    }


    /**
     * changePasswordView to show change password form.
     * params None
     * @return void
     */
    public function changePasswordView()
    {
        return view('profile.change-password');
    }

    /**
     * changePassword to update password.
     * params Request $request
     * @return void
     */
    public function changePassword(Request $request)
    {
        $input = $request->all();
        $user_id    = Auth::user()->id;
       

        $validator =  Validator::make($input, [    
            'current_password' => 'required',
            'new_password' => getRule('password',true)
        ]);

        if($validator->fails())
        {
            $errors = $validator->errors();
            return back()->withErrors($errors);
        }
        else
        {
            try
            {
                $old_pwd = $input['current_password'];
                $new_pwd = $input['new_password'];
               
                $user = User::findOrFail( $user_id );
                if(Hash::check($old_pwd, $user['password']))
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

                    $request->session()->flash('alert-success', 'Password changed successfully.');
                    return redirect('profile');
                }
                else
                {
                    $request->session()->flash('alert-danger', 'Current password is wrong.');
                    return back();
                }
            }
            catch(ModelNotFoundException $e)
            {   
                $request->session()->flash('alert-danger', 'Failed to update , Please try again.');
                return back();
            }
        }
    }
    public function confirmResetpassword(Request $request){
        $request->merge(['email'=>Auth::user()->email]);       
        $response = $this->broker()->sendResetLink(  $request->only('email'));
        Auth::logout();            
         return redirect('password/reset')->with('status',trans($response));
    }
}
