@include('admin.partials.errors')
 
	<form role="form" method="post" enctype="multipart/form-data" class="" action="{{ route('user.store') }}">
	{{ csrf_field() }}
	<div class="box-body">

		<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
            
	        <label for="fname" class="control-label required">First Name</label>
	        <div>
	        <input id="fname" placeholder="First Name"  type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" maxlength="25" required>

		  	@if ($errors->has('first_name'))
			  	<span class="help-block">
					<strong>{{ $errors->first('first_name') }}</strong>
			  	</span>
		  	@endif
		  	</div>
	    </div>
            
        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
            <label for="lname" class="control-label">Last Name</label>

            <div>
            <input id="lname"  placeholder="Last Name"  type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" maxlength="25">

		  	@if ($errors->has('last_name'))
			  	<span class="help-block">
					<strong>{{ $errors->first('last_name') }}</strong>
			  	</span>
		  	@endif

		  	</div>
        </div>

        
		<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

			<label for="email" class=" control-label required">Email</label>
			<div class="">
			  	<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"  placeholder="Email" maxlength="100" required>

			  	@if ($errors->has('email'))
				  	<span class="help-block">
						<strong>{{ $errors->first('email') }}</strong>
				  	</span>
			  	@endif

			</div>

		</div>

		<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
			<label for="tel" class="control-label">Phone Number</label>
		   	<div class="">
		   		<input type="tel" maxlength="15" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" >
		   		 
		   		<input type="hidden" name="phone_code" id="co-code" value="{{ old('phone_code', '1') }}">
		   		<input id="iso2" type="hidden" name="iso2" value="{{ old('iso2') }}">

		   		 @if ($errors->has('phone'))
				  	<span class="help-block">
						<strong>{{ $errors->first('phone') }}</strong>
				  	</span>
			  	@endif
		   	</div>
	    </div>

	    <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
			<label for="location" class="control-label">City/State/Country</label>

			<div class="">
				<div class="geo-details">
					<input type="hidden" name="city" data-geo="locality">
					<input type="hidden" name="state" data-geo="administrative_area_level_1">
					<input type="hidden" name="country" data-geo="country">
				</div>
			  	<input id="city_state_country" type="text" class="form-control" name="location" value="{{ old('location') }}" placeholder="Location">

			  	<input type="hidden" name="place_id" id="google_place_id" value="{{ old('place_id') }}"> 
			  	<input type="hidden" name="google_id" id="google_id" value="{{ old('google_id') }}">  

			  	@if ($errors->has('location'))
				  	<span class="help-block">
						<strong>{{ $errors->first('location') }}</strong>
				  	</span>
			  	@endif
			</div>
		</div>

	 
	<!-- /.box-body -->
	<div class="box-footer">
		<a href="{{ route('user.index') }}" class="btn btn-default">Cancel</a>
		<button type="submit" class="btn btn-info pull-right">Save</button>
	</div>
	<!-- / form -->
</form>