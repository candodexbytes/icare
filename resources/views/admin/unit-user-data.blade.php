 <?php  $type = Auth::user()->type; ?>
 <div class="col-sm-12 col-md-12 graphs clearfix pad-btm-50 main_bg unit-user-data">    
        <div class="col-lg-12 no-pad pad-btm-10">
           <h3 class="text-right"><span class="pull-left small-text">Resident / Tenant</span>  @if($type == 5)
               <a href="" id="add_unit_user" ><span class="btn btn-default  my_btn"><i class="fa fa-plus"></i> Add Resident / Tenant</span></a>
               @else   @endif</h3>
        </div>
   <div class="resident_div">
         <table id="user_list2" class="table table-bordered family_tables" cellspacing="0" width="100%" role="grid" aria-describedby="user_list1_info" style="width: 100%;">
                      <thead>
                          <tr class="" role="row">
                              <th class="sorting_asc" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="NRIC: activate to sort column descending" style="width: 72px;"><p>Name</p></th>
                              <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Relationship: activate to sort column ascending" style="width: 72px;"><p>NRIC</p></th>
                              <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Gender: activate to sort column ascending" style="width: 101px;"><p>Mobile Number</p></th>
                              
                              <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Phone2: activate to sort column ascending" style="width: 119px;"><p>Email</p></th>
                           
                              <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Phone2: activate to sort column ascending" style="width: 119px;"><p>Type</p></th>
                                 <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" aria-label="Phone2: activate to sort column ascending" style="width: 119px;"><p>Me and my family</p></th>
                                 
                          </tr>
                      </thead>
                      <tbody>
                          @if(isset($unit_user) && !empty($unit_user))
                          @foreach ($unit_user as $value)
                       <?php ?>
                          <tr class="user_row">
                              <td >{{$value->name}}</td>
                              <td >{{ ($type == 0 || $type == 5) ? $value->nric : str_repeat("x", (strlen($value->nric) - 4)).substr($value->nric,-4,4) }}</td>
                              <td >{{ ($type == 0 || $type == 5) ? $value->mobile_number : str_repeat("x", (strlen($value->mobile_number) - 4)).substr($value->mobile_number,-4,4) }}</td>
                              <td >{{$value->email}}</td>
                            <td >@if($value->type == 1)
                                  Resident
                                  @elseif($value->type == 2)
                                  Tenant
                                  @else
                                  Visitor 
                                  @endif
                              </td>
                             <td>
                  <a  data-toggle="modal" data-target="#myModal" class="details-child" data-property_id="{{$value->property_id}}" data-user_id="{{$value->user_id}}" data-unit_id="{{$value->unit_id}}" ><i class="fa fa-eye"></i></a>
                  <a  data-toggle="modal" data-target="#myModal" class="details-child" data-property_id="{{$value->property_id}}" data-user_id="{{$value->user_id}}" data-unit_id="{{$value->unit_id}}" ><i class="fa fa-pencil"></i></a>
                              </td>
                          </tr>
                          @endforeach
                          @else    
                          <tr style="text-align: center"><td colspan='8'>No records found</td></tr>
                          @endif


                      </tbody>
        </table>
   </div>

</div>
<!-- Model -->
  <div class="chnge_modal">
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
  </div>  
<!-- Model end -->
<script type="text/javascript">
$(document).ready(function () {
$(document).on('click','.details-child',function(){
    var table1 =  $('#user_list2').DataTable({  
         "retrieve": true,  
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
      });

     var tr = $(this).closest('tr');
        var row = table1.row(tr);
         var user_id = $(this).data('user_id');
         var unit_id = $(this).data('unit_id');
  
        if (row.child.isShown()){
            row.child.hide();
            tr.removeClass('shown');
          } else {
        if(user_id!==""  && unit_id!==""){
          var family_data_url = '{{url('admin/my-family-data')}}/'+user_id+'/'+unit_id;
             $.ajax({
            type: "GET",
            url: family_data_url,
            success: function (data) {
                $('.modal-family-body').html(format(data))
            }

        });    
        }
            tr.addClass('shown');
        } 
});

 $(document).on('click','.family_action_btn',function(){
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
});

</script>
