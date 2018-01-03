<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Cms;
use Valid;

class CmsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sortable_columns = [
            0 => 'title',
            1 => 'updated_at',
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
            $totalCms       = Cms::count();
            $limit          = $request->input('length');
            $start          = $request->input('start');
            $search         = $request['search']['value'];
            $orderby        = $request['order']['0']['column'];
            $order          = $orderby != "" ? $request['order']['0']['dir'] : "";
            $draw           = $request['draw'];
          
            $response       = Cms::getCmsModel($limit , $start , $search, $this->sortable_columns[$orderby], $order);

            if(!$response){
                $page       = [];
                $paging     = [];
            }
            else{
                $page       = $response;
                $paging     = $response;
            }

            $data = array();

            foreach ($page as $cms) {
                $u['title']         = ucwords($cms->title);
                $u['updated_at']    = date('M d, Y', $cms->updated_at);

                $cms_status         = view('admin.cms.status', ['id' => $cms->id, 'status' => $cms->status]);
                $u['status']        = $cms_status->render();

                $actions            = view('admin.cms.actions', ['id' => $cms->id ]);
                $u['actions']       = $actions->render(); 

                $data[] = $u;

                unset($u);
            }

            $return = [
                "draw"              =>  intval($draw),
                "recordsFiltered"   =>  intval( $totalCms),
                "recordsTotal"      =>  intval( $totalCms),
                "data"              =>  $data
            ];
            return $return;
        }

        $page_title = "Admin | Manage Cms";
        return view('admin.cms.index')
            ->with('page_title', $page_title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('No action found');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('No action found');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id    = decrypt($id);
        $cms   = Cms::where('id', $id)->first();

        $data  = [ 
            "page_title"     =>  "Admin | Manage Cms",
            "input"          =>  $cms 
        ];
        return view('admin.cms.edit', $data);
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
        $id     =  decrypt($id);
        $input  =  $request->all();

        $validator =  Validator::make($input,[
            'slug'              =>  getRule('slug', true),
            'title'             =>  getRule('title', true),
            'content'           =>  getRule('content', true),
            'meta_title'        =>  getRule('meta_title', false, true),
            'meta_description'  =>  getRule('meta_description', false, true),
            'meta_tags'         =>  getRule('meta_tags', false, true),
        ]);

        if($validator->fails()) {
            $errors = $validator->errors();

            $request->session()->flash('alert-danger', 'Errors! Please correct the following errors and submit again.');
            return back()->withErrors($errors)->withInput();
        }
        else{

            $cms                     = Cms::findOrFail( $id );
            $cms->title              = $request->title;
            $cms->content            = $request->content;
            $cms->meta_title         = $request->meta_title;
            $cms->meta_description   = $request->meta_description;
            $cms->meta_tags          = $request->meta_tags;
           // $cms->status             = $request->status;
            $cms->save();

            $request->session()->flash('alert-success', 'Updated successfully.');
            return redirect('admin/cms');
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
        dd('No action found');
    }

    /**
     * update_status to update user status(active,inactive,blocked).
     * params Request $request
     * @return void
    */
    public function update_status(Request $request)
    {
        $id = decrypt($request->id);
        try
        {
            $cms            = Cms::findOrFail( $id );
            $cms->status    = $request->status;
            $cms->save();

            $request->session()->flash('alert-success', 'Status updated successfully.');
            return "success";
        }
        catch(ModelNotFoundException $e)
        {
            $request->session()->flash('alert-danger', 'Failed to update , Please try again.');
            return redirect()->back();
        }
    }
}
