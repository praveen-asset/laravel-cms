<?php
/*
*	Don't change this file
* 	if you need changes you can change in 
* 	namespace App\CustomClasses\EmailProvider
*/

namespace App\CustomClasses;

use Mail;
use App\Models\EmailTemplate;

class SandEmail
{
	protected static function send($slug, $input)
	{
		$input = (array) $input;

		$template  				= EmailTemplate::whereSlug($slug)->first();
		$email_subject   		= $template->subject;
		$email_body     		= $template->email_body;
		$dynamic_values			= $template->text_tag;
		// trim all array values
		$dynamic_values 		= array_map('trim', explode(',', $template->text_tag));


		// add basic app url to urls
		$input['app_name']		= env('APP_NAME', 'Laravel Basic App');
		$input['app_url']		= env('APP_URL', url('/'));
		if(isset($input['url'])){
			foreach ($input['url'] as $key => $url) {
				$input[$key]		= $input['app_url'] . $url;
			}
		}

		$email_subject			= str_replace( '{{app_name}}', $input['app_name'], $email_subject );
		
		// Replace dynamic values in email body
		$dynamic_values = array_merge($dynamic_values, ['app_name', 'app_url']);
		foreach ($dynamic_values as $values){
			$email_body 		= str_replace( '{{'.$values.'}}', $input[$values], $email_body );
		}
		
        Mail::send('emails.email', ['email_body' => $email_body], function($message) use ($email_subject, $input) {
            $message->to($input['email'], env('APP_NAME', 'Laravel Basic App'))
                ->subject($email_subject);
        });
	}
}