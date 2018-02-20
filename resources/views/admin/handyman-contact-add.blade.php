@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
        @section('title', 'Handyman Contact')
    <?php  $type = Auth::user()->type; ?>
    @if($type == 0)
        <div id="page-wrapper" class="handyman-contact-add" style="min-height: 140px;">    
           <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                 <h2 class="heading_text text-right"><span class="pull-left">Add Handyman Contact</span><a href="{{ url('admin/handyman') }}" class="btn btn-default my_btn">Back</a></h2>
            </div>
                <div class="col-sm-12 col-md-12  col-lg-12 no-pad">
                    
                    @if (Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                    @endif
                  <div  class="add_new_property">
                     <form method="POST" class="conatct-form form-horizontal" action="{{action('AdminController@UpdateHandymanContact')}}" id="emergency-form" enctype="multipart/form-data">
                          <input type="hidden" name="id" id="id" value="">
                        
                          <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">

                          <div class="form-group">
                              <label class="col-sm-2 control-label" for="name"><strong>Name</strong></label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="text"  name="name" id="name" value=""  />
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 control-label" for="cell_number"><strong>Mobile Number</strong></label>
                              <div class="col-sm-10">
                                  <input class="form-control" type="text"  name="cell_number" id="cell_number" value="" />
                              </div>
                          </div>
                          <!-- <div class="form-group">
                            <label class="col-sm-2 control-label" for="cell_number">Mobile Number</label>
                            <div class="col-sm-9">
                                <select class="form-control country_code" name="country_code" id="country_code">
                                    <option value="60">MY</option>
                                    <option value="65">SG</option>
                                    <option value="91">IN</option>
                                </select>  
                                <input class="form-control country_phone_code" type="text"  name="country_phone_code" id="country_phone_code" disabled="true"  />
                                <input class="form-control cell_number" type="text"  name="cell_number" id="cell_number"  />
                            </div>
                          </div> -->
						              <div class="form-group">
                              <label class="col-sm-2 control-label" for="set_image"><strong>Image</strong></label>
                              <div class="col-sm-10">
                                  <img src="" class="img_hide" id="set_image" width="100" height="100">
                                  <input class="form-control" onchange="readURL(this);" id="image_file" name="image_file" type="file">
                              </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-2 control-label" for="type"><strong>Type</strong></label>
                            <div class="col-sm-10">
                              <select class="form-control"   name="type" id="type"  >
                                 <option value="" >Please select type</option>
                                  <?php 
                                 if(isset($coupon_type) && !empty($coupon_type)){
                                   foreach($coupon_type as $key  =>  $row){
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
                            <label class="col-sm-2 control-label" for="name"><strong>Description</strong></label>
                            <div class="col-sm-10">
                                <textarea class="form-control"  name="description" id="description" ></textarea>
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


            // $(document).ready(function() {

            //   $("#country_phone_code").val('60');

            //   $('#country_code').on('change', function() {
            //       var code = $('#country_code').val();
            //       $("#country_phone_code").val(code);
                
            //   });
            // });
        </script>
    @endif   
    @endsection
@endguest
