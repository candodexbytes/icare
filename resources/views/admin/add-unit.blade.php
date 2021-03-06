@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <?php  $type = Auth::user()->type; ?>
    @if( $type == 5)
        <div id="page-wrapper" class="add-unit1" style="min-height: 140px;">    
           <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Add New Unit</span><a href="{{ url('admin/unit') }}" class="btn btn-default my_btn">Back</a></h1>
            </div>
                <div class="align-window clearfix col-sm-12">
                  <div class="add_unit">
                    
                    @if (Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                       <script type="text/javascript">
                            $(document).ready(function () { 
                           ///     $(".alert.alert-info").slideUp( 300 ).delay( 800 ).fadeIn( 8000 );
                              //  window.location.href = "{{ url('all-user') }}/{{$ptd_id_user}}";
                            });
                       </script>
                    @endif
                    @if (Session::has('error'))
                       <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                    <form method="POST" action="{{action('AdminController@saveNewUnit')}}" id="addunit-form" class="form-horizontal conatct-form  " enctype="multipart/form-data">
                        
                        <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>"> 

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="cell_number">PTD Number </label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text"  name="unit_ptd" id="unit_ptd"  />
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="cell_number">Block </label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text"  name="block_number" id="block_number"  />
                            </div>
                        </div>                     

                         <div class="form-group">
                            <label class="col-sm-4 control-label" for="cell_number">Unit Number</label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text"  name="house_number" id="house_number"  />
                            </div>
                        </div>
                         
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="cell_number">Address</label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text"  name="address" id="address"  />
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <div class="col-sm-offset-8 col-sm-4">
                                <input type="submit" value="Save" class="btn btn-default my_btn">  
                            </div> 
                        </div>
                    </form>
                </div>
                </div>

            </div>
        </div>
    @endif    
    @endsection
@endguest
