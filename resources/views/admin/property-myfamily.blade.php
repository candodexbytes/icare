@extends('admin-layouts.app')
@guest
@include('admin-layouts.error')                         
@else
@section('content')
<?php $type = Auth::user()->type; ?>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">
<div id="page-wrapper" style="min-height: 140px;">    
    <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">    
        <div class="col-lg-12 no-pad">
            <h1 class="heading_text text-right"><span class="pull-left">Me & My Family</span><a href="{{ url('admin/all-user') }}" class="btn btn-default my_btn">Back</a></h1>
        </div>
        <?php
		//print_r($tenant_details);

?>
     


            <h4><span class="pull-left">Family Member</span></h4><br>
            <table id="user_list1" class="table table-striped" cellspacing="0" width="100%" role="grid" aria-describedby="user_list1_info" style="width: 100%;">
                <thead>
                    <tr class="list_head" role="row">
                        <th class="sorting_asc" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="NRIC: activate to sort column descending" style="width: 72px;">Name</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Relationship: activate to sort column ascending" style="width: 155px;">NRIC</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending" style="width: 101px;">Mobile Number</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending" style="width: 119px;">House/ Office</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Phone2: activate to sort column ascending" style="width: 119px;">Email</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Type: activate to sort column ascending" style="width: 92px;">Address</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 100px;">Identity</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 100px;">Status</th>
                    </tr>
                </thead>
                <tbody id="the_list1">




                    @if(isset($family_member) && !empty($family_member))
                    @foreach ($family_member as $value)
				 <?php ?>
                    <tr>
                        <td >{{$value->name}}</td>
                        <td >{{$value->nric}}</td>

                        <td >{{$value->phone}}</td>
                        <td >{{$value->address}}</td>
                        <td >{{$value->email}}</td>
                        <td >{{$value->address}}</td>
                        <td></td>


                        @if($type != 6) <td >@if($value->status == 1)
                            <a data-id="{{$value->id}}" data-status="0" class="action_btn"><p class="deactivate"><i class="fa fa-toggle-on" aria-hidden="true"></i></p></a>
                            @else
                            <a data-id="{{$value->id}}" data-status="1" class="action_btn"><p class="activate"><i class="fa fa-toggle-off" aria-hidden="true"></i></p></a>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @else    
                    <tr style="text-align: center"><td colspan='8'>No records found</td></tr>
                    @endif


                </tbody>
            </table>
            <br/>
            <br/>
            <h4><span class="pull-left">Tenant Detail</span></h4><br>
            <table id="user_list2" class="table table-striped" cellspacing="0" width="100%" role="grid" aria-describedby="user_list1_info" style="width: 100%;">
                <thead>
                    <tr class="list_head" role="row">
                        <th class="sorting_asc" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="NRIC: activate to sort column descending" style="width: 72px;">Name</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Relationship: activate to sort column ascending" style="width: 155px;">NRIC</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending" style="width: 101px;">Mobile Number</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending" style="width: 119px;">House/ Office</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Phone2: activate to sort column ascending" style="width: 119px;">Email</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Type: activate to sort column ascending" style="width: 92px;">Address</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 100px;">Identity</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 100px;">Status</th>

                    </tr>
                </thead>
                <tbody id="the_list2">


				
                    @if(isset($tenant_details) && !empty($tenant_details))
                    @foreach ($tenant_details as $value)
				
                    <tr >
                        <td >{{$value->name}}</td>
                        <td >{{$value->nric}}</td>

                        <td >{{$value->phone}}</td>
                        <td >{{$value->address}}</td>
                        <td >{{$value->email}}</td>
                        <td >{{$value->address}}</td>
                        <td></td>

                         @if($type != 6) <td >@if($value->status == 1)
                            <a data-id="{{$value->id}}" data-status="0" class="action_btn"><p class="deactivate"><i class="fa fa-toggle-on" aria-hidden="true"></i></p></a>
                            @else
                            <a data-id="{{$value->id}}" data-status="1" class="action_btn"><p class="activate"><i class="fa fa-toggle-off" aria-hidden="true"></i></p></a>
                            @endif
                        </td>
                        @endif

                    </tr>
                    @endforeach
                    @else    
                    <tr style="text-align: center"><td colspan='8'>No records found</td></tr>
                    @endif




                </tbody>
            </table>
            <br/>
            <br/>
            <h4><span class="pull-left">Car Details</span></h4><br>
            <table id="user_list3" class="table table-striped" cellspacing="0" width="100%" role="grid" aria-describedby="user_list1_info" style="width: 100%;">
                <thead>
                    <tr class="list_head" role="row">

                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Relationship: activate to sort column ascending" style="width: 155px;">Plate Number</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending" style="width: 101px;">Type</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending" style="width: 119px;">Colour</th>

                    </tr>
                </thead>
                <tbody id="the_list3">
                     @if(isset($car_details) && !empty($car_details))
                    @foreach ($car_details as $value)
				
                    <tr>
                        <td >{{$value->car_number}}</td>
                        <td >{{$value->car_model}}</td>

                        <td >{{$value->colour}}</td>
                    

                    </tr>
                    @endforeach
                    @else    
                    <tr style="text-align: center"><td colspan='3'>No records found</td></tr>
                    @endif
                

                </tbody>
            </table>					
  
      

        <!--    <div class="main-div">
                    
                    
                <table id="user_list" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr class="list_head">
                            <th>NRIC</th>
                            <th>Relationship</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Phone2</th>
                            <th>Type</th>
                            <th>Status</th>
                            @if($type == 5)<th>Action</th>@endif
                        </tr>
                    </thead>
                    <tbody id="the_list">
                                            
                                            
                        @if(isset($data))
                            @foreach ($data as $value)
                                <tr>
                                    <td >{{$value->nric}}</td>
                                   
                                    <td >{{$value->relationship}}</td>
                                    <td >{{$value->gender}}</td>
                                    <td >{{$value->phone}}</td>
                                    <td >{{$value->phone2}}</td>
                                    <td >@if($value->type == 1)
                                            My Family
                                        @elseif($value->type == 2)
                                            My Cars
                                        @else
                                            My Tenants
                                        @endif
                                    </td>
                                    <td >@if($value->status == 1)
                                            Activate
                                        @else
                                            Deactivate
                                        @endif
                                    </td>
                                    @if($type == 5)
                                         <td >@if($value->status == 1)
                                                <a data-id="{{$value->id}}" data-status="0" class="action_btn"><p class="deactivate">Deactivate</p></a>
                                            @else
                                                <a data-id="{{$value->id}}" data-status="1" class="action_btn"><p class="activate">Activate</p></a>
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
              
            </div>  -->
    </div>
</div>
<script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}">
</script>
<script type="text/javascript" src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
    //$('table.display').dataTable();
    /*    $('#user_list1').DataTable( {
     responsive: true
     } );
     $('#user_list2').DataTable( {
     responsive: true
     } );
     $('#user_list3').DataTable( {
     responsive: true
     } );*/

});
$('.action_btn').click(function () {
    var id = $(this).data('id');
    var status = $(this).data('status');
    var url = '{{url('admin/familyactionchange')}}/'+id+'/'+status;
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

                    location.reload(true);
                }

            }

        });
    } else {

    }
});

</script>
@endsection
@endguest