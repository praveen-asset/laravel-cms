@extends('admin.layouts.layout')
@section('content')

	<!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
	  		<h1>
				Inquiries
	  		</h1>
	  		<ol class="breadcrumb">
				<li>
					<a href="{!! url('admin/dashboard') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active"><!-- <i class="fa fa-gears"></i> -->Inquiries</li>
	  		</ol>
		</section>

		<!-- Main content -->
		<section class="content">
	  		<!-- Info boxes -->
	  		<div class="row">
				<div class="col-xs-12">
		  			<div class="box">
						<div class="box-body">

			  			  @include('admin.partials.errors')

			  			  <table id="userTable" class="table table-bordered table-hover datatable">
  			  				
  			  				<thead>
				                <tr>
				                  <th class="action">#</th>
				                  <th>INQ ID</th>
				                  <th>Name</th>
				                  <th>Email</th>
				                  <th>Phone</th>
				                  <th>Subject</th>
				                  <th>Message</th>
				                  <th>Created At</th>
				                  <th class="action">Action</th>
				                </tr>
			                </thead>

							<tfoot>
					            <tr>
					            	<th>#</th>
									<th>INQ ID</th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Subject</th>
									<th>Message</th>
									<th>Created At</th>
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
		"order": [[ 7, "desc" ]],
		"ajax":{
			url :"{{ url('admin/inquiry') }}",
			
			error: function(){  
				alert('Something went wrong');
			}
		},
		"aoColumns": [
			{ mData: 'DT_RowId' },
			{ mData: 'INQ_ID' } ,
			{ mData: 'name' } ,
			{ mData: 'email',
				render: function(data, type, row) {
					return data != '' ? '<a href="mailto:'+data+'">'+data+'</a>' : '';
		    	}
			},
			{ mData: 'phone',
				render: function(data, type, row) {
			        return data != '' ? '<a href="tel:'+data+'">'+data+'</a>' : '';
		    	}
			},
			{ mData: 'subject' },
			{ mData: 'message' },
			{ mData: 'created_at' },
			{ mData: 'actions' }
		],
		"aoColumnDefs": [
	      { "bSortable": false, "aTargets": ['action'] }
	    ],
	    "language": {
	    	"zeroRecords": "No inquiries available"
	    }
	})
});
</script>
@endsection

