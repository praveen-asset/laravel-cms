<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\City;

class JoinUserController extends Controller
{
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
     * index to show join user.
     * params int $id
     * @return \Illuminate\Http\Response
    */
    public function index($id)
    {   
        $id = decrypt($id);

        $user_list = User::with('city')->where('id' , '=', $id)->first();

        $input = [
            'name'=>'', 'state' =>'', 'country'=>'', 'google_id'=>'', 'google_place_id'=>''
        ]; 

        if($user_list->city != NULL) 
        {
            $input['name']             = $user_list->city->name;
            $input['state']            = $user_list->city->state;
            $input['country']          = $user_list->city->country;
            $input['google_id']        = $user_list->city->google_id;
            $input['google_place_id']  = $user_list->city->google_place_id;    
        }
        
        return view('auth.join_user', [
            'user'  => $user_list,
            'city'  => $input
        ]);
    }

    /**
     * join to insert join user detail.
     * params Request $request
     * @return void
    */
    public function join(Request $request)
    {
        $input = $request->all();
        $id = $input['userid'];

        $validator =  Validator::make($input, [
            'first_name'  =>  getRule('first_name', true),
            'last_name'   =>  getRule('last_name', true),
            'phone'       =>  getRule('phone', false, true),
            'username'    =>  getRule('username', true).'|unique:users,username,'.$id,
            'email'       =>  getRule('email', true).'|unique:users,email,'.$id.'|unique:email_changes,email,'.$id.',user_id',
            'password'    =>  getRule('password', true),
            'gender'      =>  getRule('gender', true),
            'dob'         =>  getRule('dob', true),                  
            'google_id'   =>  getRule('google_id', true),
            'address_one' =>  getRule('address_one', true),
            'zip'         =>  getRule('zip', true) 
        ]);

        if($validator->fails())
        {
            $errors = $validator->errors();
            return back()->withErrors($errors)->withInput();
        }
        else 
        {
            try 
            {
                $user = User::findOrFail( $id );

                $city = City::getCityByGoogleLocation($input);

                $user->city_id     = $city->id;
                
                $user->first_name  =  $input['first_name'];
                $user->last_name   =  $input['last_name'];
                $user->phone_code  =  empty($input['phone']) ? null : $input['ccode']; 
                $user->phone       =  db_phone($input['phone']);
                $user->username    =  $input['username'];
                $user->password    =  bcrypt($input['password']);
                $user->user_dob    =  $input['dob'];
                $user->status      =  '1';
                $user->gender      =  $input['gender'];
                $user->address_one =  $input['address_one'];
                $user->address_two =  $input['address_two'];
                $user->zip         =  $input['zip'];

                $user->save();
                $request->session()->flash('alert-success', 'User detail updated successfully.');
                return redirect('login');
            }
            catch(ModelNotFoundException $e)
            {   
                $request->session()->flash('alert-danger', 'Failed to update , Please try again.');
            }
        }
    }
}
