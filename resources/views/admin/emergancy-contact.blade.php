@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    @section('title', 'Emergancy Contact')
    <?php  $type = Auth::user()->type; ?>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

    <div id="page-wrapper" class="emergancy" style="min-height: 140px;">    
        <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">    
        
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Emergancy Contact</span>
                      @if($type==5)
                    <a href="{{ url('admin/add-contact') }}" class="btn btn-default back_btn my_btn"><i class="fa fa-plus"></i></a> 
                    @else
                    <a href="{{ url('admin/manage-property') }}" class="btn btn-default back_btn my_btn">Back</a> 
                    @endif
                    
                </h1>
            </div>
            <!-- /.col-lg-12 -->
          <div class="clearfix">
         @if(Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                    @endif
            <div class="main-div">
                <div class="success_msg" style="color:green;height: 30px;clear: both;"></div>
                <table id="contact_list" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr class="list_head">
                           
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Mobile Number</th>
                            <th>Status</th>
                            @if($type == 5 || $type == 6)<th>Action</th>@endif
                        </tr>
                    </thead>
                    <tbody id="the_list">
                        @if(isset($get_record))
                            @foreach ($get_record as $value)
                                <tr id="contact_{{$value->id}}">
                                 
                                    <td ><img src="{{$value->icon}}" style="max-width: none;" width="40" height="40" ></td>
                                    <td >{{$value->name}}</td>
                                    <td >{{$value->cell_number}}</td>
                                    <td >@if($value->status == 0)
                                           <span class="label label-default inactive">Inactive</span>  
                                        @else
                                           <span class="label label-success active">Active</span>
                                        @endif

                                        </td>
                                    @if($type == 5 || $type == 6) 
                                        <td> 
                                           @if($type == 5 || $type == $value->save_type)
                                                  <span data-name="{{$value->name}}" data-icon="{{$value->icon}}" data-ptdid="{{$value->ptd_id}}" data-id="{{$value->id}}" data-cellnumber="{{$value->cell_number}}"  class="edit_btn"><i  class="fa fa-pencil" aria-hidden="true"></i></span> / 
                                                   <span data-id="{{$value->id}}" class="delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
                                                @if($type == 5)  / @if($value->status == 0) 
                                                   <span data-id="{{$value->id}}" data-status="1" class="change_contact_status"><i class="fa fa-toggle-off active_toggle" aria-hidden="true"></i></span> 
                                                @else 
                                                    <span data-id="{{$value->id}}" data-status="0" class="change_contact_status"> <i class="fa fa-toggle-on active_toggle" aria-hidden="true"></i></span>
                                                 @endif                                                 
                                                 @endif
                                             @else 
                                                --
                                             @endif 
                                         </td> 
                                     @endif
                                </tr>
                            @endforeach
                        @else    
                            <tr><td colspan='2'>No records found</td></tr>
                        @endif
                    </tbody>
                </table>    
            </div>
             </div>
            <!-- Modal -->
            <div id="editmodal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit <span id="title_set">Contact</span> </h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{action('AdminController@UpdateEmergencyContact')}}" id="update_contact_form" class="conatct-form form-horizontal  property_form" enctype="multipart/form-data">
                                <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                                <input type="hidden" name="id" id="id" value="">
                                <input type="hidden" name="ptd_id" id="ptd_id" value="">
                                <div class="form-group">
                                        <label class="col-sm-3 control-label" for="name"><strong>Name</strong> </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"  name="name" id="name" value=""/>
                                        </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-sm-3 control-label"><strong>Cell Number</strong> </label>
                                  <div class="col-sm-9">
                                    <input type="text" class="form-control" name="cell_number" id="cell_number" value="">
                                   </div> 
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-sm-3 control-label"> <strong>Icon</strong> </label>
                                  <div class="col-sm-9">
                                    <img src="" id="set_image" width="100" height="100">
                                    <input class="form-control" onchange="readURL(this);" id="image_file" name="image_file" type="file">
                                  </div>  
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <input type="submit" class="btn btn-default my_btn" value="Update">
                                    </div>
                                </div>
                            </form>
                        </div>  
                    </div>
                </div>
            </div>
            <script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}">
            </script>
            <script type="text/javascript" src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
            <script type="text/javascript">
                   function escap_space(string){
                return string.replace(/\s/g,'');
            }
            
                $(document).ready(function() {
                    $('#contact_list').DataTable( {
                        
                    } );
                } );
            </script>
            <script type="text/javascript">
                $('.delete_btn').click(function(){
                    var id = $(this).data('id');
                    var url = '{{url('admin/deletecontact')}}/'+id;
                    
                    var r = confirm("Confirm delete this package!");
                    if (r == true) {
                       $.ajax({
                            type: "GET",
                            url : escap_space(url),
                            success : function(data){
                                if(data.response == 1){

                                    $( '#contact_'+id ).remove();

                                    $('.success_msg').html('contact remove successfully');
                                    setTimeout(function() {
                                        $('.success_msg').fadeOut('slow');
                                    }, 2000);
                                }
                              
                            }

                        });     
                    } else {
                      
                    }
                });
                $('.change_contact_status').click(function(){
                    var id = $(this).data('id');
                    var status = $(this).data('status');
                    var url = '{{url('admin/change-contact-status')}}/'+id+'/'+status;
                    if(status == 0){
                        var set_status = 'inactive';
                    }else{
                        var set_status = 'active';
                    }
                    
                    var r = confirm('Confirm '+set_status+' this package!');
                    if (r == true) {
                       $.ajax({
                            type: "GET",
                            url : url,
                            success : function(data){
                                if(data.response == 1){

                                    location.reload(true);
                                }
                              
                            }

                        });     
                    } else {
                      
                    }
                });
                $('.edit_btn').click(function(){
                    var id = $(this).data('id');
                    var icon = $(this).data('icon');
                    var name = $(this).data('name');
                    var cell_number = $(this).data('cellnumber');
                    
                    var ptd_id = $(this).data('ptdid');
                   
                    
                    $('#id').val(id);
                    
                    
                    $('#name').val(name);
                    $('#cell_number').val(cell_number);
                    
                    $('#ptd_id').val(ptd_id);
                    
                    $('#set_image').attr('src',icon);
                    $('#editmodal').modal('show');
                          
                    
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
    @endsection
@endguest
