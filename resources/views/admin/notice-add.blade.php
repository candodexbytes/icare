@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
@section('content')
@section('title', 'Notice')
<?php  $type = Auth::user()->type; ?>

 
    @if($type == 5)
        <div id="page-wrapper" style="min-height: 140px;">    
           <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Add Notice</span><a href="{{ url('admin/ann-notice-board') }}" class="btn btn-default my_btn">Back</a></h1>
            </div>
                <div class="align-window clearfix col-sm-12">
                   
                    @if (Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                    @endif
                   <form method="POST" action="{{action('AdminController@saveNotice')}}" id="add-notice-form" class="form-horizontal conatct-form  " enctype="multipart/form-data">
                        
                       
                        <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name"><strong>Subject</strong></label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="subject" id="subject" value=""  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="cell_number"><strong>Description</strong></label>
                            <div class="col-sm-9">
                                <textarea class="form-control"   name="description" id="description" ></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="neighbours_contact"><strong>Image </strong></label>     
                             <div class="col-sm-9">
                                    <img src="" id="set_image" class="img_hide" width="100" height="100">
                                    <input class="form-control" onchange="readURL(this);" id="image_file" name="image_file" type="file">
                             </div>
                        </div>                       

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="datepicker"><strong>End Date</strong></label>
                            <div class="col-sm-9">
                                <input class="form-control form_datetime" type="text" size="16" value="" readonly  name="end_date" id="datepicker"  />
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

         <script type="text/javascript">
        $( function() {
               $(".form_datetime").datepicker({format: 'mm-dd-yyyy',
                                                autoclose: true,
                                                todayBtn: true,
                                                startDate: '+1d'
                                             });
          } );
     </script>

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