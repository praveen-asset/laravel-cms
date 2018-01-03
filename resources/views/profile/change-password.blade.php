@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Change Password</div>
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

                    <form class="form-horizontal" method="POST" action="{{ route('change-password') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                            <label for="current_password" class="col-md-4 control-label required">Current Password</label>

                            <div class="col-md-6">
                                <input id="current_password" type="password" class="form-control" name="current_password" placeholder="Current Password" required>

                               
                                @if ($errors->has('current_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                            <label for="new_password" class="col-md-4 control-label required">New Password <span class="glyphicon glyphicon-info-sign" title="The password should contain at least 1 letter and 1  number."></span> </label>

                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control" name="new_password" placeholder="New Password" required>

                               
                                @if ($errors->has('new_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password_confirmation" class="col-md-4 control-label required">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" placeholder="Confirm Password" required>
                               
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                                
                                <a href="javascript:void(0)" class="btn btn-link" data-toggle="modal" data-target="#passwordModal" ui-toggle-class="bounce" ui-target="#animate">Forgot Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="passwordModal" class="modal fade" data-backdrop="true" style="display: none;">
    <div class="modal-dialog" id="animate" ui-class="bounce">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
            </div>
            <div class="modal-body text-center p-lg">
                <p>
                   <strong>This action will logged out you, want to continue?</strong>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark-white" data-dismiss="modal">No</button>
                <a href="{{ route('checkreset') }}" class="btn btn-primary">Yes</a>
            </div>
        </div>
    </div>
</div>
@endsection
