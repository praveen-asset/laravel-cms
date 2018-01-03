<?php

namespace App\CustomClasses;

class Validations
{
	/*
	* function static rules for all rules
	* params none
	*/
	private static function rules()
	{
		return [
			'name' 					=>  'max:50|regex:/(^[a-zA-Z0-9 ]+$)/u',
			'first_name' 			=>  'min:3|max:25|regex:/(^[a-zA-Z0-9 ]+$)/u',
			'last_name' 			=>  'max:25|regex:/(^[a-zA-Z0-9 ]+$)/u',
			'photo' 				=>  'image|mimes:jpeg,jpg,png|max:4000',
			'phone' 				=>  'min:6|max:15|regex:/^[0-9-]+$/',
			'username'				=>  'min:3|max:20|regex:/^[0-9A-Za-z.\_\-]+$/',
			'email'					=>  'string|email|max:100',
			'gender'				=>  '',
			'dob'					=>  'date_format:"'.env('DATE_FORMAT_PHP', 'm/d/Y').'"',
			'google_id'				=>  '',
			'address_one'        	=>  '',
			'zip'					=>  'min:3|max:10||regex:/(^[a-zA-Z0-9]+$)/u',
			'password'				=>  'string|max:25|min:8|regex:/^(?=.*[a-z])(?=.*\\d).{8,}$/i|confirmed',
			'g-recaptcha-response'  =>  'captcha',
			'url'					=>  'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
		];
	}

	/*
	* function getRule to get from rules() function
	* params string $name, bool $required
	*/
	public static function getRule($name, $required, $nullable)
	{
		return ($required ? 'required|' : '') . ($nullable ? 'nullable|' : '') . (array_key_exists($name, static::rules()) ? static::rules()[$name] : '');
	}
}