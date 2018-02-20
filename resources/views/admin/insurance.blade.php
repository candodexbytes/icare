@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    @section('title', 'Insurance')
    <?php  $type = Auth::user()->type; ?>
    @if($type == 0)
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

    <div id="page-wrapper" style="min-height: 140px;">    
        <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Insurance</span><a href="{{ url('admin/manage-property') }}" class="btn btn-default my_btn">Back</a></h1>
            </div>    
           
            <div class="main-div">
                <div class="success_msg" style="height: 30px;clear: both;"></div>
                <table id="complaint_list" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr class="list_head">
                          
                            <th>NRIC</th>
                            <th>Car Model</th>
                            <th>Car Number</th>
                            <th>Insurance Company</th>
                            
                        </tr>
                    </thead>
                    <tbody id="the_list">
                        @if(isset($get_record))
                            @foreach ($get_record as $value)
                                <tr>
                                  
                                     <td >{{$value->nric}}</td>
                                    <td >{{$value->car_model}}</td>
                                    <td >{{$value->car_number}}</td>
                                    <td >{{$value->insurance_company}}</td>
                                   
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
                    <h4 class="modal-title">Edit <span id="title_set">Complaint</span> </h4>
                  </div>
                  <div class="modal-body">
                  <form method="post" action="" id="update_complaint_form" enctype="multipart/form-data">
                    <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                    <input type="hidden" name="id" id="id" value="">
                    
                    <div class="modelFormRow">
                        <label for="change_status">Change Status</label><br>
                        <select name="change_status" id="change_status">
                            <option id="status_0" value="0">Pending</option>
                            <option id="status_1" value="1">Approve</option>
                            <option id="status_2" value="2">Completed</option>
                            <option id="status_3" value="3">Cancel</option>
                        </select>
                    </div>
                   
                    
                    <input type="submit" value="Update">
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
                    $('#complaint_list').DataTable( {
                        responsive: true
                    } );
                } );
            </script>
            <script type="text/javascript">
                $('.delete_btn').click(function(){
                    var id = $(this).data('id');                
                    var r = confirm("Confirm delete this package!");
                    if (r == true) {
                       $.ajax({
                            type: "GET",
                            url : url,
                            success : function(data){
                                if(data.response == 1){

                                    $( '#property_'+id ).remove();

                                    $('.success_msg').html('Property remove successfully');
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
               
                
            </script>
        </div>
    </div>
    @endif
    @endsection
@endguest