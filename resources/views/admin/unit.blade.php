@extends('admin-layouts.app')
@guest
@include('admin-layouts.error')                         
@else
@section('content')

@section('title', 'Unit')
<?php
$type = Auth::user()->type;
$genrate_ptd_id = str_replace(' ', '-', Auth::user()->ptd_id);
?>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">
<div id="page-wrapper" class="unit_new" style="min-height: 140px;">    
    <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">  
        <div class="col-lg-12 no-pad">
           <h1 class="heading_text text-right"><span class="pull-left">Units of 
              {{isset(Session::get('Property')->township_name) ? Session::get('Property')->township_name:''}}</span> 
               @if($type == 5)
               <a href="{{url('admin/add-unit/')}}"><span class="btn btn-default  my_btn"><i class="fa fa-plus"></i></span></a>
               @else <a href="{{url('admin/manage-property')}}"><span class="btn btn-default  my_btn">Back</span></a>  @endif</h1>
        </div>
        <div class="clearfix">
             @if(Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
             @endif
        </div>  
        <div class="main-div">
            <table id="user_list" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr class="list_head">
                        <th></th>
                        <th>PTD Number</th>
                        <th>Unit Number</th>
                        <th>Block</th>
                        <th>Address</th>
                        <th>Status</th>
                        @if(isset($type) && ($type==5))
                         <th>Action</th>
                        @else
                        @endif
                        <!-- <th>Details</th> -->
                        </tr>
                </thead>
                <tbody id="the_list"> 
                    @if(isset($unit) & !empty($unit)) 
                    @foreach ($unit as $value)
                    <tr class="unit_row">
                        @if($type == 5  || $type == 6 || $type == 0)
                          <td class="details-control" data-property_id="{{ $value->property_id }}" data-unit_id="{{ $value->id }}" ></td>
                        @endif
                        <td>{{ $value->unit_ptd }}</td>                       
                       <td>{{  $value->unit_number }}</td>
                        <td>{{ $value->block_number }}</td>
                        <td>{{ $value->address }}</td>
                             <td >
                            @if($value->status == 1)
                            <a data-id="{{$value->id}}" data-status="0" class="action_btn"><p class="deactivate"><i class="fa fa-toggle-on" aria-hidden="true"></i></p></a>
                            @else
                            <a data-id="{{$value->id}}" data-status="1" class="action_btn"><p class="activate"><i class="fa fa-toggle-off" aria-hidden="true"></i></p></a>
                          @endif
                             </td> 
                             
                        @if(isset($type) && $type==5)
                         <td>
                            <span data-unit_ptd="{{ $value->unit_ptd }}" data-block_number="{{$value->block_number}}" data-house_number="{{$value->unit_number}}" data-address="{{$value->address}}"   data-id="{{$value->id}}"  class="edit_btn"   data-toggle="modal" data-target="#editunitmodal" ><i class="fa fa-pencil" aria-hidden="true"></i></span> |
                             <span data-id="{{$value->id}}" class="delete_unit_btn"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
                         </td>
                        @else                        
                        @endif  
                        </tr>
                    @endforeach
                    @else    
                    <tr><td colspan='5'>No records found</td></tr>
                    @endif
                </tbody>
            </table>    

        </div>
    </div>
</div>
<!-- Modal -->
<div id="editunitmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header middle">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit <span id="title_set">Unit</span> </h4>
            </div> 
            <form method="post" action="{{action('AdminController@UpdateUnit')}}"  class="conatct-form form-horizontal" id="update_unit_form" enctype="multipart/form-data">
            <div class="modal-body pad">                
                    <input type="hidden" name="_token" id="token" value="<?= csrf_token(); ?>">
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="ptd_id" id="ptd_id" value="">
                       <div class="form-group">
                            <label class="col-sm-3 control-label" for="unit_ptd"> <strong>PTD Number</strong> </label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text"  name="unit_ptd" id="unit_ptd"  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="house_number"> <strong>Unit Number</strong> </label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text"  name="house_number" id="house_number"  />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label" for="cell_number"><strong> Block Number</strong> </label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text"  name="block_number" id="block_number"  />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-3 control-label" for="cell_number"><strong> Address</strong> </label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text"  name="address" id="address"  />
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
<script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}">
</script>
<script type="text/javascript" src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript">
function escap_space(string) {
    return string.replace(/\s/g, '');
}

function format(data) {
    return data;
  }
$(document).ready(function () {
   var table =  $('#user_list').DataTable({      
       "order": [[1, "desc"]],
     /*  "columnDefs": [{ "orderable": false, "targets": [0,5] }]*/
    });
   
    
      $('#user_list tbody').on('click', 'td.details-control', function () {

        var tr = $(this).closest('tr');
        var row = table.row(tr);
        property_id=$(this).data('property_id');   
        unit_id=$(this).data('unit_id');     
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');           
        }
        else {
           if(unit_id!==""  && property_id!==""){
          var unit_data_url = '{{url('admin/unit-user-data')}}/' + property_id + '/' + unit_id;
          $.ajax({
            type: "GET",
            url: escap_space(unit_data_url),
            success: function (data) {
                   row.child( format(data) ).show();
                   $('#add_unit_user').attr('href','{{url('admin/add-unit-user')}}/'+ property_id + '/' + unit_id);
            }
         });    
        }        
            tr.addClass('shown');
        }
    } );
    $(document).on('click','.delete_unit_btn',function(){
           var unit_id = $(this).data('id');
           var r = confirm("Are you sure to delete this item?");
            if (r == true) {
               $.ajax({
                    type: "POST",
                    url : '{{url('admin/deleteunit')}}',
                    dataType:"json",
                    data: {"unit_id": unit_id,"_token":"{{ csrf_token() }}"},
                    success : function(data){
                      
                        if(data.response == 1){
                            location.reload(true);
                        }

                    }

                });     
            } else {

            }
    });
});




$('.edit_btn').click(function (e) {
    $('#id').val($(this).data('id'));
    $('#block_number').val($(this).data('block_number'));
    $('#house_number').val($(this).data('house_number'));
    $('#address').val($(this).data('address'));
    $('#unit_ptd').val($(this).data('unit_ptd'));
  $('#editunitmodal').modal('show');
});



$('.action_btn').click(function () {
    var id = $(this).data('id');
    var status = $(this).data('status');
    var url = '{{url('admin/unitactionchange')}}/'+id+'/'+status;
    if (status == 0) {
        var type = 'deaactivate';
    } else {
        var type = 'activate';
    }
    
    var r = confirm('Confirm ' + type + ' this user');
    if (r == true) {
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                if (data.response == 1) {

                  location.reload(true)
                }

            }

        });
    } else {

    }
});

</script>


@endsection
@endguest




