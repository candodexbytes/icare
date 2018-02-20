@extends('layouts.app')
@section('title',"ICARES | Reset Password")
@section('content')
<div class="intro">
    <div class="intro-body">
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 text-center">
            <div class="login-logo">
                <a href="#"><img src="{{url('')}}/assets/images/login.png" alt="" width="150" /></a>
            </div>
            <div class="app-cam-form">
                <div class="app-cam">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary login_btn">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="login_link">
        <a href="{{url('login')}}" class="btn btn-link">I remember my details!</a>
    </div>
</div>
</div>
</div>
</div>
</div>
@endsection
<style type="text/css">
body, html {
    height: 100%;
    width: 100%
}
.intro, body, html {
width: 100%
}
.intro {
    display: table;
    height: auto;
    padding: 100px 0;
    text-align: center;
    color: #444;
    /*background: url('images/IMG_2816-ridimensionata2.JPG') bottom center no-repeat ;*/
    -webkit-background-size: cover;
    -moz-background-size: cover;
    background-size: cover;
    -o-background-size: cover
}
.intro .intro-body {
    display: table-cell;
    vertical-align: middle
}
@media (min-width:768px) {
.intro {
    height: 100%;
    padding: 0
}
}    
@media (max-width:480px) {
.intro {
        padding: 10px
}    
}
.app-cam-form {
    border: 1px solid #02c4d9;
    padding: 2px;
    width: 50%;
    margin: 0px auto;
    border-radius: 9px;
    max-width: 500px;
}
.app-cam {
    width: 100%;
    border: 1px solid #026bb1;
    margin: 0px auto;
    background: #f9f9f9;
    /*padding: 20px 50px 15px;*/
    padding: 0;
    border-radius: 7px;
    background: red;
    background: -webkit-linear-gradient(left, #f9f9f9 , #fdfdfd);
    background: -o-linear-gradient(right, #f9f9f9, #fdfdfd);
    background: -moz-linear-gradient(right, #f9f9f9, #fdfdfd);
    background: linear-gradient(to right, #f9f9f9 , #fdfdfd);
    display: inline-block;
}
nav.navbar.navbar-default.navbar-static-top{
    display: none;
}
.app-cam .panel.panel-default{
    margin-bottom: 0;
}
.app-cam .panel > .panel-heading {
    background: #026bb1;
    color: #fff;
    font-size: 18px;
    letter-spacing: 1px;
    font-weight: 600;
    text-transform: uppercase;
}
.login_btn{
    background-color: #026bb1 !important;
    border-color: #026bb1 !important
}
.login-logo {
    margin-bottom: 25px;
}
.login_link{
    text-align: center;
    margin-top: 20px;
}
.login_link > a{
    /*color: #026bb1 !important;
    font-size: 16px;*/
    
    font-weight: 600;
}
</style>