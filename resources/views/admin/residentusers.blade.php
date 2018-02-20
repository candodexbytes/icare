@extends('admin-layouts.app')
@guest
@include('admin-layouts.error')                         
@else
@section('content')
<?php
$type = Auth::user()->type;
$genrate_ptd_id = str_replace(' ', '-', Auth::user()->ptd_id);
?>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

<div id="page-wrapper" class="residentusers" style="min-height: 140px;">    
    <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">  
        <div class="col-lg-12 no-pad">
            <h1 class="heading_text text-right"><span class="pull-left">Resident Users</span>@if($type == 5)
                <!--<a href="{{url('admin/new-resident-user')}}"><span class="btn btn-default my_btn"><i class="fa fa-plus"></i></span></a>-->
                @else<br/>@endif</h1>
        </div>
        <div class="clearfix">
             @if(Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                    @endif
        <div class="main-div">
            <table id="user_list" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr class="list_head">
                          @if($type == 5  || $type == 6 || $type == 0)
                          <th></th>
                          @else
                          @endif
                        <th>NRIC</th>
                        <th>Name</th>
                        <th>Mobile Number</th>
                        <th> Created Date</th>
                      
                    
                        <th>Status</th>
                        @if($type == 5)
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="the_list">
                    @if($data)
                    @foreach ($data as $value)
                    <tr>
                        @if($type == 5  || $type == 6 || $type == 0)
                           <td class="detail_unit" data-user_id="{{$value->id}}"  data-unit_id="{{$value->unit_id}}" data-property_id="{{$value->property_id}}" ></td>
                          @else
                          
                          @endif 
                      
                        <td>{{$value->nric}}</td>
                 
                        <td>{{$value->name}}</td>
                        
                        <td>{{$value->mobile_number}}</td>
                        <td><span class="hidden">{{$value->created_at}}</span>{{date('d M Y', strtotime($value->created_at))}}</td>
                       
                       <!--  <td ><a href="{{url('/')}}/admin/maintenance-fee/{{$genrate_ptd_id}}/{{$value->id}}">View</a></td> -->

                        <td >@if($value->status == 1)
                            <a data-id="{{$value->id}}" data-status="0" class="action_btn"><p class="deactivate"><i class="fa fa-toggle-on" aria-hidden="true"></i></p></a>
                            @else
                            <a data-id="{{$value->id}}" data-status="1" class="action_btn"><p class="activate"><i class="fa fa-toggle-off" aria-hidden="true"></i></p></a>
                            @endif
                        </td>
                        @if($type == 5)
                        <td>
                          <span  data-name="{{$value->name}}" data-nric="{{$value->nric}}" data-email="{{$value->email}}"  data-id="{{$value->id}}" data-mobilenumber="{{$value->mobile_number}}"  class="edit_btn"><i class="fa fa-pencil" aria-hidden="true"></i></span>                 
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
<!-- Modal -->
<div id="editmodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header middle">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit <span id="title_set">Resident Users</span> </h4>
            </div>
            <div class="modal-body pad">
                <form method="post" action="{{action('AdminController@UpdateResidentUser')}}"  class="conatct-form form-horizontal" id="update_residentuser_form" enctype="multipart/form-data">
                    <input type="hidden" name="_token" id="token" value="<?= csrf_token(); ?>">
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="ptd_id" id="ptd_id" value="">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name"><strong> Name </strong></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text"  name="name" id="name" value=""  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="nric"><strong>NRIC</strong></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text"  name="nric" id="nric" value=""  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="email"><strong>Email</strong></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text"  name="email" id="email" value=""  />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="cell_number"><strong>Mobile Number</strong></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text"  name="cell_number" id="cell_number"  />
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
                            <label class="col-sm-3 control-label" for="password"><strong>Password</strong></label>
                            <div class="col-sm-8">
                                <input class="form-control" type="password"  name="password" id="password"  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="confirm_password"><strong>Confirm Password</strong></label>
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

<!-- Modal -->
<div class="modal fade" id="residentDetailModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header middel">
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
                    <p>NRIC
                    </p></div>
                <div class="col-sm-8 col-xs-6 payment_text"><b>
                        <p id="nric_txt">Sam</p>
                    </b></div>
                <div class="col-sm-4 col-xs-6 payment_text">
                    <p>Mobile Number
                    </p></div>
                <div class="col-sm-8 col-xs-6 payment_text"><b>
                        <p id="mobile_txt">Sam</p>
                    </b></div>
                <div class="col-sm-4 col-xs-6 payment_text">
                    <p>Email
                    </p></div>
                <div class="col-sm-8 col-xs-6 payment_text"><b>
                        <p id="email_txt"></p>
                    </b></div>
                 <div class="col-sm-4 col-xs-6 payment_text">
                    <p>House/Flat Number
                    </p></div>
                <div class="col-sm-8 col-xs-6 payment_text"><b>
                        <p id="house_number_txt"></p>
                    </b></div>
                    <div class="col-sm-4 col-xs-6 payment_text">
                    <p>Block Number
                    </p></div>
                <div class="col-sm-8 col-xs-6 payment_text"><b>
                        <p id="block_number_txt"></p>
                    </b></div>
                    <div class="col-sm-4 col-xs-6 payment_text">
                    <p>Address
                    </p></div>
                <div class="col-sm-8 col-xs-6 payment_text"><b>
                        <p id="address_txt"></p>
                    </b></div>
                
                <div class="col-sm-4 col-xs-6 payment_text">
                    <p>Status
                    </p></div>
                <div class="col-sm-8 col-xs-6 payment_text"><b>
                        <p id="status_txt"></p>
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
    var table =  $('#user_list').DataTable({
//        responsive: false,
        "order": [[3, "desc"]]
    });
    $('#pwd_section').hide();
    $('#user_list tbody').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      ptd_id=$(this).data('ptd_id');
      user_id=$(this).data('user_id');

      if ( row.child.isShown() ) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');

      }
      else {
          // Open this row

           if(ptd_id!==""  &&user_id!==""){
        var family_data_url = '{{url('admin/my-family-data')}}/' + ptd_id + '/' + user_id;
           $.ajax({
          type: "GET",
          url: escap_space(family_data_url),
          success: function (data) {
                 row.child( format(data) ).show();
          }

      });    
      }

          tr.addClass('shown');
      }
  } );
  
   $('.detail_unit').click(function(){
    
       var tr = $(this).closest('tr');
        var row = table.row( tr );
        user_id=$(this).data('user_id');  
          unit_id=$(this).data('unit_id'); 
        
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
});
$('.action_btn').click(function () {

    var id = $(this).data('id');
    var status = $(this).data('status');
    var url = '{{url('admin/actionchange')}}/'+id+'/'+status;
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
});

$('.edit_btn').click(function () {
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

$('.detail_btn').click(function () {
    var name = $(this).data('name');
    var nric = $(this).data('nric');
    var email = $(this).data('email');
    var mobilenumber = $(this).data('mobilenumber');
    var status = $(this).data('status');
    var block_number = $(this).data('block_number');
    var house_number = $(this).data('house_number');
    var address = $(this).data('address');
    $('#name_txt').text(name);
    $('#nric_txt').text(nric);
    $('#email_txt').text(email);
    $('#mobile_txt').text(mobilenumber);
     $('#block_number_txt').text(block_number);
    $('#house_number_txt').text(house_number);
    $('#address_txt').text(address);
    if (status == 1) {
        status = 'active';
    } else {
        status = 'deactive';
    }
    $('#status_txt').text(status);
  //  $('#residentDetailModal').modal('show');
});




$('#toggle_pwd').click(function () {
    if ($(this).prop('checked') == true) {
        $('#pwd_section').show();

    } else {
        $('#pwd_section').hide();
    }
});

/* Formatting function for row details - modify as you need */
function format(data) {
    return data;
  }



</script>
@endsection
@endguest
