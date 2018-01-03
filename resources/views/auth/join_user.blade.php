@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Join User</div>
                <div class="panel-body">

                    <form class="form-horizontal" method="POST" action="{{ route('joinuser.create') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">First Name<span>*</span></label>

                            <div class="col-md-6">
                                <input type="hidden" name="userid" value="{{ old('userid' , $user['id']) }}">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name' , $user['first_name']) }}" maxlength="25" required autofocus placeholder="First Name">

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
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name' , $user['last_name']) }}" maxlength="25" required placeholder="Last Name">

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
                                <input id="phone" type="tel" class="form-control" name="phone" value="{{ old('phone' , $user['phone'] ) }}" minlength="6" maxlength="15" placeholder="Phone Number">
                                
                                <input id="ccode" type="hidden" name="ccode" value="{{ old('ccode' , $user['phone_code']) !== null ? $user['phone_code'] : '1' }}">

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
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username' , $user['username']) }}" maxlength="20" required placeholder="User Name">

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
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user['email']) }}" maxlength="100" readonly>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        
                            <label for="password" class="col-md-4 control-label">Password <span class="glyphicon glyphicon-info-sign" title="The password must be at least 8 characters with 1 letter and 1 number."></span> <span>*</span> </label>                            
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="Password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password<span>*</span></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
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

                                <input type="text" class="form-control textRead" placeholder="Date Of Birth" name='dob' id="datepicker" autocomplete="off" value="{{ old('dob' , show_date($user['user_dob'])) }}" required readonly="">
                            
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

                                <input type="text" class="form-control" placeholder="Address Line 1" name='address_one' id="address_one"  value="{{ old('address_one' , $user['address_one']) }}" >
                            
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

                                <input type="text" class="form-control" placeholder="Address Line 2" name='address_two' id="address_two"  value="{{ old('address_two' , $user['address_two']) }}" >
                            
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
                                    ) }}" placeholder="Enter a city" maxlength="100" required>

                                <input id="google_id" type="hidden" class="form-control" name="google_id" value="{{ old('google_id' , $city['google_id']) }}">
                                <input id="google_place_id" type="hidden" class="form-control" name="place_id" value="{{ old('place_id' , $city['google_place_id']) }}">

                                @if ($errors->has('google_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('google_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
                            <label for="zip" class="col-md-4 control-label">Zip Code<span>*</span> </label>

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
                                    Register
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
    //initialCountry: "{{ old('iso2', null) !== null ? old('iso2') : '' }}",
    separateDialCode: true,
    nationalMode: true,
    formatOnDisplay: true,
    utilsScript: "{{ asset('js/utils.js') }}"
});

var phonenum = $("#phone").val();
var ccode    = $("#ccode").val();
var val = ccode+''+phonenum;
if(phonenum=="")
{
    val = '1';
}

$("#phone").intlTelInput("setNumber", '+'+val);
$("#phone").on("countrychange", function(e, countryData) {
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
    }).bind("geocode:result", function(event, result){
        $('#google_id').val(result.id);
        $('#place_id').val(result.place_id);
    });
});

$( function() {
    $( "#datepicker" ).datepicker(
        { 
            dateFormat: '{{ env("DATE_FORMAT_JS", "mm/dd/yy")}}',
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