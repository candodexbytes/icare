@extends('admin-layouts.app')
@guest
@include('admin-layouts.error')                         
@else
@section('content')
@section('title', 'Handyman Contact')
<?php $type = Auth::user()->type; ?>
@if($type == 0)
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

<div id="page-wrapper" style="min-height: 140px;">    
    <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">    

        <div class="col-lg-12 no-pad">
            <h1 class="heading_text text-right"><span class="pull-left">Handyman Contact</span><a href="{{ url('admin/add-handyman-contact') }}" class="btn btn-default back_btn my_btn"><i class="fa fa-plus"></i></a></h1>
        </div>
        <!-- /.col-lg-12 -->

        <div class="main-div">
            <div class="success_msg" style="height: 30px;clear: both;"></div>
            <table id="contact_list" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr class="list_head">                    
                        <th>Image</th>
                        <th>Name</th>
                        <th>Mobile Number</th>
                        <th>Type</th>
                        <th>Views</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="the_list">
                    @if(isset($get_record))
                    @foreach ($get_record as $value)
                    <tr id="contact_{{$value->id}}">
                         <td ><img src="{{$value->image}}" style="max-width: none;" width="40" height="40"></td>
                        <td>{{$value->name}}</td>
                        <td>{{$value->cell_number}}</td>
                        <td>{{ $coupon_type[$value->type] }}</td>
                        <td>{{ $value->count }}</td>
                        <td>
                            <span data-name="{{$value->name}}" data-type="{{$value->type}}"  data-ptdid="{{$value->ptd_id}}" data-id="{{$value->id}}" data-cellnumber="{{$value->cell_number}}" data-description="{{$value->description}}" data-image="{{$value->image}}"  class="edit_btn"><i  class="fa fa-pencil" aria-hidden="true"></i></span> | 
                            <span data-id="{{$value->id}}" class="delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i></span> |
                            <span data-id="{{$value->id}}" data-type="{{ $coupon_type[$value->type] }}" data-name="{{$value->name}}" data-mobilenumber="{{$value->cell_number}}" data-description="{{$value->description}}" data-image="{{$value->image}}"  class="detail_btn" ><i class="fa fa-eye"></i></span>
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
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit <span id="title_set">Contact</span> </h4>
                    </div>
                    <form method="post" action="{{action('AdminController@UpdateHandymanContact')}}"  class="conatct-form form-horizontal" id="update_contact_form" enctype="multipart/form-data">
                    <div class="modal-body">                    
                            <input type="hidden" name="_token" id="token" value="<?= csrf_token(); ?>">
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="ptd_id" id="ptd_id" value="">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="name">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"  name="name" id="name" value=""/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Cell Number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="cell_number" id="cell_number" value="">
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
                                <label class="col-sm-2 control-label" for="set_image">Image</label>
                                <div class="col-sm-10">
                                    <img src=""  id="set_image" width="100" height="100">
                                    <input class="form-control" onchange="readURL(this);" id="image_file" name="image_file" type="file">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="name">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control"  name="description" id="description" ></textarea>
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
        <div class="modal fade" id="handyContactDetail" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Resident User Details</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="col-sm-4 col-xs-6 payment_text">
                            <p>Name
                            </p></div>
                        <div class="col-sm-8 col-xs-6 payment_text"><b>
                                <p id="name_txt"></p>
                            </b></div>


                        <div class="col-sm-4 col-xs-6 payment_text">
                            <p>Mobile Number
                            </p></div>
                        <div class="col-sm-8 col-xs-6 payment_text"><b>
                                <p id="mobile_txt"></p>
                            </b></div>

                        <div class="col-sm-4 col-xs-6 payment_text">
                            <p>Description
                            </p></div>
                        <div class="col-sm-8 col-xs-6 payment_text"><b>
                                <p id="description_txt"></p>
                            </b></div>

                        <div class="col-sm-4 col-xs-6 payment_text">
                            <p>Type</p>
                        </div>
                        <div class="col-sm-8 col-xs-6 payment_text">
                            <b>
                                <p id="type_txt"></p>
                            </b>
                        </div>
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
        $(document).ready(function () {
            $('#contact_list').DataTable({

            });
        });
        </script>
        <script type="text/javascript">
            function escap_space(string){
                return string.replace(/\s/g,'');
            }
            $('.delete_btn').click(function () {
                var id = $(this).data('id');
                var url = '{{url('admin / deleteHandymancontact')}}/' + id;
                var r = confirm("Confirm delete this package!");
                if (r == true) {
                    $.ajax({
                        type: "GET",
                        url: escap_space(url),
                        success: function (data) {
                            if (data.response == 1) {

                                $('#contact_' + id).remove();

                                $('.success_msg').html('contact remove successfully');
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

                var name = $(this).data('name');
                var cell_number = $(this).data('cellnumber');
                var description = $(this).data('description');
                var ptd_id = $(this).data('ptdid');
                var image = $(this).data('image');
                var type = $(this).data('type');

                $('#id').val(id);
                $('#type').val(type);
                $('#name').val(name);
                $('#cell_number').val(cell_number);
                $('#description').val(description);
                $('#ptd_id').val(ptd_id);
                $('#set_image').attr('src', image);
                $('#editmodal').modal('show');


            });
            $('.detail_btn').click(function () {
                var name = $(this).data('name');
                var image = $(this).data('image');
                var mobilenumber = $(this).data('mobilenumber');
                var description = $(this).data('description');
                var type = $(this).data('type');
                $('#name_txt').text(name);
                $('#mobile_txt').text(mobilenumber);
                $('#type_txt').text(type);
                if(description.trim().length == 0){ 
                    description='&nbsp;';
                  }
              
                $('#description_txt').html(description);
                $('#detail_img').attr('src', image).width(100).height(100);
                // $('#status_txt').text(status);
                $('#handyContactDetail').modal('show');
            });

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
    </div>
</div>
@endif
@endsection
@endguest