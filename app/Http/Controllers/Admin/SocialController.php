<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Models\SocialNetwork;

class SocialController extends Controller
{
	protected $social_options = [];

    function __construct(){
        $this->social_options = SocialNetwork::$social_options;
    }

    /**
     * Show the application manage users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	foreach ($this->social_options as $key => $option) {
    		$social = SocialNetwork::whereSocialType($option['title'])->first();

    		$this->social_options[$key]['url']	= isset($social->social_link) ? $social->social_link : '';
    		$this->social_options[$key]['show']	= isset($social->show_on) ? $social->show_on : '';
    	}

        $page_title = "Admin | Manage Social Networks";
        return view('admin.social.index')
            ->with('page_title', $page_title)->with('social_options', $this->social_options);
    }

    public function update(Request $request)
    {
    	$input = $request->all();
        
    	$rules = [];
        
    	foreach ($this->social_options as $option) {
    		$rules = array_merge($rules, [ $option['slug'].'_url' => getRule('url', (isset($input['show_'.$option['slug']])), true) ]);
    	}

    	$validator =  Validator::make($input, $rules);

        if($validator->fails()) {
            $errors = $validator->errors();
            return back()->withErrors($errors)->withInput();
        }else{
            $i = 0;
        	foreach ($this->social_options as $key => $option) {
        		
        		$exist = SocialNetwork::whereSocialType($option['title'])->first();
        		if($exist){
        			$exist->order_by 			= $i++;
        			$exist->social_type 		= $option['title'];
        			$exist->social_link 		= $input[$option['slug'].'_url'];
        			$exist->show_on 			= isset($input['show_'.$option['slug']]) ? 1 : 0;
                    
                    $exist->save();
        		}else{
	        		SocialNetwork::create([
	        			'order_by'			=> $i++,
	        			'social_type'		=> $option['title'],
	        			'social_link'		=> $input[$option['slug'].'_url'],
	        			'show_on'			=> isset($input['show_'.$option['slug']]) ? 1 : 0,
	        		]);
        		}
        	}
            
        	$request->session()->flash('alert-success', 'Social Networks successfully updated.');
            return redirect('admin/social');
        }
    }
}
