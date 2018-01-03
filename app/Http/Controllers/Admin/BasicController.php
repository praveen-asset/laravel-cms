<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\CompanyDetail as Company;

class BasicController extends Controller
{
    /**
     * view_company_details show the company details form.
     *
     * @return \Illuminate\Http\Response
     */

    public function view_company_details()
    {
        $phones             = Company::whereType('3')->get();
        $emails             = Company::whereType('4')->get();
        
        $company_name       = Company::whereType('1')->first();
        $company_address    = Company::whereType('2')->first();
        
        $input      = [
            'company_name'      => $company_name ? $company_name->value : '',
            'company_address'   => $company_address ? $company_address->value : ''
        ];

    	$page_title = "Admin | Manage Company Details";
        return view('admin.basic.company-details')
            ->with('page_title', $page_title)->with('phones', $phones)->with('input', $input)->with('emails', $emails);
    }


    /**
     * view_company_details show the company details form.
     *
     * @return \Illuminate\Http\Response
     */

    public function save_company_details(Request $request, $type)
    {
        if(!$type){
            return;
        }

        $input = $request->all();
        
        if($input['pk'] == 0){
            $response = Company::create([
                'type'              => $type,
                'label'             => $input['name'] == 'label' ? $input['value'] : '',
                'value'             => $input['name'] == 'worth' ? $input['value'] : '',
                'default'           => isset($input['default']) && $input['default'] == '1' ? 1 : 0,
            ]);

            return $response;
        }else{
            $exist = Company::find($input['pk']);
            $exist->type        = $type;
            $exist->label       = $input['name'] == 'label' ? $input['value'] : $exist->label;
            $exist->value       = $input['name'] == 'worth' ? $input['value'] : $exist->value;
            $exist->default     = isset($input['default']) && $input['default'] == '1' ? 1 : 0;
            $exist->save();

            return $exist;
        }
    }

    /**
     * update_company_details make default or delete company details.
     *
     * @return \Illuminate\Http\Response
     */

    public function update_company_details(Request $request)
    {
        $input = $request->all();

        if($input['action'] == 'make_default'){
            try{
                $detail = Company::findOrFail($input['pk']);

                Company::where('type', '=', $detail->type)
                    ->update(['default' => '0']);

                $detail->default = 1;
                $detail->save();

                return [
                    'status'    => true,
                    'message'   => 'Changed successfully.'
                ];
            }
            catch(ModelNotFoundException $e){
                return [
                    'status'    => false,
                    'message'   => 'Action failed. Please try again.'
                ];
            }
        }

        if($input['action'] == 'delete'){
            try{
                $getResponse = Company::findOrFail($input['pk']);

                if($getResponse->default != 1){
                    $getResponse->delete();

                    return [
                        'status'    => true,
                        'message'   => 'Delete successfully.'
                    ];
                }else{
                    return [
                        'status'    => false,
                        'message'   => 'Action failed. Please try again.'
                    ];
                }

            }
            catch(ModelNotFoundException $e){
                return [
                    'status'    => false,
                    'message'   => 'Action failed. Please try again.'
                ];
            }
        }
    }
}
