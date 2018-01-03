<?php

use Validations as CustomValidations;
use App\Models\Cms;

/*
* function getRule to get validations rule by name
* params string $name, bool $required
*/
if (! function_exists('getRule')) {
	function getRule($name, $required = false, $nullable = false) 
	{
		return CustomValidations::getRule($name, $required, $nullable);
	}
}


if (! function_exists('show_date')) {
	function show_date($date)
	{
		if($date){
			return date(env('DATE_FORMAT_PHP', 'm/d/Y'), strtotime($date));
		}
	}
}

if (! function_exists('db_phone')) {
	function db_phone($phone)
	{
		if($phone){
			return str_replace([' ', '-'], '', $phone);
		}else{
			return $phone;
		}
	}
}

if ( ! function_exists('prep_url'))
{
    /**
     * Prep URL
     *
     * Simply adds the http:// part if no scheme is included
     *
     * @param   string  the URL
     * @return  string
     */
    function prep_url($str = '')
    {
        if ($str === 'http://' OR $str === '')
        {
            return '';
        }
        $url = parse_url($str);
        if ( ! $url OR ! isset($url['scheme']))
        {
            return 'http://'.$str;
        }
        return $str;
    }
}

if ( ! function_exists('copyright'))
{
    /**
     * copyright text
     *
     * Simply adds the http:// part if no scheme is included
     *
     * @param   string  the URL
     * @return  string
     */
    function copyright()
    {
        $page = Cms::get('copyright');

        return $page['content'];
    }
}
