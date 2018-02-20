 <?php $type = Auth::user()->type; ?>
 
 <div class="col-sm-12 col-md-12 graphs mrg-top1 clearfix">    
 
<div>
<h4><span class="pull-left">Family Member</span></h4><br>
            <table id="user_list1" class="table table-striped family_tables" cellspacing="0" width="100%" role="grid" aria-describedby="user_list1_info" style="width: 100%;">
                <thead>
                    <tr class="" role="row">
                        <th class="sorting_asc" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="NRIC: activate to sort column descending" style="width: 90px;">Name</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Relationship: activate to sort column ascending" style="width: 120px;">NRIC</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending" style="width: 150px;">Mobile Number</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending" style="width: 119px;">House/ Office</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Phone2: activate to sort column ascending" style="width: 119px;">Email</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Type: activate to sort column ascending" style="width: 95px;">Address</th>
                       
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 100px;">Status</th>
                    </tr>
                </thead>
                <tbody id="the_list1">
                    @if(isset($family_member) && !empty($family_member))
                    @foreach ($family_member as $value)
				 <?php ?>
                    <tr>
                        <td >{{$value->name}}</td>
                        <td >{{ $type == 0 ? $value->nric : str_repeat("x", (strlen($value->nric) - 4)).substr($value->nric,-4,4) }}</td>
                        <td >{{ $type == 0 ? $value->phone : str_repeat("x", (strlen($value->phone) - 4)).substr($value->phone,-4,4) }}</td>
                        <td >{{$value->address}}</td>
                        <td >{{$value->email}}</td>
                        <td >{{$value->address}}</td>
                        
                        @if($type != 6) <td >
                            <a data-id="{{$value->id}}" data-status="0" class="family_action_btn deactivate_toggle_{{$value->id}} <?php echo $value->status == 1 ? "show" : "hide" ?>"><p class="deactivate"><i class="fa fa-toggle-on" aria-hidden="true"></i></p></a>
                          
                            <a data-id="{{$value->id}}" data-status="1" class="family_action_btn active_toggle_{{$value->id}} <?php echo $value->status != 1 ? "show" : "hide" ?>"><p class="activate"><i class="fa fa-toggle-off" aria-hidden="true"></i></p></a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @else    
                    <tr style="text-align: center"><td colspan='8'>No records found</td></tr>
                    @endif


                </tbody>
            </table>
           
            <h4><span class="pull-left">Tenant Detail</span></h4><br>
            <table id="user_list2" class="table table-striped family_tables" cellspacing="0" width="100%" role="grid" aria-describedby="user_list1_info" style="width: 100%;">
                <thead>
                    <tr class="" role="row">
                        <th class="sorting_asc" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="NRIC: activate to sort column descending" style="width: 90px;">Name</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Relationship: activate to sort column ascending" style="width: 120px;">NRIC</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending" style="width: 150px;">Mobile Number</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending" style="width: 119px;">House/ Office</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Phone2: activate to sort column ascending" style="width: 119px;">Email</th>
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Type: activate to sort column ascending" style="width: 95px;">Address</th>                       
                        <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 100px;">Status</th>

                    </tr>
                </thead>
                <tbody id="the_list2">				
                    @if(isset($tenant_details) && !empty($tenant_details))
                    @foreach ($tenant_details as $value)

                    <tr >
                        <td >{{$value->name}}</td>
                        <td >{{ $type == 0 ? $value->nric : str_repeat("x", (strlen($value->nric) - 4)).substr($value->nric,-4,4) }}</td>
                        <td >{{ $type == 0 ? $value->phone : str_repeat("x", (strlen($value->phone) - 4)).substr($value->phone,-4,4) }}</td>
                        <td >{{$value->address}}</td>
                        <td >{{$value->email}}</td>
                        <td >{{$value->address}}</td>                      
                         @if($type != 6) <td>
                           
                            <a data-id="{{$value->id}}" data-status="0" class="family_action_btn deactivate_toggle_{{$value->id}} <?php echo $value->status == 1 ? "show" : "hide" ?>"><p class="deactivate"><i class="fa fa-toggle-on" aria-hidden="true"></i></p></a>
                          
                            <a data-id="{{$value->id}}" data-status="1" class="family_action_btn active_toggle_{{$value->id}} <?php echo $value->status != 1 ? "show" : "hide" ?>"><p class="activate"><i class="fa fa-toggle-off" aria-hidden="true"></i></p></a>
                            
                        </td>
                        @endif

                    </tr>
                    @endforeach
                    @else    
                    <tr style="text-align: center"><td colspan='8'>No records found</td></tr>
                    @endif




                </tbody>
            </table>
           
            <h4><span class="pull-left">Car Details</span></h4><br>
            <table id="user_list3" class="table table-striped family_tables" cellspacing="0" width="100%" role="grid" aria-describedby="user_list1_info" style="width: 100%;">
                <thead>
                    <tr class="" role="row">

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
</div>
 </div>
     
  <script type="text/javascript">

$('.family_action_btn').click(function () {
    var id = $(this).data('id');
    var status = $(this).data('status');
    var url = '{{url('admin/familyactionchange')}}/'+id+'/'+status;
    if (status == 0) {
        var type = 'deactivate';
    } else {
        var type = 'activate';
    }
	
    var r = confirm('Confirm ' + type + ' this user');
    if (r == true) {
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
			       if(status == 0) {
                        $('.deactivate_toggle_'+id).removeClass( "show" ).addClass( "hide" );
                        $('.active_toggle_'+id).removeClass( "hide" ).addClass( "show" );
                    }else{
                        $('.deactivate_toggle_'+id).removeClass( "hide" ).addClass( "show" );
                        $('.active_toggle_'+id).removeClass( "show" ).addClass( "hide" );
                    }
                
            }

        });
    } else {

    }
});

</script>

