@extends('admin.layouts.layout')
@section('content')

	<!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
	  		<h1>
				Email Templates
	  		</h1>
	  		<ol class="breadcrumb">
				<li>
					<a href="{!! url('admin/dashboard') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
				<li class="active">Email Templates</li>
	  		</ol>
		</section>

		<!-- Main content -->
		<section class="content">
	  		<!-- Info boxes -->
	  		<div class="row">
				<div class="col-xs-12">
		  			<div class="box">
						<div class="box-header">
						</div>
						<!-- /.box-header -->
						<div class="box-body">
			  			  @include('admin.partials.errors')

			  			  <table id="templateTable" class="table table-bordered table-hover datatable">
  			  				
  			  				<thead>
				                <tr>
				                  <th>Slug</th>
				                  <th>Subject</th>
				                  <th>Updated At</th>
				                  <th class="action">Action</th>
				                </tr>
			                </thead>

							<tfoot>
					            <tr>
				                  <th>Slug</th>
				                  <th>Subject</th>
				                  <th>Updated At</th>
				                  <th class="action">Action</th>
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
    
	$('#templateTable').DataTable({
		"bProcessing": true,
		"serverSide": true,
		"ajax":{
			url :"{{ url('admin/email') }}",
			
			error: function(){  
				alert('Something went wrong');
			}
		},
		"aoColumns": [
			{ mData: 'slug' } ,
			{ mData: 'subject' },
			{ mData: 'created_at' },
			{ mData: 'actions' }
		],
		"aoColumnDefs": [
	      { "bSortable": false, "aTargets": ['action'] }
	    ],
	    "language": {
	    	"zeroRecords": "No templates available"
	    }
	});
});
</script>

@endsection