<?php

namespace App\Helpers;

use App\Models\SocialNetwork;

class SocialNetworks
{

	/**
     * rander will create html and print
     * @param  none
     * @return None
     */
    public static function rander()
    {
    	$networks = SocialNetwork::whereShowOn('1')->orderBy('order_by', 'ASC')->get();

    	$options = SocialNetwork::$social_options;
    	foreach ($networks as $key => $network) {
    		if(isset($options[str_replace(' ', '_', strtolower($network['social_type']))])){
                $fa_class = $options[str_replace(' ', '_', strtolower($network['social_type']))]['fa-icon-class'];

        		$networks[$key]['fa_icon_class'] = $fa_class;
            }else{
                unset($networks[$key]);
            }
    	}

    	return view('social.index')->with('networks', $networks);
    }
}