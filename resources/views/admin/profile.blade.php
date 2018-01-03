@extends('admin.layouts.layout')
@section('content')

<!-- Content Wrapper. Cont•••••ains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  	<h1>
			Admin Profile
			<small>Admin Profile Informations</small>
	  	</h1>
	  	<ol class="breadcrumb">
			<li><a href="{!! url('admin/dashboard') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Admin Profile</li>
	  	</ol>
	</section>

	<!-- Main content -->
	<section class="content">
	  	<!-- Info boxes -->
	  	<div class="row">
	  	
			<div class="col-md-12 col-md-8">
	  		<div class="box box-info">
			
			<div class="box-header with-border">
				@include('admin.partials.errors')
			</div>
					
			<form role="form" method="post" action="{{ route('updateProfile') }}">
			  	{{ csrf_field() }}

			    <div class="box-body">
			    	<div class="form-group pull-right">
					  	<a href="javascript:void(0);" onclick="changePassword()" class="btn btn-primary">Change Password</a>

					  	<a href="javascript:void(0);" onclick="changeEmail()" class="btn btn-primary">Change Email</a>
				 	</div>
				 	<div class="clearfix"></div>

				   	<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
				  		<label for="firstname" class="required">First Name </label>

					  	<input type="text" class="form-control" id="name" name="first_name" placeholder="First name" maxlength="40" value="{{ old('first_name', $user->first_name) }}">
				  		
				  		@if ($errors->has('first_name'))
						  	@foreach ($errors->get('first_name') as $msg) 
								<span class="help-block">
									<strong>{{ $msg }}</strong>
								</span>
						  	@endforeach
						@endif
					</div>

					<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
			            <label for="lname" class="control-label">Last Name</label>

			            <input id="lname"  placeholder="Last Name"  type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->last_name) }}" maxlength="25">

					  	@if ($errors->has('last_name'))
						  	<span class="help-block">
								<strong>{{ $errors->first('last_name') }}</strong>
						  	</span>
					  	@endif
			        </div>

				    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
			            <label for="username" class="control-label required">Username</label>

		                <input id="username" type="text" class="form-control" name="username" value="{{ old('username', $user->username) }}" maxlength="25" placeholder="User Name" >

		                @if ($errors->has('username'))
		                    <span class="help-block">
		                        <strong>{{ $errors->first('username') }}</strong>
		                    </span>
		                @endif
			        </div>

					<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						<label for="email" class="control-label required">Email</label>
						
					  	<input id="email" type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}"  placeholder="Email" maxlength="100" readonly>

					  	@if ($errors->has('email'))
						  	<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
						  	</span>
					  	@endif
					</div>

					<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
						<label for="tel" class="control-label">Phone Number</label>

				   		<input type="tel" maxlength="12" class="form-control" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" >

				   		 <input type="hidden" name="phone_code" id="co-code" value="{{ old('phone_code', $user->phone_code)!== null ? $user->phone_code : '1' }}">
				   		
				   		 @if ($errors->has('phone'))
						  	<span class="help-block">
								<strong>{{ $errors->first('phone') }}</strong>
						  	</span>
					  	@endif
				    </div>

			        <div class="form-group{{ $errors->has('dob') ? ' has-error' : ''}}">
                        <label for="dob" class="required control-label">Date Of Birth</label>

                        <input type="text" class="form-control textRead" placeholder="Date Of Birth" name='dob' id="datepicker" autocomplete="off"
                        value="{{ old('dob', show_date($user->user_dob)) }}" readonly>
                        
                        @if ($errors->has('dob'))
                            <span class="help-block">
                                <strong>{{ $errors->first('dob') }}</strong>
                            </span>
                        @endif
                    </div>

	               	<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
	                    <label for="gender" class="required control-label">Gender</label>

	                    <select class="form-control" name="gender" id="gender">
	                        <option value="m" {{ old('gender') == 'm' ||  $user->gender == "m" ? 'selected' : '' }}>Male</option>
	                        <option value="f" {{ old('gender') == 'f'  ||  $user->gender == "f" ? 'selected' : '' }}>Female</option>
	                        <option value="o" {{ old('gender') == 'o' ||  $user->gender == "o" ? 'selected' : '' }}>Other</option>
	                    </select>

	                    @if ($errors->has('gender'))
	                        <span class="help-block">
	                            <strong>{{ $errors->first('gender') }}</strong>
	                        </span>
	                    @endif
	                </div>

				    <div class="form-group{{ $errors->has('address_one') ? ' has-error' : '' }}">
			            <label for="address_one" class="control-label required">Address Line 1</label>

		                <input type="text" class="form-control" placeholder="Address Line 1" name='address_one' id="address_one"  value="{{ old('address_one', $user->address_one) }}" >
			            
		                @if ($errors->has('address_one'))
		                    <span class="help-block">
		                        <strong>{{ $errors->first('address_one') }}</strong>
		                    </span>
		                @endif
			        </div>

			        <div class="form-group{{ $errors->has('address_two') ? ' has-error' : '' }}">
			            <label for="address_two" class="control-label">Address Line 2</label>

		                <input type="text" class="form-control" placeholder="Address Line 2" name='address_two' id="address_two"  value="{{ old('address_two', $user->address_two) }}" >
		            
		                @if ($errors->has('address_two'))
		                    <span class="help-block">
		                        <strong>{{ $errors->first('address_two') }}</strong>
		                    </span>
		                @endif
			        </div>

				    <div class="form-group{{ $errors->has('google_id') ? ' has-error' : '' 
				     	}}">
						<label for="location" class="control-label required">City/State/Country</label>

						<div class="geo-details">
							<input type="hidden" name="city" data-geo="locality" value="{{ old('city' , $user_city['name']) }}">
							<input type="hidden" name="state" data-geo="administrative_area_level_1" value="{{ old('state', $user_city['state'] ) }}">
							<input type="hidden" name="country" data-geo="country" value="{{ old('country', $user_city['country']) }}">
						</div>

					  	<input id="city_state_country" type="text" class="form-control" name="location" value="{{ old('location' , 
                                    ($user_city['name']!=''? 
                                        ($user_city['name'] == $user_city['state'] ? 
                                            ($user_city['name'] . ', ' . $user_city['country']) : 
                                            ($user_city['name'] . ', ' . $user_city['state'] . ', ' . $user_city['country']
                                        ) 
                                    ) 
                                    : '' )
                                    ) }}" placeholder="Enter a city" maxlength="100"  >


					  	<input type="hidden" name="place_id" id="google_place_id" value="{{ old('place_id', $user_city['google_place_id']) }}"> 
					  	<input type="hidden" name="google_id" id="google_id" value="{{ old('google_id', $user_city['google_id']) }}">  
					  	@if ($errors->has('google_id'))
						  	<span class="help-block">
								<strong>{{ $errors->first('google_id') }}</strong>
						  	</span>
					  	@endif
					</div>

					<div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
		             	
		             	<label for="zip_code" class="control-label required">Zip Code</label>

		                <input type="text" maxlength="6" class="form-control" placeholder="zip code" name='zip' id="zip"  value="{{ old('zip', $user->zip) }}" >
		            
		                @if ($errors->has('zip'))
		                    <span class="help-block">
		                        <strong>{{ $errors->first('zip') }}</strong>
		                    </span>
		                @endif
		            
			        </div>

			  	</div><!-- /.box-body -->
			  	<div class="box-footer">
					<a href="{{ route('dashboard') }}" class="btn btn-default">Cancel</a>
					<button type="submit" class="btn btn-info pull-right">Save</button>
				</div>
			</form>

		  	</div>
			</div>

	  	</div>
	</section>
	<!-- /.content -->
  </div>

  <!-- Model to change Email -->
  <div class="modal fade" id="emailModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Email</h4>
        </div>
        <div class="modal-body">
          
          <form method="post" action="{{ url('admin/update_email') }}" class="" id="emailchange">
          	{{ csrf_field() }}

          	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				<label for="email" class=" control-label required">New Email</label>
				
			  	<input id="email" type="email"  name="email" class="form-control" value="{{ Auth::user()->email }}"  placeholder="Email" maxlength="100" required>
			</div>

          	<div class="form-group{{ $errors->has('password') ? ' has-error' : ''}}">
				<label for="Password" class=" control-label required">Password
				</label>
			  	<input id="password" type="password"  name="password" class="form-control" value=""  placeholder="Password" maxlength="100" required>
			</div>
          
        </div>
        <div class="modal-footer">
          <i class="fa fa-spin fa-refresh" id="loading" style="display:none;"></i>	
          <button type="button" id="submit" class="btn btn-default">Change</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Model to change password -->

  <div class="modal fade" id="passwordModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Password</h4>
        </div>
        <div class="modal-body">
          
          <form method="post" action="{{ url('admin/change_password') }}" id="passwordChange">
          	{{ csrf_field() }}

          	<div class="form-group">
				<label for="current_password" class=" control-label required">Current Password</label>

			  	<input id="current_password" type="password"  name="current_password" class="form-control" placeholder="Current Password" required>
			</div>

		 	<div class="form-group">
				<label for="Password" class=" control-label required">New Password 
				<span class="glyphicon glyphicon-info-sign" title="The password must be at least 8 characters with 1 letter and 1 number."></span>
				</label>
				

			  	<input id="password" type="password"  name="password" class="form-control" placeholder="New Password" required>
			</div>

		  	<div class="form-group">
                <label for="password_confirmation" class="control-label required">Confirm Password</label>
                
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                
            </div>
          
        </div>
        <div class="modal-footer">         

          <button type="button" id="pwdsubmit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
      
    </div>
  </div>

@endsection

@section('script')
<script src="http://malsup.github.com/jquery.form.js"></script>
<script type="text/javascript">
function changeEmail() {
	$('#emailModal').modal('show');	
}

function changePassword() {
	$('#passwordModal').modal('show');	
}

$(document).on('click', '#submit', function() { 
	$('#emailchange').ajaxSubmit({

	    beforeSubmit: function(){
	    	$('#loading').hide();
	    	$('#emailchange').find('.help-block').remove();
	    	$('#emailchange').closest('.form-group').removeClass('has-error');
	    },
	    success: function (res) {
	        if(res.status==false){
	        	messages = res.message;
	        	jQuery.each(messages, function(index, item) {

	        		if(jQuery.isArray(item)){
	        			jQuery.each(item , function(key , val) {
	        				$('#emailchange').find('#'+index).parent().append('<span class="help-block">'+val+'<strong></span>')
		        		})
	        		}
	        		else {
	        			$('#emailchange').find('#'+index).parent().append('<span class="help-block">'+item+'<strong></span>')
	        		}

				   	$('#emailchange').find('#'+index).closest('.form-group').addClass('has-error');
				});
	        }

	        if(res.status==true)
	        {
	        	$('#loading').show();
	        	window.location.href = "<?php echo url('/admin/profile') ?>";	
	        }
	    },
	    error: function (data) {
	        return false;
	    }
	});
});


$(document).on('click', '#pwdsubmit', function() { 
	$('#passwordChange').ajaxSubmit({

	    beforeSubmit: function(){
	    	$('#passwordChange').find('.help-block').remove();
	    	$('#passwordChange').closest('.form-group').removeClass('has-error');
	    },
	    success: function (res) {
	        if(res.status==false){
	        	messages = res.message;
	        	jQuery.each(messages, function(index, item) {
	        		if(jQuery.isArray(item)){
	        			jQuery.each(item , function(key , val) {
	        				$('#passwordChange').find('#'+index).parent().append('<span class="help-block">'+val+'<strong></span>')
		        		})
	        		}
	        		else {
	        			$('#passwordChange').find('#'+index).parent().append('<span class="help-block">'+item+'<strong></span>')
	        		}

				    $('#passwordChange').find('#'+index).closest('.form-group').addClass('has-error');
				});
	        }

	        if(res.status==true) {
	        	window.location.href = "<?php echo url('/admin/profile') ?>";	
	        }
	    },
	    error: function (data) {
	        return false;
	    }
	});
});

</script>
@endsection
