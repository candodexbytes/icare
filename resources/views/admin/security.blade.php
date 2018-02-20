@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
@section('title', 'Security')
    @section('content')
     <?php  $type = Auth::user()->type; ?>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

    <div id="page-wrapper" class="security1" style="min-height: 140px;">    
        <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Security</span><a href="{{ url('admin/add-security') }}" class="btn btn-default  my_btn"><i  class="fa fa-plus"></i></a></h1>
            </div>    
               @if(Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
             @endif
            <div class="main-div">
                
				 <div class="hide">
            <div class="link_block">
               
              <div class="col-sm-2 text-right heding_link" >
              <h3>Security Link:</h3>
              </div>
              <div class="col-sm-8 link_detail">
              <h3 id="link">{{URL::to("/").'/security/in/'.base64_encode($property_id)}} </h3>
	           
	            </div>
               <div class="col-sm-2 link_detail">
                   <button class="btn btn-primary" id="pcs-cc-button">Copy link</button>
               </div>
              </div>
         </div>
          <table id="security_list" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr class="list_head">
                        
                        <th>Security Name</th>
                        <th>Username</th>

                        
                      @if(isset($type) && ($type==5))
                      <th>Status</th>
                        <th>Action</th>
                       @endif
                    </tr>
                </thead>
                <tbody id="the_list">
                     @if($record)
                    @foreach ($record as $value)
                    <tr>
              
                      <td>{{$value->security_name}}</td>
                      <td>{{$value->username}}</td>
                       @if(isset($type) && ($type==5))
                       <td>
                            @if($value->status == 1)
                            <a data-id="{{$value->security_id}}" data-status="0" class="action_btn"><p class="deactivate"><i class="fa fa-toggle-on" aria-hidden="true"></i></p></a>
                            @else
                            <a data-id="{{$value->security_id}}" data-status="1" class="action_btn"><p class="activate"><i class="fa fa-toggle-off" aria-hidden="true"></i></p></a>
                          @endif
                             </td> 
                             <td>
                                 <span data-security_name="{{ $value->security_name }}" data-username="{{$value->username}}" data-password="{{$value->password}}"  data-id="{{$value->security_id}}"  class="edit_btn"   data-toggle="modal" data-target="#editsecuirtytmodal" ><i class="fa fa-pencil" aria-hidden="true"></i></span> |
                             <span data-id="{{$value->security_id}}" class="delete_security_btn"><i class="fa fa-trash-o" aria-hidden="true"></i></span>

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
            <!-- Modal -->
      <div id="editsecuirtytmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header middle">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit <span id="title_set">Security</span> </h4>
            </div> 
             <form method="POST" action="{{action('AdminController@updateSecurity')}}" id="updatesecurity-form" class="form-horizontal conatct-form  " enctype="multipart/form-data">
               <div class="modal-body">
                        <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                     <input type="hidden" name="security_id" id="security_id" value="">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="securityname">Secury Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="security_name" id="security_name" value=""  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="username">Username</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="user_name" id="user_name" value=""  />
                            </div>
                        </div>
                     <div class="form-group" >
                        <div class="col-sm-9">
                            <input   type="checkbox" name="toggle_pwd" id="toggle_pwd"  value="">&nbsp; <strong> Change Password ? 
                            </strong>
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
                        
                   
                      </div>
                      <div class="modal-footer">
                        <div class="form-group">
                            <div class="col-sm-4">
                                <input type="submit" value="Save" class="btn btn-default my_btn">  
                            </div> 
                        </div>
                      </div>
                       </form>
                
        </div>
    </div>
</div>

             <!--View Modal -->
            
            <script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}">
            </script>
            <script type="text/javascript" src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
			<script type="text/javascript" src="https://www.jqueryscript.net/demo/Copy-Text-To-Clipboard-Plugin-pcsCpClipboard/js/pcsCpClipboard.js"></script>
            <script type="text/javascript">
                 function escap_space(string){
                return string.replace(/\s/g,'');
                  }
               $(document).ready(function() {
			
                $('#toggle_pwd').click(function () {
                  if ($(this).prop('checked') == true) {
                      $('#pwd_section').show();

                  } else {
                      $('#pwd_section').hide();
                  }
              });
            var table =  $('#security_list').DataTable({      
           "order": [[1, "desc"]],
         /*  "columnDefs": [{ "orderable": false, "targets": [0,5] }]*/
        });

        $('.edit_btn').click(function(){
           $('#toggle_pwd').prop('checked', false);
            $('#pwd_section').hide();
          $security_id=$(this).data('id');
          $security_name=$(this).data('security_name');
          $username=$(this).data('username');
          $('#security_name').val($security_name);
          $('#user_name').val($username);
        $('#security_id').val($security_id);
        });
        $('.delete_security_btn').click(function(){
          var id=$(this).data('id');
         var r = confirm("Are you sure to delete this item?");
            if (r == true) {
               $.ajax({
                    type: "POST",
                    url : '{{url('admin/deletesecurity')}}',
                    dataType:"json",
                    data: {"security_id": id,"_token":"{{ csrf_token() }}"},
                    success : function(data){
                      
                        if(data.response == 1){
                            location.reload(true);
                        }

                    }

                });     
            } else {

            }
        });   

           $('.action_btn').click(function(){
          var id=$(this).data('id');
          var status=$(this).data('status');
             if (status == 0) {
              var type = 'deactivate';
          } else {
              var type = 'activate';
          }
          var r = confirm('Confirm ' + type + ' this Security Name');
          if(r==true){
              $.ajax({
                    type: "POST",
                    url : '{{url('admin/actionSecurity')}}',
                    dataType:"json",
                    data: {"security_id": id,"status":status,"_token":"{{ csrf_token() }}"},
                    success : function(data){
                      
                        if(data.response == 1){
                            location.reload(true);
                        }

                    }

                });  
          }else{

          }
                
           
        });    
        $('#link').pcsCpClipboard({ // Set elemente ID to copy (ONLY ID)
        button: '#pcs-cc-button' // Set button for copy
      }); 
	   	});
            </script>
            
        </div>
    </div>
    @endsection
@endguest

