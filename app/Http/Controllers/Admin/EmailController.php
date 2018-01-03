<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\EmailTemplate;
use Valid;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->sortable_columns = [
            0 => 'slug',
            1 => 'subject',
            2 => 'created_at'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $totalTemplate    =  EmailTemplate::count();
            $limit            =  $request->input('length');
            $start            =  $request->input('start');
            $search           =  $request['search']['value'];
            $orderby          =  $request['order']['0']['column'];
            $order            =  $orderby != "" ? $request['order']['0']['dir'] : "";
            $draw             =  $request['draw'];
            $response         =  EmailTemplate::getEmailTemplate($limit, $start, $search, $this->sortable_columns[$orderby], $order);

            if(!$response){
                $templates    =  [];
                $paging       =  [];
                \Request::session()->flash("alert-warning", "No email template found.");
            }
            else{
                $templates    =  $response;
                $paging       =  $response;
            }

            $data = array();
            $i = 1;
            foreach ($templates as $template) {
                $u['slug']          =  $template->slug;
                $u['subject']       =  $template->subject;  
                $u['created_at']    =  date('M d, Y' , $template->created_at);

                $actions         = view('admin.emails.actions' , ['id' => $template->id ]);
                $u['actions']    = $actions->render(); 

                $data[] = $u;
                unset($u);
            }

            $return = [
                    "draw"              =>  intval($draw),
                    "recordsFiltered"   =>  intval( $totalTemplate),
                    "recordsTotal"      =>  intval( $totalTemplate),
                    "data"              =>  $data
                ];
            return $return;
        }

        $page_title = "Admin | Manage Email Templates";
        return view('admin.emails.index')
            ->with('page_title', $page_title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('No Action Found');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('No Action Found');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('No Action Found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id    =  decrypt($id);
        $res   =  EmailTemplate::where('id' , '=', $id)->first();

        if($res['text_tag']!="")
        {
            $tag_arr            =  preg_split('/\s*,\s*/', trim($res['text_tag']));
            $res['text_tag']    =  '{{'.implode('}} {{', $tag_arr).'}}';
        }    

        $data = [ 
            "page_title"     =>  "Admin | Manage Email Template",
            "input"          =>  $res 
        ];
        return view('admin.emails.templates', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id        =  decrypt($id);
        $input     =  $request->all();

        $validator =  Validator::make($input,[
            'subject'       =>  getRule('subject', true),
            'email_body'    =>  getRule('email_body', true),
            'text_tag'      =>  getRule('text_tag', true),
        ]);

        if($validator->fails()) 
        {
            $errors = $validator->errors();

            $request->session()->flash('alert-danger', 'Errors! Please correct the following errors and submit again.');
            return back()->withErrors($errors)->withInput();
        }
        else
        {
            try 
            {
                $template              = EmailTemplate::findOrFail( $id );
                $template->subject     = $request->subject;
                $template->email_body  = $request->email_body;
                $template->save();

                $request->session()->flash('alert-success', 'Email template updated successfully.');
                return redirect('admin/email');
            }
            catch(ModelNotFoundException $e)
            {   
                $request->session()->flash('alert-danger', 'Failed to update , Please try again.');
                return redirect()->back();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('No Action Found');
    }
}
