@include('admin.partials.errors')

<form role="form" method="post" enctype="multipart/form-data" class="" action="{{ route('user.update', encrypt($user['id'])) }}">

    <input type="hidden" name="_method" value="put" />
	{{ csrf_field() }}
	<div class="box-body">
		<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
	        <label for="fname" class="control-label required">First Name</label>
	        
            <input id="fname" placeholder="First Name"  type="text" class="form-control" name="first_name" value="{{ old('first_name' , $user['first_name']) }}" maxlength="25" required="">
		  	@if ($errors->has('first_name'))
			  	<span class="help-block">
					<strong>{{ $errors->first('first_name') }}</strong>
			  	</span>
		  	@endif
	    </div>
            
        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
            <label for="lname" class="control-label">Last Name</label>
           
            <input id="lname"  placeholder="Last Name"  type="text" class="form-control" name="last_name" value="{{ old('last_name' , $user['last_name']) }}" maxlength="25">
		  	@if ($errors->has('last_name'))
			  	<span class="help-block">
					<strong>{{ $errors->first('last_name') }}</strong>
			  	</span>
		  	@endif
        </div>

	    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <label for="username" class="control-label">Username</label>
            
            <input id="username" type="text" class="form-control" name="username" value="{{ old('username' , $user['username']) }}" maxlength="20" placeholder="User Name">
            @if ($errors->has('username'))
                <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
        </div>

		<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
			<label for="email" class=" control-label required">Email</label>
		  	
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email' , $user['email']) }}"  placeholder="Email" maxlength="100"
            required="">
		  	@if ($errors->has('email'))
			  	<span class="help-block">
					<strong>{{ $errors->first('email') }}</strong>
			  	</span>
		  	@endif
		</div>

		<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
			<label for="tel" class="control-label">Phone Number</label>

	   		<input type="tel" maxlength="15" class="form-control" name="phone" id="phone" value="{{ old('phone' , $user['phone']) }}" maxlength="12">
	   		 
	   		 <input type="hidden" name="phone_code" id="co-code" value="{{ old('phone_code' , $user['phone_code']) !== null ? $user['phone_code'] : '1' }}">

	   		 @if ($errors->has('phone'))
			  	<span class="help-block">
					<strong>{{ $errors->first('phone') }}</strong>
			  	</span>
		  	@endif
	    </div>

	    <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
            <label for="dob" class="control-label">Date Of Birth</label> 
            
            <input type="text" class="form-control textRead" placeholder="Date Of Birth" name='dob' id="datepicker" autocomplete="off" value="{{ old('dob' , show_date($user->user_dob)) }}" readonly>

            @if ($errors->has('dob'))
                <span class="help-block">
                    <strong>{{ $errors->first('dob') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
            <label for="gender" class="control-label">Gender</label>
            <select class="form-control" name="gender" id="gender">
                
                @if($user['gender'] == 'u')
                   <option value="u" {{ old('gender') == 'u' || $user['gender'] == "u" ? 'selected' : '' }}>Unspecified</option>
                @endif

                <option value="m" {{ old('gender') == 'm' || $user['gender'] == "m" ? 'selected' : '' }}>Male</option>
                <option value="f" {{ old('gender') == 'f' || $user['gender'] == "f" ? 'selected' : '' }}>Female</option>
                <option value="o" {{ old('gender') == 'o' || $user['gender'] == "o" ? 'selected' : '' }}>Other</option>

            </select>
            @if ($errors->has('gender'))
                <span class="help-block">
                    <strong>{{ $errors->first('gender') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label for="status" class="control-label">Status</label>

            <select name="status" class="form-control">
                @if($user['status'] == 0)
                    <option value="0" {{ old('status') == 0 || $user['status'] == 0 ? 'selected' : '' }} >Pending</option>
                @endif
                <option value="1" {{ old('status') == 1 || $user['status'] == 1 ? 'selected' : '' }}>Active</option>

                <option value="2" {{ old('status') == 2 || $user['status'] == 2 ? 'selected' : '' }}>Inactive</option>
                
                <option value="3" {{ old('status') == 3 || $user['status'] == 3 ? 'selected' : '' }}>Blocked</option>
            </select>
        </div>
            
	    <div class="form-group{{ $errors->has('address_one') ? ' has-error' : '' }}">
            <label for="address_one" class="control-label">Address Line 1</label>
            <input type="text" class="form-control" placeholder="Address Line 1" name='address_one' id="address_one"  value="{{ old('address_one' , $user['address_one']) }}" >
            @if ($errors->has('address_one'))
                <span class="help-block">
                    <strong>{{ $errors->first('address_one') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('address_two') ? ' has-error' : '' }}">
            <label for="address_two" class="control-label">Address Line 2</label>
            <input type="text" class="form-control" placeholder="Address Line 2" name='address_two' id="address_two"  value="{{ old('address_two' , $user['address_two']) }}" >
        
            @if ($errors->has('address_two'))
                <span class="help-block">
                    <strong>{{ $errors->first('address_two') }}</strong>
                </span>
            @endif
        </div>

	    <div class="form-group{{ $errors->has('google_id') ? ' has-error' : '' }}">
			<label for="location" class="control-label required">City/State/Country</label>
			<div class="geo-details">
				<input type="hidden" name="city" data-geo="locality" value="{{ old('city' , $city['name']) }}">

				<input type="hidden" name="state" data-geo="administrative_area_level_1" value="{{ old('state' , $city['state']) }}">
				
                <input type="hidden" name="country" data-geo="country" value="{{ old('country' , $city['country']) }}">
			</div>

		    <input id="city_state_country" type="text" class="form-control" name="location" value="{{ old('location' , 
                                    ($city['name']!=''? 
                                        ($city['name'] == $city['state'] ? 
                                            ($city['name'] . ', ' . $city['country']) : 
                                            ($city['name'] . ', ' . $city['state'] . ', ' . $city['country']
                                        ) 
                                    ) 
                                    : '' )
                                    ) }}" placeholder="Enter a city" maxlength="100">

		  	
		  	<input type="hidden" name="place_id" id="google_place_id" value="{{ old('place_id' , $city['google_place_id']) }}"> 
		  	<input type="hidden" name="google_id" id="google_id" value="{{ old('google_id' , $city['google_id']) }}">  
		  	@if ($errors->has('google_id'))
			  	<span class="help-block">
					<strong>{{ $errors->first('google_id') }}</strong>
			  	</span>
		  	@endif
		</div>

	    <div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
            <label for="zip" class="control-label">Zip Code</label>
            <input type="text" class="form-control" placeholder="Zip Code" name='zip' id="zip"  value="{{ old('zip' , $user['zip']) }}" maxlength="6">
            @if ($errors->has('zip'))
                <span class="help-block">
                    <strong>{{ $errors->first('zip') }}</strong>
                </span>
            @endif
        </div>
        
		<div class="box-footer">
			<a href="{{ route('user.index') }}" class="btn btn-default">Cancel</a>
			<button type="submit" class="btn btn-info pull-right">Save</button>
		</div>
</form>