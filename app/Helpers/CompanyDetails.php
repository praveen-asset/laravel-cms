<?php

namespace App\Helpers;

use App\Models\CompanyDetail as Company;

class CompanyDetails
{

	/**
     * name will return company_name list
     * @param  none
     * @return string
     */
    public static function name()
    {
        $name = Company::whereType('1')->orderBy('updated_at', 'DESC')->first();

        if($name){
            return $name->value;
        }else{
            return '';
        }
    }


    /**
     * address will return company_address list
     * @param  none
     * @return string
     */
    public static function address()
    {
        $address = Company::whereType('2')->orderBy('updated_at', 'DESC')->first();

        if($address){
            return $address->value;
        }else{
            return '';
        }
    }

    /**
     * phones will return phones list, default will be first
     * @param  none
     * @return array
     */
    public static function phones()
    {
    	$phones = Company::whereType('3')->orderBy('default', 'DESC')->get();

        $return = [];
        foreach ($phones as $key => $phone) {
            $p = [];
            $p['label']     = $phone['label'];
            $p['phone']     = $phone['value'];
            $p['default']   = $phone['default'];

            $return[] = $p;
        }
        
    	return $return;
    }


    /**
     * phone will return phone
     * @param  none
     * @return array
     */
    public static function phone()
    {
        $phone = Company::whereType('3')->orderBy('default', 'DESC')->first();

        $return = [
            'label'     => $phone['label'],
            'phone'     => $phone['value'],
            'default'   => $phone['default']
        ];
        
        return $return;
    }


    /**
     * emails will return emails list, default will be first
     * @param  none
     * @return array
     */
    public static function emails()
    {
        $emails = Company::whereType('4')->orderBy('default', 'DESC')->get();

        $return = [];
        foreach ($emails as $key => $email) {
            $p = [];
            $p['label']     = $email['label'];
            $p['email']     = $email['value'];
            $p['default']   = $email['default'];

            $return[] = $p;
        }
        
        return $return;
    }


    /**
     * email will return email
     * @param  none
     * @return array
     */
    public static function email()
    {
        $email = Company::whereType('4')->orderBy('default', 'DESC')->first();

        $return = [
            'label'     => $email['label'],
            'email'     => $email['value'],
            'default'   => $email['default']
        ];
        
        return $return;
    }
}