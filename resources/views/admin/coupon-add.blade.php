@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
@section('title', 'Add E-Flyer & E-Coupon')
    <?php  $type = Auth::user()->type; ?>
    @if($type == 0)
        <div id="page-wrapper" class="coupan-add" style="min-height: 140px;">    
           <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Add New Coupon</span><a href="{{ url('admin/e-flyer-coupon') }}" class="btn btn-default my_btn">Back</a></h1>
            </div>
                <div class=" col-sm-12 col-md-12 col-lg-12 no-pad">
                    <h3></h3>
                    @if (Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                    @endif
                    <div  class="add_new_property">
                        <form method="POST" class="conatct-form form-horizontal" action="{{action('AdminController@UpdateCoupon')}}" id="emergency-form" class="conatct-form  " enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="">                         
                            <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">							
							<div class="form-group">
                                <label class="col-sm-2 control-label" for="title"><strong>Title</strong></label>
                                <div class="col-sm-10">
                                    <input class="form-control"  name="title" id="title" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="subject"><strong>Subject</strong></label>
                                <div class="col-sm-10">
                                    <input class="form-control"  name="subject" id="subject" >
                                </div>
							</div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="name"><strong>Description</strong></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control"  name="description" id="description" ></textarea>
                                </div>
                            </div>                            
							<div class="form-group">
                                <label class="col-sm-2 control-label" for="type"><strong>Type</strong></label>
                                <div class="col-sm-10">
                             <select class="form-control"   name="type" id="type"  >
							 <option value="" >Please select type</option>
								<?php 
							 if(isset($coupon_type) && !empty($coupon_type)){
								 foreach($coupon_type as $key=>$row){
									 ?>
								<option value="<?php  echo $key;?>" ><?php echo $row;?></option> 
									 <?php 
								
								 }
							 }
								?>
							 </select>
                                </div>
								</div>	
							
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="set_image"><strong>Image</strong></label>
                                        <div class="col-sm-10">
                                            <img src="" class="img_hide" id="set_image" width="100" height="100">
                                            <input class="form-control" onchange="readURL(this);" id="image_file" name="image_file" type="file">
                                        </div>
                            </div>
                            <div class="form-group">
                              
                              <div class="col-sm-offset-2 col-sm-10">
                                 <input type="submit" class="btn btn-default my_btn" value="Save">
                              </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function readURL(input) {
                    $('#set_image').show();
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#set_image')
                                .attr('src', e.target.result)
                                .width(150)
                                .height(200);
                        };

                        reader.readAsDataURL(input.files[0]);

                    }
                }
        </script>
    @endif
    @endsection
@endguest
