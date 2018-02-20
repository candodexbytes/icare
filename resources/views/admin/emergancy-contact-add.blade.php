@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
        @section('title', 'Emergancy Contact')
    <?php  $type = Auth::user()->type; ?>
    @if($type = 5 || $type = 6)
        <div id="page-wrapper" class="emergancy_contact_add" style="min-height: 140px;">    
           <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h2 class="heading_text text-right"><span class="pull-left">Add Emergency Contact</span><a href="{{ url('admin/emergancy-contact') }}" class="btn btn-default my_btn">Back</a></h2>
            </div>

               <div class="align-window clearfix col-sm-12">
                    <div class="add_unit">
                    @if (Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                    @endif
                   <form method="POST" action="{{action('AdminController@UpdateEmergencyContact')}}" id="emergency-form" class="conatct-form form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="">
                     
                        <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="name"><strong>Name</strong></label>

                            <div class="col-sm-6">
                                <input class="form-control" type="text"  name="name" id="name" value=""  />
                            </div>    
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="cell_number"><strong>Mobile Number</strong></label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text"  name="cell_number" id="cell_number" value="" />
                            </div> 
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="neighbours_contact"><strong>Icon</strong></label>
                                
                                <div class="col-sm-6">
                                    <img src="" id="set_image" class="img_hide" width="100" height="100">
                                    <input class="form-control" onchange="readURL(this);" id="image_file" name="image_file" type="file">
                                </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-8 col-sm-4">
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
