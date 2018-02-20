@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <?php  $type = Auth::user()->type;$ptd_id_user = Auth::user()->ptd_id;  ?>
    @if($type == 5)
        <div id="page-wrapper" style="min-height: 140px;">    
           <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Add Resident User</span><a href="{{ url('resident-user') }}" class="btn btn-default my_btn">Back</a></h1>
            </div>
                <div class="align-window clearfix col-sm-12">
                   
                    @if (Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                       <script type="text/javascript">
                            $(document).ready(function () { 
                            //    $(".alert.alert-info").slideUp( 300 ).delay( 800 ).fadeIn( 8000 );
                               //  window.location.href = "{{ url('resident-user') }}/{{$ptd_id_user}}";
                            });
                       </script>
                    @endif
                    @if (Session::has('error'))
                       <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                   <form method="POST" action="{{action('AdminController@saveNewUser')}}" id="adduser-form" class="form-horizontal conatct-form  " enctype="multipart/form-data">                        
                        <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="name" id="name" value=""  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="nric">NRIC</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="nric" id="nric" value=""  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="email">Email</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="email" id="email" value=""  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="cell_number">Mobile Number</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="cell_number" id="cell_number"  />
                            </div>
                        </div>
                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="cell_number">House/Flat Number</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="house_number" id="house_number"  />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-2 control-label" for="cell_number">Block Number</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="block_number" id="block_number"  />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-2 control-label" for="cell_number">Address</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="address" id="address"  />
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
                        <input type="hidden"  name="account_type" id="account_type" value="1"> 
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