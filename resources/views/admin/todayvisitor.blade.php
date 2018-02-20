@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

    <div id="page-wrapper" style="min-height: 140px;">    
        <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Today Visitor</span><a href="{{ url('admin/visitor') }}" class="btn btn-default my_btn">Back</a></h1>
            </div>    
            
            
            <div class="main-div">
                <div class="success_msg" style="height: 30px;clear: both;"></div>
                <table id="visitor_list" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr class="list_head">
                            
                            
                            <th>Visitor Code</th>
                            <th>Name</th>
                            <th>Visitor NRIC</th>
                            <th>Cell Number</th>
                            <th>My Card</th>
                            <th>Car Model</th>
                            <th>Car Number</th>
                            <th>Total Visitor</th>
                            <th>Status</th>
                            <th>Visiting Date</th>
                            
                        </tr>
                    </thead>
                    <tbody id="the_list">
                        @if(isset($record))

                            @foreach ($record as $value)
                            <?php
                                if ($value->invitation_status == 0) {
                                    $status_set = 'Pending';
                                }elseif($value->invitation_status == 1){
                                    $status_set = 'Accept';
                                }elseif($value->invitation_status == 2){
                                    $status_set = 'Completed';
                                }else{
                                    $status_set = 'Reject';
                                }

                             ?>


                                <tr id="visitor_{{$value->id}}">
                                   
                                    
                                    <td >{{$value->visitor_code}}</td>
                                    <td >{{$value->name}}</td>

                                    <td >{{$value->visitor_nric}}</td>
                                    <td >{{$value->cell_number}}</td>
                                    <td >{{$value->mycard_image}}</td>

                                    <td >{{$value->car_model}}</td>
                                    <td >{{$value->car_number}}</td>
                                    <td >{{$value->total_visitor}}</td>

                                    <td >{{$status_set}}</td>
                                    <td >{{$value->visiting_date}}</td>
<!--                                     <td ><span onClick="editFunction({{$value->id}},{{$value->invitation_status}});"  class="edit_btn"><i  class="fa fa-pencil" aria-hidden="true"></i></span> / <span onClick = "deleteFunction({{$value->id}});" class="delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i></span></td>
 -->                                </tr>
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
                    <h4 class="modal-title">Edit <span id="title_set">visitor</span> </h4>
                  </div>
                  <div class="modal-body">
                  <form method="post" action="{{action('AdminController@Updatevisitor')}}" id="update_visitor_form" class="conatct-form form-horizontal  property_form" enctype="multipart/form-data">
                    <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                    <input type="hidden" name="id" id="id" value="">
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="change_status">Change Status</label><br>
                        <div class="col-sm-10">
                            <select class="form-control" name="change_status" id="change_status">
                                <option id="status_0" value="0">Pending</option>
                                <option id="status_1" value="1">Accept</option>
                                <option id="status_2" value="2">Completed</option>
                                <option id="status_3" value="3">Reject</option>
                            </select>
                        </div>
                    </div>
                   
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input class="btn btn-default my_btn" type="submit" value="Update"> 
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
                $(document).ready(function() {
                    $('#visitor_list').DataTable( {
                        responsive: true
                    } );
                } );
            </script>
            <script type="text/javascript">
            function editFunction (id,status) {
                    var id = id;

                    var status = status;
                    $('#id').val(id);
                    
                    $('#status_'+status).prop('selected', true);
                    
                    $('#editmodal').modal('show');
            }
            function deleteFunction (id) {
                    var id = id;     
                    var url = '{{url('deletevisitor')}}/'+id;           
                    var r = confirm("Confirm delete this package!");
                    if (r == true) {
                       $.ajax({
                            type: "GET",
                            url : url,
                            success : function(data){
                                if(data.response == 1){

                                    $( '#visitor_'+id ).remove();

                                    $('.success_msg').html('Property remove successfully');
                                    setTimeout(function() {
                                        $('.success_msg').fadeOut('slow');
                                    }, 2000);
                                }
                              
                            }

                        });     
                    } else {
                      
                    }
            }
            
            </script>
        </div>
    </div>
    @endsection
@endguest