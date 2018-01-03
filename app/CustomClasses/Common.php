<?php

namespace App\CustomClasses;

use Illuminate\Support\Facades\Input;
use File;
use Mail;
use EmailProvider;

class Common
{
	/*
	* function static upload to upload file
	* params none
	*/
	public static function upload($file_input, $file_name = '', $where = 'uploads/')
	{
		if (Input::hasFile($file_input))
        {
			if(!File::exists(public_path($where))) {
	            File::makeDirectory($where, 0777, true);
	        }
	        $file = Input::file($file_input);
	        $propic_path = public_path($where);
	        
	        if($file_name == ''){
	        	$file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

	        	$file_name = str_replace([' ', '@'], '-', $file_name);

	        	$file_name .= '-' . time() . '.' . $file->getClientOriginalExtension();
	        }else{
	        	$file_name .= '.' . $file->getClientOriginalExtension();
	        }
	        
	        $file->move($propic_path, $file_name);

	        return $file_name;
	    }
	}

	/**
     * sendVerificationEmail
     *
     * @param  string $confirmation_code, string $email, string $first_name
     * @return None
     */
    public static function sendVerificationEmail($confirmation_code, $email, $first_name)
    {
    	$blade_data = [
            'confirmation_code' => $confirmation_code,
            'first_name'        => $first_name,
            'email'				=> $email
        ];

    	EmailProvider::sendMail('user-welcome-mail', $blade_data); 
    }
}