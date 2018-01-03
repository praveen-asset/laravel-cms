<a href="{{ url('admin/user/'.encrypt($id).'/edit') }}" class="btn btn-xs btn-success pencil_anchor" id='{{ encrypt($id) }}'>
<i class="fa fa-pencil"></i>
</a>            

<a href="javascript:void(0)" id='{{"user_".encrypt($id) }}' class='btn btn-xs btn-danger del' data-msg="Are you sure you want to delete this user {{ ucwords($name) }}?"><i class="fa fa-trash"></i></a>