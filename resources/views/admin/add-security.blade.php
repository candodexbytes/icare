@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
@section('title', 'Add Security')
@section('content')
    <style type="text/css">
        .error_msg {
            margin-top: 40px;
        }
    </style>
    <?php  $type = Auth::user()->type; 
    $ptd_id_user = str_replace(' ', '-', Auth::user()->ptd_id);?>
    @if( $type == 5)
        <div id="page-wrapper" style="min-height: 140px;">    
           <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Add Security 
                </span><a href="{{ url('admin/security-link') }}" class="btn btn-default my_btn">Back</a></h1>
            </div>
            <div class="align-window clearfix col-sm-12">                    
                    @if (Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                   @endif
                    @if (Session::has('error'))
                       <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                     <form method="POST" action="{{action('AdminController@saveNewSecurity')}}" id="addsecurity-form" class="form-horizontal conatct-form  " enctype="multipart/form-data">
                        <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                    
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="securityname">Secury Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="security_name" id="security_name" value=""  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="username">Username</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="user_name" id="user_name" value=""  />
                            </div>
                        </div>
                       
                       <div class="form-group">
                            <label class="col-sm-2 control-label" for="password">Password</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password"  name="password" id="password"  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="confirm_password">Confirm Password</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password"  name="confirm_password" id="confirm_password"  />
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-default my_btn">  
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif    
    @endsection
@endguest
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    function escap_space(string) {
        return string.replace(/\s/g, '');
    }

  





    
</script>