@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" id="registerForm" method="POST" action="{{ route('register') }}" onsubmit="return validateform()">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">First Name<span>*</span></label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" maxlength="25" required autofocus>

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
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" maxlength="25" required>

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
                                <input id="phone" type="tel" class="form-control" name="phone" value="{{ old('phone') }}" minlength="6" maxlength="12">
                                <input id="ccode" type="hidden" name="ccode" value="{{ old('ccode') }}">
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
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" maxlength="25" required>

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
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" maxlength="100" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password <span class="glyphicon glyphicon-info-sign" title="The password should contain at least 1 letter and 1  number."></span> <span>*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

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
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('google_id') ? ' has-error' : '' }}">
                            <label for="google_id" class="col-md-4 control-label">City, State, Country<span>*</span></label>

                            <div class="col-md-6">
                                <div class="geo-details">
                                    <input type="hidden" id="city" value="{{ old('city') }}" name="city" data-geo="locality">
                                    <input type="hidden" id="state" value="{{ old('state') }}" name="state" data-geo="administrative_area_level_1">
                                    <input type="hidden" id="country" value="{{ old('country') }}" name="country" data-geo="country">
                                </div>
                                <input id="city_state_country" type="text" class="form-control" name="city_state_country" value="{{ old('city_state_country') }}" placeholder="Enter a city" maxlength="100" required>
                                <input id="google_id" type="hidden" class="form-control" name="google_id" value="{{ old('google_id') }}">
                                <input id="google_place_id" type="hidden" class="form-control" name="place_id" value="{{ old('place_id') }}">

                                @if ($errors->has('google_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('google_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                            <label for="g-recaptcha-response" class="col-md-4 control-label"></label>

                            <div class="col-md-6 captcha-block">
                                {!! app('captcha')->display($attributes = ['data-callback' => 'imNotARobot']) !!}

                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                                <a href="{{ url('/login') }}">Have an account? Login</a>
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
    initialCountry: "{{ old('iso2', null) !== null ? old('iso2') : '' }}",
    separateDialCode: true,
    utilsScript: "{{ asset('js/utils.js') }}"
});

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
        }
    ).bind("geocode:result", function(event, result){
        $('#google_id').val(result.id);
        $('#place_id').val(result.place_id);
    });
});
</script>

<!-- The reCAPTCHA Ajax script -->
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<script type="text/javascript">
function validateform(){
    var captcha_response = grecaptcha.getResponse();
    if(captcha_response.length == 0)
    {
        $('.captcha-block').append('<span class="help-block"><strong>The captcha field is required<\/script><\/script>');
        $('.captcha-block').closest('.form-group').addClass('has-error');
        return false;
    }
    else
    {
        return true;
    }
}

function imNotARobot(){
    $('.captcha-block').parent('.form-group').removeClass('has-error');
    $('.captcha-block .help-block').remove();
}
</script>
@endsection


@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/intlTelInput.css') }}" />
@endsection