<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cms;
use App\Models\ContactInquiry;
use EmailProvider;

class PagesController extends Controller
{
    /**
     * about rander about page
     * @param  none
     * @return none
     */
    public function about()
    {
		$page = Cms::get('about-us-page');
		
	    return view('page')->with('page', $page);
	}

	/**
     * terms_use rander terms of use page
     * @param  none
     * @return none
     */
	public function terms_use()
    {
		$page = Cms::get('terms-of-use-page');
		
	    return view('page')->with('page', $page);
	}

	/**
     * privacy_policy rander privacy policy page
     * @param  none
     * @return none
     */
    public function privacy_policy()
    {
        $page = Cms::get('privacy-policy-page');
        
        return view('page')->with('page', $page);
    }

    /**
     * contact rander contact page
     * @param  none
     * @return none
     */
	public function contact()
    {	
	    return view('contact-us');
	}

    /**
     * send_inquiry send inquiry
     * @param  none
     * @return none
     */
    public function send_inquiry(Request $request)
    {   
        $input = $request->all();

        $validator = Validator::make($input, [
            'name'                  =>  getRule('name', true),
            'email'                 =>  getRule('email', true),
            'phone'                 =>  getRule('phone', false, true),
            'subject'               =>  'required|max:100',
            'message'               =>  'required|max:1000',
            // 'g-recaptcha-response'  =>  getRule('g-recaptcha-response', false)
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();

            $request->session()->flash('alert-danger', 'Errors! Please correct the following errors and submit again.');
            return back()->withErrors($errors)->withInput();
        }
        else{

            $response = ContactInquiry::create([
                'name'              => $input['name'],
                'email'             => $input['email'],
                'phone'             => $input['phone'],
                'subject'           => $input['subject'],
                'message'           => $input['message'],
                'user_ip'           => $request->ip()
            ]);

            // send email to admin
            EmailProvider::sendMail('admin-notify-inquiry-mail', 
                [
                    'name'          => $input['name'],
                    'email'         => env('ADMIN_EMAIL', 'shlokjodha@gmail.com'),
                    'inquiry_email' => $input['email'],
                    'phone'         => $input['phone'],
                    'subject'       => $input['subject'],
                    'message'       => $input['message']
                ]
            );

            // send email to user
            EmailProvider::sendMail('user-thanku-inquiry-mail', 
                [
                    'name'          => $input['name'],
                    'email'         => $input['email'],
                    'inquiry_email' => $input['email'],
                    'phone'         => $input['phone'],
                    'subject'       => $input['subject'],
                    'message'       => $input['message']
                ]
            );

            $request->session()->flash('alert-success', 'Thank you for contacting us. We will back to you soon.');
            return back();
        }
    }
}
