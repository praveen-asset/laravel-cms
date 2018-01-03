@extends('admin.layouts.layout')
@section('content')

	<!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
	  		<h1>
				Manage CMS
	  		</h1>
	  		<ol class="breadcrumb">
				<li><a href="{!! url('admin/dashboard') !!}"><i class="fa fa-dashboard"></i>Home</a></li>
				<li class="active">Cms</li>
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

			  			  <table id="cmsTable" class="table table-bordered table-hover datatable">
  			  				
  			  				<thead>
				                <tr>
				                  <th>Title</th>
				                  <th>Updated At</th>
				                  <!-- <th class="action">Status</th> -->
				                  <th class="action">Action</th>
				                </tr>
			                </thead>

							<tfoot>
					            <tr>
									<th>Title</th>
									<th>Updated At</th>
									<!-- <th>Status</th> -->
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
	$('#cmsTable').DataTable({
		"bProcessing": true,
		"serverSide": true,
		"ajax":{
			url :"{{ url('admin/cms') }}",
			
			error: function(){  
				alert('Something went wrong');
			}
		},
		"aoColumns": [
			{ mData: 'title' },
			{ mData: 'updated_at' },
			/*{ mData: 'status' },*/
			{ mData: 'actions' },
		],
		"aoColumnDefs": [
	      { "bSortable": false, "aTargets": ['action'] }
	    ]
	});
});


$(document).on('change','.cmsStatus', function () {
	var status = $(this).val();
	var id 	   = $(this).attr('id');

	var url = "{{ url('admin/cms/update_status') }}";
	
	$.ajax({
        url: url,
        type: 'POST',
        data: {
          '_token': '{{ csrf_token() }}',
          'status': status,
          'id': 	id
        },
        success: function (res) {
            console.log(res);
            if (res == 'success') {
                window.location.href = "<?php echo url('/admin/cms') ?>";
            }
        },
        error: function (data) {
            return false;
        }
    });
});

</script>
@endsection

