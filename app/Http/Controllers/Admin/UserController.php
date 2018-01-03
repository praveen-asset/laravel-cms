<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserType;
use App\Models\City;
use App\Models\EmailTemplate;
use Mail;
use Hash;
use Valid;
use EmailProvider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    protected $userModel;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->userModel     = new User();
        $this->emailprovider = new EmailProvider();

        $this->sortable_columns = [
            0 => 'id',
            1 => 'first_name',
            2 => 'email',
            3 => 'phone',
            4 => 'cities.name',
            5 => 'created_at',
        ];
    }

    /**
     * Show the application manage users.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $totalUser      = User::WhereHas('userType', function($q){
                                $q->where('user_type',"!=" ,'2');
                                })->count();
            $limit          = $request->input('length');
            $start          = $request->input('start');
            $search         = $request['search']['value'];
            $orderby        = $request['order']['0']['column'];
            $order          = $orderby != "" ? $request['order']['0']['dir'] : "";
            $draw           = $request['draw'];

            $response       = $this->userModel->getUserModel($limit, $start, $search, $this->sortable_columns[$orderby], $order);

            if(!$response){
                $users      = [];
                $paging     = [];
            }
            else{
                $users      = $response;
                $paging     = $response;
            }

            $userData = array();
            $i = 1;
            foreach ($users as $user) {
                $u['DT_RowId']      = $i+$start;
                $u['name']          = $user->first_name . " " . $user->last_name;
                $u['email']         = $user->email;
                $u['phone']         = $user->phone!=NULL ? "(+".$user->phone_code . ")" .$user->phone : '-'; 
                $u['location']      = $user->city!=NULL ? $user->city->name ." , ". $user->city->state . " , ". $user->city->country : '-';
                $u['created_at']    = date('M d, Y' , $user->created_at);

                $user_status        = view('admin.user.status' , ['id' => $user->id , 'status' => $user->status]);
                $u['status']        = $user_status->render();

                $actions            = view('admin.user.actions' , ['id' => $user->id , 'name' => $user->first_name . " " . $user->last_name ]);
                $u['actions']       = $actions->render(); 

                $userData[] = $u;
                $i++;
                unset($u);
            }
            $return = [
                    "draw"              =>  intval($draw),
                    "recordsFiltered"   =>  intval( $totalUser),
                    "recordsTotal"      =>  intval( $totalUser),
                    "data"              =>  $userData
                ];
            return $return;
        }

        $page_title = "Admin | Manage Users";
        return view('admin.user.index')
            ->with('page_title', $page_title);
    }

    /**
     * create to create form for add new user.
     * @return void
    */
    public function create()
    {   
        $data = ["page_title"  => "Admin | Manage User"];
        return view('admin.user.create' , $data);
    }

     /**
     * store to insert new user.
     * @return void
    */
    public function store(Request $request)
    {
        $input = $request->all();
        
        $validator = Validator::make($input,[
            'first_name'  =>  getRule('first_name', true),
            'last_name'   =>  getRule('last_name', false, true),
            'email'       =>  getRule('email', true).'|unique:users',
            'phone'       =>  getRule('phone', false, true),
            'google_id'   =>  getRule('google_id', false, true),
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            return back()->withErrors($errors)->withInput();
        }
        else 
        {
            if($input['google_id'] != "")
            {
                $city = City::getCityByGoogleLocation($input);
                $input['city_id']    = $city->id;
            }    
            $input['password']       = bcrypt('user1234');
            $input['phone_code']     = empty($request['phone']) ? null : $input['phone_code'];
            
            // insert into users and usertype 
            $userInfo = User::create($input);
            $userType = UserType::create(['user_id' => $userInfo->id]);

            $user = User::where('id', $userInfo->id)->first();

            // Send join user mail 
            EmailProvider::sendMail('user-join-mail', 
                [
                    'first_name'        => $user->first_name,
                    'last_name'         => $user->last_name,
                    'email'             => $user->email,
                    'url'   => [
                        'join_url'          => '/joinuser/' . encrypt($user->id),
                    ]
                ]
            );

            $message = 'New user '. ucfirst($input['first_name']). ' ' . ucfirst($input['last_name']) . ' added successfully and joining mail is sent successfully to ' . $input['email'] ; 

            $request->session()->flash('alert-success', $message);

            return redirect('admin/user');
        }
    }

    /**
     * destroy to delete user.
     * @return void
    */
    public function destroy(Request $request, $id)
    {
        $id = decrypt( $id );
        try
        {
            $user       = User::findOrFail( $id );
            $first_name = $user->first_name;

            $delete     = $user->delete();
        
            $request->session()->flash('alert-success', 'Record for '.ucfirst($first_name).' deleted successfully.');
            return response(['msg' => 'Content Deleted', 'status' => 'success']); 
        }
        catch(ModelNotFoundException $e){   
           return response(['msg' => 'Failed deleting the content', 'status' => 'failed']);
        }
    }

    /**
     * edit to show user edit.
     * 
     * @return void
     */
    public function edit($id)
    { 
        $user_id = decrypt( $id );

        $user_list = User::with('city')->where('id' , '=', $user_id)->first();
        
        $city = [
            'name'=>'', 'state' =>'', 'country'=>'', 'google_id'=>'', 'place_id'=>''
        ];

        if($user_list->city != NULL) 
        {
            $city['name']       = $user_list->city->name;
            $city['state']      = $user_list->city->state;
            $city['country']    = $user_list->city->country;
            $city['google_id']  = $user_list->city->google_id;
            $city['google_place_id']   = $user_list->city->google_place_id;    
        }

        $data = [
            "page_title"  => "Admin | Settings",
            'user'        => $user_list,
            'city'        => $city   
        ];
        return view('admin.user.edit' , $data);
    }

    /**
     * update to update user.
     * params Request $request , int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $id    =  decrypt($id);
        $input = $request->all();

        $validator = Validator::make($input,[
            'first_name'  =>  getRule('first_name', true),
            'last_name'   =>  getRule('last_name', false, true),
            'email'       =>  getRule('email', true).'|unique:users,email,'.$id,
            'phone'       =>  getRule('phone', false, true),
            'google_id'   =>  getRule('google_id', true),
            'zip'         =>  getRule('zip', false, true),
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();
            $request->session()->flash('alert-danger', 'Errors! Please correct the following errors and submit again.');
            return back()->withErrors($errors)->withInput();
        }
        else {
            try {
                $user = User::findOrFail( $id );
                
                if($input['google_id']!="")
                {
                    $city = City::getCityByGoogleLocation($input);
                    $user->city_id     = $city->id;
                }    
                $user->first_name  = $input['first_name'];
                $user->last_name   = $input['last_name'];
                $user->email       = $input['email'];
                $user->username    = $input['username'];
                $user->user_dob    = $input['dob'];
                $user->status      = $input['status'];
                $user->gender      = $input['gender'];
                $user->address_one = $input['address_one'];
                $user->address_two = $input['address_two'];
                $user->zip         = $input['zip'];
                $user->phone_code  = empty($input['phone']) ? null : $input['phone_code']; 
                $user->phone       = $input['phone'];

                $user->save();

                $request->session()->flash('alert-success', 'User ' . ucfirst($user->first_name) . ' ' . ucfirst($user->last_name) .' updated successfully.');
                return redirect('admin/user');
                
            }
            catch(ModelNotFoundException $e){   
                $request->session()->flash('alert-danger', 'Failed to update , Please try again.');
                return redirect()->back();
            }
        }
    }

    /**
     * update_status to update user status(active,inactive,blocked).
     * params Request $request
     * @return void
    */
    public function update_status(Request $request)
    {
        $id = decrypt($request->id);
        try{
            $user = User::findOrFail( $id );
            $user->status = $request->status;
            $user->save();

            $request->session()->flash('alert-success', 'User status updated successfully.');
            return "success";
        }
        catch(ModelNotFoundException $e){
            $request->session()->flash('alert-danger', 'Failed to update , Please try again.');
            return redirect()->back();
        }
    }
}
