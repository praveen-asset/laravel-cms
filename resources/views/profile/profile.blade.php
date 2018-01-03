@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Profile</div>
                <div class="panel-body">
                    
                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{!! Session::get('alert-' . $msg) !!} 
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                </p>
                            @endif
                        @endforeach
                    </div>

                    <form class="form-horizontal" method="POST" action="{{ route('profile_update') }}" enctype='multipart/form-data'>
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('profile_picture') ? ' has-error' : '' }}">
                            <label for="profile_picture" class="col-md-4 control-label">Profile Picture</label>

                            <div class="col-md-6">
                                <input id="profile_picture" type="file" class="form-control" name="profile_picture">
                                @if ($user->profile_picture != null && file_exists(public_path('uploads/profile-picture/'.$user->profile_picture)))
                                    <img src="{{ asset('uploads/profile-picture/'.$user->profile_picture.'?'.time())}}" width="200" />
                                @else
                                    <img src="{{ asset('img/avatar.jpg')}}" width="200" />
                                @endif

                                @if ($errors->has('profile_picture'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('profile_picture') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">First Name<span>*</span></label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name', $user['first_name']) }}" maxlength="25" required>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Last Name<span>*</span></label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name', $user['last_name']) }}" maxlength="25" required>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control" name="phone" value="{{ old('phone', $user['phone'] ) }}" minlength="6" maxlength="12">
                                <input id="ccode" type="hidden" name="ccode" value="{{ old('ccode', $user['phone_code']) !== null ? $user['phone_code'] : '1' }}">
                                <input id="iso2" type="hidden" name="iso2" value="{{ old('iso2') }}">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">Username<span>*</span></label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username', $user['username']) }}" maxlength="25" required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Email<span>*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user['email']) }}" maxlength="100" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="col-md-4 control-label">Gender<span>*</span></label>

                            <div class="col-md-6">

                                <select class="form-control" name="gender" id="gender">
                                    <option value="m" {{ old('gender') == 'm' ||  $user['gender'] == "m" ? 'selected' : '' }}>Male</option>
                                    <option value="f" {{ old('gender') == 'f'  ||  $user['gender'] == "f" ? 'selected' : '' }}>Female</option>
                                    <option value="o" {{ old('gender') == 'o' ||  $user['gender'] == "o" ? 'selected' : '' }}>Other</option>
                                </select>

                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                         <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                            <label for="dob" class="col-md-4 control-label">Date Of Birth<span>*</span></label>

                            <div class="col-md-6">
                                
                                <input type="text" class="form-control textRead" placeholder="Date of Birth" name='dob' id="datepicker" autocomplete="off" value="{{ old('dob', show_date($user['user_dob'])) }}" required="required" readonly="" >
                            
                                @if ($errors->has('dob'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('address_one') ? ' has-error' : '' }}">
                            <label for="address_one" class="col-md-4 control-label">Address Line 1<span>*</span></label>

                            <div class="col-md-6">

                                <input type="text" class="form-control" placeholder="Address Line 1" name='address_one' id="address_one"  value="{{ old('address_one', $user['address_one']) }}" required>
                            
                                @if ($errors->has('address_one'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address_one') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address_two') ? ' has-error' : '' }}">
                             <label for="address_two" class="col-md-4 control-label">Address Line 2</label>

                            <div class="col-md-6">

                                <input type="text" class="form-control" placeholder="Address Line 2" name='address_two' id="address_two"  value="{{ old('address_two', $user['address_two']) }}" >
                            
                                @if ($errors->has('address_two'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address_two') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('google_id') ? ' has-error' : '' }}">
                            <label for="google_id" class="col-md-4 control-label">City, State, Country<span>*</span></label>

                            <div class="col-md-6">
                                
                                <div class="geo-details">
                                    <input type="hidden" name="city" data-geo="locality" value="{{ old('city', $user_city['name']) }}">

                                    <input type="hidden" name="state" data-geo="administrative_area_level_1" value="{{ old('state', $user_city['state']) }}">

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
                                    ) }}" placeholder="Enter a city" maxlength="100" required>

                                <input id="google_id" type="hidden" class="form-control" name="google_id" value="{{ old('google_id' , $user_city['google_id']) }}">
                                
                                <input id="google_place_id" type="hidden" class="form-control" name="place_id" value="{{ old('place_id' , $user_city['google_place_id']) }}">

                                @if ($errors->has('google_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('google_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
                            <label for="zip" class="col-md-4 control-label">Zip Code
                            </label>

                            <div class="col-md-6">

                                <input type="text" class="form-control" placeholder="Zip Code" name='zip' id="zip"  value="{{ old('zip' , $user['zip']) }}" maxlength="6">
                            
                                @if ($errors->has('zip'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('zip') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('scripts')
<script src="{{ asset('js/intlTelInput.js') }}"></script>

<script type="text/javascript">

$("#phone").intlTelInput({
    separateDialCode: true,
    nationalMode: true,
    formatOnDisplay: true,
    utilsScript: "{{ asset('js/utils.js') }}"
});


var phonenum = $("#phone").val();
var ccode    = $("#ccode").val();

var val = '+'+ccode+''+phonenum;
$("#phone").intlTelInput("setNumber", val);


$("#phone").on("countrychange", function(e, countryData) {

    //console.log(countryData);

    $("#ccode").val(countryData.dialCode);
    $("#iso2").val(countryData.iso2);
});
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkYcFk5rZMvW2Sf0JnCZm9YGvG-Zwgb2U&libraries=places" ></script>
<script src="{{ asset('js/jquery.geocomplete.js') }}"></script>

<script type="text/javascript">
$(function(){
    $("#city_state_country").geocomplete(
        {
            types: ['(cities)'],
            details: ".geo-details", 
            detailsAttribute: "data-geo"
        }
    ).bind("geocode:result", function(event, result){
        $('#google_id').val(result.id);
        $('#place_id').val(result.place_id);
    });
});

 $( function() {
    $( "#datepicker" ).datepicker(
        { 
            dateFormat: '{{ env("DATE_FORMAT_JS", "mm/dd/yy") }}',
            yearRange: "{{ date('Y') - 100 }}:{{ date('Y') - 10 }}",
            changeMonth: true,
            changeYear: true,
            maxDate:"-10y"
        }
    );
});
</script>


@endsection


@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/intlTelInput.css') }}" />
@endsection