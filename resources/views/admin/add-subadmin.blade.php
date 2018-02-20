@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <?php  $type = Auth::user()->type; ?>
    @if($type == 0)
        <div id="page-wrapper" style="min-height: 140px;">    
           <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Add RC/MC</span><a href="{{ url('rcmc-admin') }}" class="btn btn-default my_btn">Back</a></h1>
            </div>
                <div class="align-window clearfix col-sm-12">
                   
                    @if (Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::has('error'))
                       <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                   <form method="POST" action="{{action('AdminController@addNewSubAdmin')}}" id="subadmin-form" class="form-horizontal conatct-form  " enctype="multipart/form-data">
                        
                        <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                        <input type="hidden" name="ptd_id" id="ptd_id" value="">
                        <input type="hidden" name="taman-condo-id" id="taman-condo-id" value="">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="name" id="name" value=""  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="email">Email</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="email" id="email" value=""  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="cell_number">Cell Number</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="cell_number" id="cell_number"  />
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
                            <label class="col-sm-2 control-label" for="account_type">Account Type</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="account_type" id="account_type">
                                    <option value="5">Management Company</option>
                                    <option value="6">Resident Committee (MC)</option>
                                </select>
                                
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