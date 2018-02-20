@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('title','Visitors')
    @section('content')
     <?php  $type = Auth::user()->type; ?>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

    <div id="page-wrapper" style="min-height: 140px;">    
        <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Visitors Passes</span> <a href="{{ url('admin/manage-property') }}" class="btn btn-default my_btn">Back</a></h1>
            </div>    
           
            <div class="main-div">
                <div class="success_msg" style="height: 30px;clear: both;"></div>
                <table id="visitor_list" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr class="list_head">
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>NRIC</th>
                            <th>Total Visitor</th>
                            <th>Car Number</th>
                            <th>Resident</th>                            
                            <th>Visiting Date</th>
                            <th>Status</th>
                            <th>Code</th>
                            <th>Unit Address</th>
                            <th>Unit No</th>
                            
                        </tr>
                    </thead>
                    <tbody id="the_list">
                        @if(isset($record))

                            @foreach ($record as $value)
                            <?php
                                if ($value->invite_status == 0) {
                                     $status_set = '<span class="label label-primary">Pending</span>';
                                }elseif($value->invite_status == 1){
                                     $status_set = '<span class="label label-info">Accept</span>';
                                }elseif($value->invite_status == 2){
                                    $status_set = '<span class="label label-default">Reject</span>';
                                }elseif($value->invite_status == 3){
                                    $status_set = '<span class="label label-warning">Check In</span>';
                                }else{
                                    $status_set = '<span class="label label-success">Check Out</span>'; 
                                }
                             ?>
                                    <tr>
                                    <td >{{$value->name}}</td>
                                    <td >{{ $type == 0 ? $value->cell_number : str_repeat("x", (strlen($value->cell_number) - 4)).substr($value->cell_number,-4,4) }}</td>
                                    <td >{{ $value->visitor_nric!='' ? $type == 0 ? $value->visitor_nric : str_repeat("x", (strlen($value->visitor_nric) - 4)).substr($value->visitor_nric,-4,4) : '' }}</td>
                                    <td >{{$value->total_vistior}}</td>
                                    <td >{{$value->car_number}}</td>
                                    <td >{{$value->resident_name}}</td>                                    
                                    <td >{{date('d M Y', strtotime($value->visiting_date))}}</td>
                                    <td >{!! $status_set !!}</td>
                                    <td><i class="alert-info" style="padding: 0px !important">{{$value->visitor_code}} </i></td>
                                    <td >{{$value->unit_address}}</td>
                                    <td >{{$value->unit_number}}</td>
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