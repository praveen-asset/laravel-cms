@extends('admin.layouts.layout')
@section('content')

	<!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
	  		<h1>
				Users
	  		</h1>
	  		<ol class="breadcrumb">
				<li>
					<a href="{!! url('admin/dashboard') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active"><!-- <i class="fa fa-gears"></i> -->Users</li>
	  		</ol>
		</section>

		<!-- Main content -->
		<section class="content">
	  		<!-- Info boxes -->
	  		<div class="row">
				<div class="col-xs-12">
		  			<div class="box">
						<div class="box-header">
							<div class="row">
								<div class="col-md-12">
					  				<a class="btn btn-social btn-primary" href="{{ url('admin/user/create') }}">
						 				<i class="fa fa-plus"></i> Add New User
					  				</a>
				  				</div>
			  				</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body">

			  			  @include('admin.partials.errors')

			  			  <table id="userTable" class="table table-bordered table-hover datatable">
  			  				
  			  				<thead>
				                <tr>
				                  <th class="action">#</th>
				                  <th>Name</th>
				                  <th>Email</th>
				                  <th>Phone</th>
				                  <th>Location</th>
				                  <th>Created At</th>
				                  <th class="action">Status</th>
				                  <th class="action">Action</th>
				                </tr>
			                </thead>

							<tfoot>
					            <tr>
					            	<th>#</th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Location</th>
									<th>Created At</th>
									<th>Status</th>
									<th>Action</th>
					            </tr>
					        </tfoot>
			  			  </table>

						</div>
						<!-- /.box-body -->
		  			</div>
		  			<!-- /.box -->
				</div>
		
	  		</div>
	  		<!-- /.row -->

		</section>
		<!-- /.content -->
  	</div>
  	<!-- /.content-wrapper -->

@endsection

@section('script')
<script type="text/javascript">

$(document).ready(function() {
    
	$('#userTable').DataTable({
		"bProcessing": true,
		"serverSide": true,
		"order": [[ 5, "desc" ]],
		"ajax":{
			url :"{{ url('admin/user') }}",
			
			error: function(){  
				alert('Something went wrong');
			}
		},
		"aoColumns": [
			{ mData: 'DT_RowId' },
			{ mData: 'name' } ,
			{ mData: 'email' },
			{ mData: 'phone' },
			{ mData: 'location' },
			{ mData: 'created_at' },
			{ mData: 'status' },
			{ mData: 'actions' }
		],
		"aoColumnDefs": [
	      { "bSortable": false, "aTargets": ['action'] }
	    ],
	    "language": {
	    	"zeroRecords": "No users available"
	    }
	});
});


$(document).on('change','.userStatus', function () {
	var status = $(this).val();
	var id 	   = $(this).attr('id');

	var url = "{{ url('admin/user/update_status') }}";
	
	$.ajax({
        url: url,
        type: 'POST',
        data: {
          '_token': '{{ csrf_token() }}',
          'status': status,
          'id': 	id
        },
        success: function (res) 
        {
            console.log(res);
            if (res == 'success') 
            {
                window.location.href = "<?php echo url('/admin/user') ?>";
            }
        },
        error: function (data) {
            return false;
        }
    });
});

</script>
@endsection

