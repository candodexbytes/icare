@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    @section('title', 'Complaint')
     <?php  $type = Auth::user()->type; ?>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

    <div id="page-wrapper" class="complaint" style="min-height: 140px;">    
        <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Complaint</span><a href="{{ url('admin/manage-property') }}" class="btn btn-default  my_btn">Back</a></h1>
            </div>    
            
            <div class="main-div">
                <div class="success_msg" style="color:green;height: 30px;clear: both;"></div>
                <table id="complaint_list" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr class="list_head">
                         <!--    <th>Ticket</th> -->
                            <th>PTD No</th>
                            <th>Block No</th>
                            <th>Unit No</th>
                            <th>Address</th>                                                   
                            <th>Mobile Number</th>                            
                            <th>Description </th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="the_list">
                        
                        @if(isset($record))

                            @foreach ($record as $value)
                            <?php
                                 if ($value->status == 0) {
                                    $status_set = '<span class="label label-primary">Pending</span>';
                                }elseif($value->status == 1){
                                    $status_set = '<span class="label label-info">In progress</span>';
                                }elseif($value->status == 2){
                                    $status_set = '<span class="label label-success">Hold</span>';
                                }else{
                                    $status_set = '<span class="label label-default">Complete</span>';
                                }

                             ?>
                                <tr id="complaint_{{$value->id}}"> 
                                   <!--  <td >{{$value->ticket}}</td>           -->                        
                                    <td >{{$value->unit_ptd}}</td>
                                    <td >{{$value->block_number}}</td>
                                    <td >{{$value->unit_number}}</td>
                                    <td >{{$value->address}}</td>                                    
                                    <td >{{ ($type == 0 || $type == 5) ? $value->mobile_number : str_repeat("x", (strlen($value->mobile_number) - 4)).substr($value->mobile_number,-4,4) }}</td> 
                                    <td class="address_break">{{$value->remark}}</td>
                                    <td >{!! $status_set !!}</td>
                                    <td><span class="hidden">{{$value->create_date}}</span>{{date('d M Y', strtotime($value->create_date))}}</td>
                                    <td>
                                    @if($type == 5)
                                        <span data-id="{{$value->id}}" data-status="{{$value->status}}"  class="edit_btn"><i  class="fa fa-pencil" aria-hidden="true"></i></span> | 
                                        <span data-id="{{$value->id}}" class="delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i></span> | 
                                        <span data-nric="{{$value->nric}}" data-mobilenumber="{{$value->mobile_number}}" data-status="{{$status_set}}" data-ticket="{{$value->ticket}}" data-remark="{{$value->remark}}" data-image="{{$value->image}}" data-date="{{date('d M Y g:i A', strtotime($value->create_date))}}" class="view_btn"><i class="fa fa-eye" aria-hidden="true"></i></span> 
                                        @else 
                                         <span data-nric="{{$value->nric}}" data-mobilenumber="{{$value->mobile_number}}" data-status="{{$status_set}}" data-ticket="{{$value->ticket}}" data-remark="{{$value->remark}}" data-image="{{$value->image}}" data-date="{{date('d M Y g:i A', strtotime($value->create_date))}}" class="view_btn"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                       @endif
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
                  <div class="modal-header middle">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit <span id="title_set">Complaint</span> </h4>
                  </div>
                  <div class="modal-body pad">
                  <form method="post" action="{{action('AdminController@UpdateComplaint')}}" id="update_complaint_form" class="conatct-form form-horizontal  property_form" enctype="multipart/form-data">
                    <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                    <input type="hidden" name="id" id="id" value="">
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="change_status"><strong>Change Status</strong></label><br>
                        <div class="col-sm-8 new_popup">
                            <select class="form-control" name="change_status" id="change_status">
                                <option id="status_0" value="0">Pending</option>
                                <option id="status_1" value="1">In progress</option>
                                <option id="status_2" value="2">Hold</option>
                                <option id="status_3" value="3">Complete</option>
                            </select>
                        </div>
                    </div>
                   
                        <div class="form-group">
                            <div class="col-sm-offset-9 col-sm-2">
                                <input class="btn btn-default my_btn" type="submit" value="Update"> 
                            </div>
                        </div>
                    </form>
                  </div>
                  
                </div>

              </div>
            </div>

             <!--View Modal -->
            <div id="viewmodal" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content new-pad">
                  <div class="modal-header middle">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">View <span id="title_set">Complaint</span> </h4>
                  </div>
                  <div class="modal-body pad">
                    
                    <div class="form-group view-body">
                        <label class="col-sm-5 control-label" for="ticket">Ticket</label>
                        <div class="col-sm-7" id="set_ticket">
                            
                        </div>
                    </div>
                    <div class="form-group view-body">
                        <label class="col-sm-5 control-label" for="set_nric">NRIC</label>
                        <div class="col-sm-7" id="set_nric">
                            
                        </div>
                    </div>
                    <div class="form-group view-body">
                        <label class="col-sm-5 control-label" for="mobile_number">Mobile Number</label>
                        <div class="col-sm-7" id="set_mobile_number">
                            
                        </div>
                    </div>
                    <div class="form-group view-body">
                        <label class="col-sm-5 control-label" for="change_status">Image</label>
                        <div class="col-sm-7" id="set_image">
                            
                        </div>
                    </div>
                    <div class="form-group view-body">
                        <label class="col-sm-5 control-label" for="remark">Description</label>
                        <div class="col-sm-7" id="set_remark">
                            
                        </div>
                    </div>
                    <div class="form-group view-body">
                        <label class="col-sm-5 control-label" for="status">Status</label>
                        <div class="col-sm-7" id="set_status">
                            
                        </div>
                    </div>
                    <div class="form-group view-body">
                        <label class="col-sm-5 control-label" for="create_date">Create Date</label>
                        <div class="col-sm-7" id="set_create_date">
                            
                        </div>
                    </div>
                   
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
                    $('#complaint_list').DataTable( {
                        responsive: true,
                        "order": [[ 5, "desc" ]]
                    } );
                } );
            </script>
            <script type="text/javascript">
                $('.delete_btn').click(function(){
                    var id = $(this).data('id');     
                    var url = '{{url('deletecomplaint')}}/'+id;           
                    var r = confirm("Confirm delete this package!");
                    if (r == true) {
                       $.ajax({
                            type: "GET",
                            url : escap_space(url),
                            success : function(data){
                                if(data.response == 1){

                                    $( '#complaint_'+id ).remove();

                                    $('.success_msg').html('Complaint remove successfully');
                                    setTimeout(function() {
                                        $('.success_msg').fadeOut('slow');
                                    }, 2000);
                                }
                              
                            }

                        });     
                    } else {
                      
                    }
                });
                $('.edit_btn').click(function(){

                    var id = $(this).data('id');

                    var status = $(this).data('status');
                    $('#id').val(id);
                    
                    $('#status_'+status).prop('selected', true);
                    
                    $('#editmodal').modal('show');
                          
                    
                });
                $('.view_btn').click(function(){

                    var remark = $(this).data('remark');

                    var status = $(this).data('status');
                    var nric = $(this).data('nric');
                    var mobilenumber = $(this).data('mobilenumber');
                    var ticket = $(this).data('ticket');
                    var date = $(this).data('date');
                    var images = $(this).data('image').toString().split(',');
                    var image='';
                    for (var i = 0; i < images.length; i++) {
                        image += '<img style="padding:10px;" src="http://app.intentapp.in/images/application/condo/'+images[i]+'" width="100" height="100">';
                   }
                    //alert(ticket);
                    $('#set_nric').html(nric);
                    $('#set_status').html(status);
                    $('#set_remark').html(remark);
                    $('#set_mobile_number').html(mobilenumber);
                    $('#set_ticket').html(ticket);
                    $('#set_create_date').html(date);
                    $('#set_image').html(image);
                    $('#viewmodal').modal('show');                         
                    
                });
               
                
            </script>
        </div>
    </div>
    @endsection
@endguest
