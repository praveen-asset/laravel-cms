@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Confirm</div>
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

                    <form class="form-horizontal" method="POST" action="{{ route('register_verify') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('confirmation_code') ? ' has-error' : '' }}">
                            <label for="confirmation_code" class="col-md-4 control-label">Confirmation Code</label>

                            <div class="col-md-6">
                                <input id="confirmation_code" type="text" class="form-control" name="confirmation_code" placeholder="Confirmation Code" required>
                                <span>Put confirmation code to verify your account.</span>
                                @if ($errors->has('confirmation_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('confirmation_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Continue
                                </button>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="button" onclick="event.preventDefault();window.location.href='{{ url('/') }}'" class="btn btn-danger">
                                    Not Now
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="form-group">
                        <div class="col-md-6">
                            <a href="javascript:void(0)" class="open-change-email">To change your email click here</a>
                        </div>
                    </div>

                    <br>

                    <div class="change-email {{ $errors->has('email') ? '' : ' hide' }}">
                        <form class="form-horizontal" method="POST" action="{{ route('change-email', encrypt($user_id)) }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">New E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="New E-Mail Address" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
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
<script type="text/javascript">
$(document).ready(function(){
    $('.open-change-email').click(function(e){
        $('.change-email').toggleClass('hide');
    })
})
</script>
@endsection
