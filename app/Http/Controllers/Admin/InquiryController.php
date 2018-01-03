<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ContactInquiry;

class InquiryController extends Controller
{
    protected $inquiryModel;
    protected $prefix;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->inquiryModel     = new ContactInquiry();
        $this->prefix           = $this->inquiryModel->prefix;

        $this->sortable_columns = [
            1 => 'id',
            2 => 'name',
            3 => 'email',
            4 => 'phone',
            5 => 'subject',
            7 => 'created_at',
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
            $total          = ContactInquiry::count();
            $limit          = $request->input('length');
            $start          = $request->input('start');
            $search         = $request['search']['value'];
            $orderby        = $request['order']['0']['column'];
            $order          = $orderby != "" ? $request['order']['0']['dir'] : "";
            $draw           = $request['draw'];

            $response       = $this->inquiryModel->getInquiries($limit, $start, $search, $this->sortable_columns[$orderby], $order);

            if(!$response){
                $inquiries      = [];
                $paging         = [];
            }
            else{
                $inquiries      = $response;
                $paging         = $response;
            }

            $data = array();
            $i = 1;
            
            foreach ($inquiries as $inquiry) {
                $u['DT_RowId']      = $i+$start;
                $u['INQ_ID']        = $this->prefix . $inquiry->id;
                $u['name']          = $inquiry->name;
                $u['email']         = $inquiry->email;
                $u['phone']         = $inquiry->phone!=NULL ? $inquiry->phone : ''; 
                $u['subject']       = $inquiry->subject; 
                $u['message']       = $inquiry->message;
                $u['created_at']    = date('M d, Y' , $inquiry->created_at);

                $u['unique']        = uniqid();
                $message            = view('admin.inquiry.message' , $u);
                $u['message']       = $message->render();

                $actions            = view('admin.inquiry.actions' , ['id' => $inquiry->id , 'name' => $this->prefix . $inquiry->id ]);
                $u['actions']       = $actions->render(); 

                $data[] = $u;
                $i++;
                unset($u);
            }

            $return = [
                    "draw"              =>  intval($draw),
                    "recordsFiltered"   =>  intval( $total),
                    "recordsTotal"      =>  intval( $total),
                    "data"              =>  $data
                ];
            return $return;
        }

        $page_title = "Admin | Manage Inquiries";
        return view('admin.inquiry.index')
            ->with('page_title', $page_title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404, 'No method!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404, 'No method!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404, 'No method!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404, 'No method!');
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
        abort(404, 'No method!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = decrypt( $id );
        try
        {
            $inquiry        = ContactInquiry::findOrFail( $id );
            $id           = $inquiry->id;
            $inquiry->delete();
            
            $request->session()->flash('alert-success', 'Inquiry '.ucfirst($this->prefix . $id).' deleted successfully.');
            return response(['msg' => 'Deleted', 'status' => 'success']); 
        }
        catch(ModelNotFoundException $e){   
           return response(['msg' => 'Failed deleting', 'status' => 'failed']);
        }
    }
}
