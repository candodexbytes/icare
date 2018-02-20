@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
@section('content')
@section('title', 'Change Password')
       <div id="page-wrapper">
    
        <div class="col-sm-12 col-md-12">
            <div class="bet_box col-sm-12">
                <h3 class="page-header">Change Password</h3>
       
                <!-- /.col-lg-12 -->
            @if (Session::has('success'))
                 {{ Session::get('success') }}
                 @endif

                  @if (Session::has('error'))
                 {{ Session::get('error') }}
                 @endif
                <div class="col-lg-10 no-pad"> 
                    <form class="form-horizontal" role="form" id="change-password-form" method="POST" action="">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label get_right">Current Password<span style="color: #ff0000">*</span></label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="current_password" >
                                @if ($errors->has('current_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label get_right">New Password<span style="color: #ff0000">*</span></label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="new_password">
                                @if ($errors->has('new_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label get_right">Confirm Password<span style="color: #ff0000">*</span></label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="new_password_confirmation">
                                @if ($errors->has('new_password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
@endguest