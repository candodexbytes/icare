@extends('admin-layouts.app')
@guest
@include('admin-layouts.error')                         
@else
@section('content')
@section('title',   $title   )
<?php
$type = Auth::user()->type;  
$genrate_ptd_id = str_replace(' ', '-', Auth::user()->ptd_id);
?>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

<div id="page-wrapper" style="min-height: 140px;">    
    <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">  
        <div class="col-lg-12 no-pad">
            <h1 class="heading_text text-right"><span class="pull-left">{{ $title }}</span>
                @if($type == 5)             
               @else <a href="{{url('admin/manage-property')}}"><span class="btn btn-default  my_btn">Back</span></a>  
           @endif</h1>
        </div>
       <div class="clearfix">
            @if(Session::has('success'))
               <div class="alert alert-info">{{ Session::get('success') }}</div>
            @endif
        <div class="main-div">
            <table id="user_list" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr class="list_head">               
                        <th>PTD No</th>
                        <th>Block No</th>
                        <th>Unit No</th>
                        <th>Address</th>
                        <th>Name</th>
                        <th>NRIC</th>                       
                        <th>Mobile</th>
                        <th>Created Date</th>
                        <th>Type</th>
                       <th>Family</th>                      
                    </tr>
                </thead>
                <tbody id="the_list">
                    @if($data)
                    @foreach ($data as $value)
                    <tr>                      
                        <td>{{$value->unit_ptd}}</td>
                        <td>{{$value->block_number}}</td>
                        <td>{{$value->unit_number}}</td>
                        <td>{{$value->address}}</td>
                        <td>{{$value->name}}</td>
                        <td>{{ ($type == 0 || $type == 5) ? $value->nric : str_repeat("x", (strlen($value->nric) - 4)).substr($value->nric,-4,4) }}</td>                        
                        <td>{{ ($type == 0 || $type == 5) ? $value->mobile_number : str_repeat("x", (strlen($value->mobile_number) - 4)).substr($value->mobile_number,-4,4) }}</td>                        
                        <td><span class="hidden">{{$value->created_at}}</span>
                            {{date('d M Y', strtotime($value->created_at))}}
                        </td>
                        <td>@if($value->type == 1) 
                            Resident 
                            @elseif($value->type == 2)
                            Tenant 
                            @else 
                            Visitor 
                            @endif
                        </td>
                        <td>
                        <a data-toggle="modal" data-target="#myModal" class="details-child me_and_my_family" data-property_id="{{$value->property_id}}" data-user_id="{{$value->user_id}}" data-unit_id="{{$value->unit_id}}" ><i class="fa fa-eye"></i></a>
                        @if($type == 0)
                            <a class="delete" data-property_id="{{$value->property_id}}" data-user_id="{{$value->user_id}}" data-unit_id="{{$value->unit_id}}"><i class="fa fa-trash "></i></a>
                        @else 
                            <a class="remove" data-property_id="{{$value->property_id}}" data-user_id="{{$value->user_id}}" data-unit_id="{{$value->unit_id}}"><i class="fa fa-trash "></i></a>
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
    </div>
</div>
<!-- Modal -->
<div id="editmodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header middle">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit <span id="title_set">Users</span> </h4>
            </div> 
            <div class="modal-body pad">
                <form method="post" action="{{action('AdminController@UpdateTenantUser')}}"  class="conatct-form form-horizontal" id="update_tenantuser_form" enctype="multipart/form-data">
                    <input type="hidden" name="_token" id="token" value="<?= csrf_token(); ?>">
                    <input type="hidden" name="id" id="id" value="">
               
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name"><strong> Name </strong></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text"  name="name" id="name" value=""  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="nric"><strong> NRIC </strong></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text"  name="nric" id="nric" value=""  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="email"><strong> Email </strong></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text"  name="email" id="email" value=""  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="cell_number"><strong> Mobile Number </strong></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text"  name="cell_number" id="cell_number"  />
                        </div>
                    </div>
                 
                    <div class="form-group" >
                        <div class="col-sm-9">
                            <input   type="checkbox" name="toggle_pwd" id="toggle_pwd"  value="">&nbsp;<strong>  Change Password ? </strong>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
                    <div id="pwd_section">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="password"><strong> Password </strong></label>
                            <div class="col-sm-8">
                                <input class="form-control" type="password"  name="password" id="password"  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="confirm_password"><strong> Confirm Password</strong></label>
                            <div class="col-sm-8">
                                <input class="form-control" type="password"  name="confirm_password" id="confirm_password"  />
                            </div>
                        </div>     
                    </div>
                    <div class="form-group">

                        <div class="col-sm-offset-9 col-sm-3">
                            <input type="submit" class="btn btn-default my_btn" value="Update">
                        </div>
                    </div>
                </form>
            </div>  
        </div>
    </div>
</div>

<!-- Model -->
  
   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header middle">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Me & My family</h4>
            </div>
            <div class="modal-family-body clearfix">        
            </div>     
          </div>
        </div>
   </div>
  
<!-- Model end -->
<script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}">
</script>
<script type="text/javascript" src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript">
function escap_space(string) {
    return string.replace(/\s/g, '');
}
/* Formatting function for row details - modify as you need */
function format(data) {
    return data;
  }
$(document).ready(function () {
   var table =  $('#user_list').DataTable({     
       "order": [[1, "desc"]]
    });

    $('#pwd_section').hide();
    $(document).on('click', '.me_and_my_family', function () {       
        var user_id = $(this).data('user_id');
        var unit_id = $(this).data('unit_id');      

        if(user_id !== ""  && unit_id !== ""){
               var family_data_url = '{{url('admin/my-family-data')}}/' + user_id + '/' + unit_id;
               $.ajax({
                type: "GET",
                url: escap_space(family_data_url),
                success: function (data) { 
                     $('.modal-family-body').html(format(data))
                }
            });    
           }       
    } );


    $(document).on('click', '.remove', function () {
        var user_id = $(this).data('user_id');     
        
        var post_url = '/condo-management/admin/remove-teman-from-management';
        var data = {
            user_id: user_id
        }

        $.ajax({
          type: "POST",
          url: post_url,
          data: data,
          dataType: 'json',
          success: function(data){
            console.log(data);
            if (data.response == 1) {
                location.reload();
            }
          } 
        });
    });

    $(document).on('click', '.delete', function () {
        var user_id = $(this).data('user_id');     
        
        var post_url = '/condo-management/admin/delete-teman';
        var data = {
            user_id: user_id
        }

        $.ajax({
          type: "POST",
          url: post_url,
          data: data,
          dataType: 'json',
          success: function(data){
            console.log(data);
            if (data.response == 1) {
                location.reload();
            }
          } 
        });
    });
    
    
/*    $('.detail_btn').click(function(){
       var tr = $(this).closest('tr');
        var row = table.row( tr );
         user_id = $(this).data('user_id');  
         unit_id = $(this).data('unit_id');  
       
          if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
             if(unit_id!=="" && user_id!==""){
          var unit_user_url = '{{url('admin/get-user-unit')}}/' +unit_id+'/'+ user_id; 
             $.ajax({
            type: "GET",
            url: escap_space(unit_user_url),
            success: function (data) {
                  row.child( format(data) ).show();
                // $('.modal-family-body').html(format(data))
            }
        });    
        }
         
            tr.addClass('shown');
        }
  });
*/
});

/*$('.action_btn').click(function () {
    var id = $(this).data('id');
    var status = $(this).data('status');
    var url = '{{url('admin / actionchange')}}/' + id + '/' + status;
    if (status == 0) {
        var type = 'deaactivate';
    } else {
        var type = 'activate';
    }
    var r = confirm('Confirm ' + type + ' this user');
    if (r == true) {
        $.ajax({
            type: "GET",
            url: escap_space(url),
            success: function (data) {
                if (data.response == 1) {

                    location.reload(true);
                }

            }

        });
    } else {

    } 
});*/

/*$('.edit_btn').click(function () {
    $('#toggle_pwd').prop('checked', false);
    $('#pwd_section').hide();
    var id = $(this).data('id');
    var name = $(this).data('name');
    var nric = $(this).data('nric');
    var email = $(this).data('email');
    var mobilenumber = $(this).data('mobilenumber');
    $('#id').val(id);
    $('#name').val(name);
    $('#nric').val(nric);
    $('#email').val(email);
    $('#cell_number').val(mobilenumber);
    $('#editmodal').modal('show');
});
*/

$('#toggle_pwd').click(function () {
    if ($(this).prop('checked') == true) {
        $('#pwd_section').show();

    } else {
        $('#pwd_section').hide();
    }
});

</script>


@endsection
@endguest
