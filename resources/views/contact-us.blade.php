@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Contact Us</div>
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

                    <form class="form-horizontal" id="registerForm" method="POST" action="{{ route('contact-us') }}" onsubmit="return validateform()">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name<span>*</span></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" maxlength="50" placeholder="Enter Name" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Email<span>*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" maxlength="100" placeholder="Enter Email" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" maxlength="15" placeholder="Enter Phone">

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                            <label for="subject" class="col-md-4 control-label">Subject<span>*</span></label>

                            <div class="col-md-6">
                                <input id="subject" type="text" class="form-control" name="subject" value="{{ old('subject') }}" maxlength="100" placeholder="Enter Subject" required>

                                @if ($errors->has('subject'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                            <label for="message" class="col-md-4 control-label required">Message<span>*</span></label>

                            <div class="col-md-6">
                                <textarea id="message" class="form-control" name="message" rows="5" maxlength="1000" placeholder="Enter Message (Max Length: 1000 characters)">{{ old('message') }}</textarea>

                                @if ($errors->has('message'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
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