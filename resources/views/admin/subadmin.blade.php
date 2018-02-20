@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    @section('title', 'Management Company/Resident Committee')
    <?php  $type = Auth::user()->type; ?>
    @if($type == 0)
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

        <div id="page-wrapper" style="min-height: 140px;">    
            <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">    
                <div class="col-lg-12 no-pad">
                       <h1 class="heading_text text-right"><span class="pull-left">Management Company/Resident Committee </span><a href="{{ url('/taman-condo') }}" class="btn btn-default back_btn my_btn">Back</a><a href="{{ url('admin/add-rcmc') }}" class="btn btn-default my_btn">New RC/MC</a></h1>
                </div>
                <div class="clearfix"></div>
                <div class="main-div">
                    <div class="success_msg" style="height: 30px;clear: both;"></div>
                    <table id="user_list" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr class="list_head">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Cell Number</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="the_list">
                            @if(isset($data))
                                @foreach($data as $value)
                                    <tr id="subadmin_{{$value->id}}">
                                        <td >{{$value->name}}</td>
                                        <td >{{$value->email}}</td>
                                        <td >{{$value->mobile_number}}</td>
                                        <td >@if($value->type == 5)
                                                Management Company
                                            @elseif($value->type == 6)
                                                Resident Committee (MC)
                                            @else
                                                
                                            @endif</td>
                                        <td>{{date('d M Y', strtotime($value->created_at))}}</td>
                                        <td>
                                           <span data-id="{{$value->id}}" data-name="{{$value->name}}" data-type="{{$value->type}}" data-mobilenumber="{{$value->mobile_number}}" class="edit_btn"><i class="glyphicon glyphicon-edit"></i></span> 
                                           | <span data-id="{{$value->id}}" class="delete_btn"><i class="glyphicon glyphicon-trash"></i></span> 
 
                                        </td>
                                    </tr>
                                @endforeach
                            @else    
                                <tr><td colspan='2'>No records found</td></tr>
                            @endif
                        </tbody>
                    </table>    
                    
                </div>
            </div>
        </div>

         <!-- Modal -->
            <div id="editmodal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit <span id="title_set">User</span> </h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" class="conatct-form form-horizontal" action="{{action('AdminController@UpdateRcMcUser')}}" id="update_RcMcUser_form" enctype="multipart/form-data">
                                <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                                <input type="hidden" name="id" id="id" value="">
                                <input type="hidden" name="current_number" id="current_number" value="">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="name">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control"  name="name" id="name" value=""/>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-sm-3 control-label">Mobile Number</label>
                                  <div class="col-sm-9">
                                      <input type="text" class="form-control"  name="mobile_number" id="mobile_number" value="" />
                                  </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="datepicker">User Type</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="change_type" id="change_type">
                                            <option id="type_5" value="5">Management Company</option>
                                            <option id="type_6" value="6">Resident Committee (MC)</option>
                                        </select>
                                    </div>
                                </div>
                                 <div class="form-group" >
                                <div class="col-sm-9">
                                    <input   type="checkbox" name="toggle_pwd" id="toggle_pwd"  value="">&nbsp;  Change Password ? 
                                </div>
                                <div class="col-sm-3"></div>
                             </div>
                                <div id="pwd_section">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="password">Password</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password"  name="password" id="password"  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="confirm_password">Confirm Password</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password"  name="confirm_password" id="confirm_password"  />
                            </div>
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
            $(document).ready(function() {
               $('#user_list').DataTable({});
                      $('#pwd_section').hide();
                });

            $('.edit_btn').click(function(){
                    $('#toggle_pwd').prop('checked', false);
                    $('#pwd_section').hide();
                    $('#id').val($(this).data('id'));
                    $('#current_number').val($(this).data('mobilenumber'));                  
                    $('#name').val( $(this).data('name'));
                    $('#mobile_number').val($(this).data('mobilenumber'));
                   // $('#type_'+$(this).data('type')).prop('selected', true);       
                    $('#change_type').val($(this).data('type'));             
                    $('#editmodal').modal('show');                         
                    
            });

            $('.delete_btn').click(function(){
                    var id = $(this).data('id');
                    var url = '{{url('admin/deletesubadmin')}}/'+id;
                    var r = confirm("Confirm delete this subadmin!");
                    if (r == true) {
                       $.ajax({
                            type: "GET",
                            url : url,
                            success : function(data){
                                if(data.response == 1){
                                   $( '#subadmin_'+id ).remove();
                                    $('.success_msg').html('RC/MC remove successfully');
                                    setTimeout(function() {
                                        $('.success_msg').fadeOut('slow');
                                    }, 2000);
                                }
                              
                            }

                        });     
                    }
                });

            $('#toggle_pwd').click(function () {
                if ($(this).prop('checked') == true) {
                    $('#pwd_section').show();

                } else {
                    $('#pwd_section').hide();
                }
            });
        </script>
        @endif
    @endsection
@endguest