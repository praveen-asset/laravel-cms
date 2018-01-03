<?php 
namespace App\CustomClasses;

use Mail;
use App\CustomClasses\SandEmail as Email;

class EmailProvider extends Email
{
	public static function emailSlugs()
	{
		// Keys are fixed 					# Changable
		return [
			'user-join-mail'				=> 'user-join-mail',
			'user-welcome-mail'				=> 'user-welcome-mail',
			'user-verification-mail'		=> 'user-verification-mail',
			'user-resetpassword-mail'		=> 'user-resetpassword-mail',
			'user-change-password-mail'		=> 'user-change-password-mail',
			'admin-notify-inquiry-mail'		=> 'admin-notify-inquiry-mail',
			'user-thanku-inquiry-mail'		=> 'user-thanku-inquiry-mail',
		];
	}

	public static function sendMail($slug, $input = array())
	{
		$callback = lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $slug))));
		
		self::$callback(self::getSlug($slug), $input);
	}

	public static function getSlug($key)
	{
		return self::emailSlugs()[$key];
	}

	private static function userJoinMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	private static function userWelcomeMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	private static function userVerificationMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	/*
	* resetPasswordMail send reset password mail
	* params string $slug, array $input
	*/
	private static function userResetpasswordMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	private static function userChangePasswordMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	private static function adminNotifyInquiryMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}

	private static function userThankuInquiryMail($slug, $input)
	{
		// customise $input here if you want
		parent::send($slug, $input);
	}
}