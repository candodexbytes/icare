@extends('admin-layouts.app')
@guest
@include('admin-layouts.error')                         
@else
@section('content')
@section('title', 'E-Flyer & E-Coupon')
<?php $type = Auth::user()->type; ?>
@if($type == 0)
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

<div id="page-wrapper" style="min-height: 140px;">    
    <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">    
        <?php $uri_segment = Request::segment(3) ?>
        <div class="col-lg-12 no-pad">
        
            <h1 class="heading_text text-right"><span class="pull-left">E-Flyer & E-Coupon</span><a href="{{ url('admin/add-coupon') }}" class="btn btn-default back_btn my_btn"><i class="fa fa-plus"></i></a></h1>
        </div>
        <!-- /.col-lg-12 -->

        <div class="main-div">
            <div class="success_msg" style="height: 30px;clear: both;"></div>
            <table id="coupon_list" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr class="list_head">                     
                        <th>Image</th>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Type</th>
                        <th>Views</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="the_list">
                    @if(isset($get_record))
                    @foreach ($get_record as $value)
                    <tr id="coupon_{{$value->id}}">
                     
                        <td ><img src="{{$value->image}}" style="max-width: none;" width="40" height="40" ></td>
                        <td >{!!$value->title!!}</td>
                        <td >{{ $value->subject }}</td>
                        <td >{{ $coupon_type[$value->type] }}</td>
                        <td >{{ $value->count }}</td></td>
                        <td>
                            <span data-title="{{$value->title}}" data-type="{{$value->type}}" data-description="{{$value->description}}" data-image="{{$value->image}}" data-ptdid="{{$value->ptd_id}}" data-id="{{$value->id}}"  data-subject="{{$value->subject}}" class="edit_btn"><i  class="fa fa-pencil" aria-hidden="true"></i></span> | 
                            <span data-id="{{$value->id}}" class="delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i></span> | 
                            <span data-id="{{$value->id}}" data-title="{{$value->title}}" data-subject="{{$value->subject}}" data-description="{{$value->description}}" data-type="{{$coupon_type[$value->type]}}" data-image="{{$value->image}}"  class="detail_btn" ><i class="fa fa-eye"></i></span>
                        </td>
                    </tr>
                    @endforeach
                    @else    
                    <tr><td colspan='2'>No records found</td></tr>
                    @endif
                </tbody>
            </table>    
        </div>
        <!-- Modal -->
        <div id="editmodal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit <span id="title_set">Coupon</span> </h4>
                    </div>

                     <form method="post" class="conatct-form form-horizontal" action="{{action('AdminController@UpdateCoupon')}}" id="update_coupon_form" enctype="multipart/form-data">
                    <div class="modal-body">                       
                            <input type="hidden" name="_token" id="token" value="<?= csrf_token(); ?>">
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="ptd_id" id="ptd_id" value="">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="title">Title</label>
                                <div class="col-sm-10">
                                    <input class="form-control"  name="title" id="title" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="subject">Subject</label>
                                <div class="col-sm-10">
                                    <input class="form-control"  name="subject" id="subject" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="name">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="description" id="description" ></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="type">Type</label>
                                <div class="col-sm-10">
                                    <select class="form-control"   name="type" id="type"  >
                                        <option value="" >Please select type</option>
                                        <?php
                                        if (isset($coupon_type) && !empty($coupon_type)) {
                                            foreach ($coupon_type as $key => $row) {
                                                ?>
                                                <option value="<?php echo $key; ?>" ><?php echo $row; ?></option> 
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>	
                           <div class="form-group">
                                <label class="col-sm-2 control-label">Image</label>
                                <div class="col-sm-10">
                                    <img src="" id="set_image" width="100" height="100">
                                    <input class="form-control" class="form-control" onchange="readURL(this);" id="image_file" name="image_file" type="file">
                                </div>
                            </div>
                     </div>  
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-default my_btn" value="Update">
                    </div>
                </form>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="couponDetail" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">E-Coupon Details</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="col-sm-4 col-xs-6 payment_text">
                            <p>Title
                            </p></div>
                        <div class="col-sm-8 col-xs-6 payment_text"><b>
                                <p id="title_txt"></p>
                            </b></div>


                        <div class="col-sm-4 col-xs-6 payment_text">
                            <p>Subject
                            </p></div>
                        <div class="col-sm-8 col-xs-6 payment_text"><b>
                                <p id="subject_txt"></p>
                            </b></div>

                        <div class="col-sm-4 col-xs-6 payment_text">
                            <p>Description
                            </p></div>
                        <div class="col-sm-8 col-xs-6 payment_text"><b>
                                <p id="description_txt"></p>
                            </b></div>
                        <div class="col-sm-4 col-xs-6 payment_text">
                            <p>Type
                            </p></div>
                        <div class="col-sm-8 col-xs-6 payment_text"><b>
                                <p id="type_txt"></p>
                            </b></div>
                        <div class="col-sm-4 col-xs-6 payment_text">
                            <p>Image
                            </p></div>
                        <div class="col-sm-8 col-xs-6 payment_text"><b>
                                <p ><img src=""  id="detail_img" /></p>
                            </b></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}">
        </script>
        <script type="text/javascript" src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
        <script type="text/javascript">
                                        function escap_space(string) {
                                            return string.replace(/\s/g, '');
                                        }
                                        $(document).ready(function () {
                                            $('#coupon_list').DataTable({

                                            });
                                        });
        </script>
        <script type="text/javascript">
            $('.delete_btn').click(function () {
                var id = $(this).data('id');
                var url = '{{url('admin / deletecoupon')}}/' + id;

                var r = confirm("Confirm delete this package!");
                if (r == true) {
                    $.ajax({
                        type: "GET",
                        url: escap_space(url),
                        success: function (data) {
                            if (data.response == 1) {

                                $('#coupon_' + id).remove();

                                $('.success_msg').html('Coupon remove successfully');
                                setTimeout(function () {
                                    $('.success_msg').fadeOut('slow');
                                }, 2000);
                            }

                        }

                    });
                } else {

                }
            });
            $('.edit_btn').click(function () {
                var id = $(this).data('id');
                var image = $(this).data('image');
                var subject = $(this).data('subject');
                var description = $(this).data('description');
                var title = $(this).data('title');
                var type = $(this).data('type');

                var ptd_id = $(this).data('ptdid');


                $('#id').val(id);

                $('#title').val(title);
                $('#subject').val(subject);
                $('#description').val(description);
                $('#type').val(type);

                $('#ptd_id').val(ptd_id);

                $('#set_image').attr('src', image);
                $('#editmodal').modal('show');


            });

            $('.detail_btn').click(function () {
                //alert('<?php echo $coupon_type[2]; ?>');
                var title = $(this).data('title');
                var subject = $(this).data('subject');
                var description = $(this).data('description');
                var type = $(this).data('type');
                var image = $(this).data('image');

                $('#title_txt').text(title);
                $('#subject_txt').text(subject);
                $('#type_txt').text(type);
              //  alert(description.length)
                if (description.trim().length == 0) {
                    description = '&nbsp;';
                }
                $('#description_txt').html(description);
                $('#detail_img').attr('src', image).width(100).height(100);
                $('#couponDetail').modal('show');
            });

            function readURL(input) {

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
    </div>
</div>
@endif
@endsection
@endguest