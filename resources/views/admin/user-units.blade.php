<?php $type = Auth::user()->type; ?>
 <div class="col-sm-12 col-md-12 graphs clearfix pad-btm-50 main_bg">    
        <div class="col-lg-12 no-pad pad-btm-10">
           <h4 class="text-right"><span class="pull-left small-text">Units </span>  @if($type == 5)
               <!--<a href="" id="add_unit_user" ><span class="btn btn-default  my_btn"><i class="fa fa-plus"></i> Add Resident / Tenant</span></a>-->
               @else   @endif</h4>
        </div>
   <div class="unit_div">
      <table id="" class="table table-bordered" cellspacing="0" width="100%" role="grid" aria-describedby="user_list1_info" style="width: 100%;">
                      <thead>
                          <tr class="" role="row">
                          
                              <th class="" tabindex="0" aria-controls="" rowspan="1" colspan="1" aria-label="" style="width: 72px;" style="width: 35px;"><p>UNIT ID</p></th>
                              <th class="" tabindex="0" aria-controls="" rowspan="1" colspan="1" aria-label="" style="width: 101px;" style="width: 101px;"><p>Block Number</p></th>
                              <th class="" tabindex="0" aria-controls="" rowspan="1" colspan="1" aria-label="" style="width: 119px;" ><p>Unit Number</p></th>
                              <th class="" tabindex="0" aria-controls="" rowspan="1" colspan="1" aria-label="" style="width: 119px;" style="width: 119px;"><p>Address</p></th>
                                <th class="" tabindex="0" aria-controls="" rowspan="1" colspan="1" aria-label="" style="width: 72px;" style="width: 35px;">Me & My Family</th>
                          </tr>
                      </thead>
                      <tbody id="the_list1">
                          @if(isset($user_units) && !empty($user_units))
                          @foreach ($user_units as $value)
                       <?php ?>
                          <tr class="erb">
                            
                              <td>{{str_replace('_',' ',$value->unit_ptd)}}</td>
                              <td>{{$value->block_number}}</td>
                              <td>{{$value->unit_number}}</td>
                                <td>{{$value->address}}</td>
                         <td  data-toggle="modal" data-target="#myModal"  class="details-control btn-link" data-unit_id="{{$unit_id}}"  data-property_id="{{$value->id}}" >
                          View
                        </td>
                            
                          </tr>
                          @endforeach
                          @else    
                          <tr style="text-align: center"><td colspan='5'>No records found</td></tr>
                          @endif


                      </tbody>
        </table>
   </div>

</div>
<script type="text/javascript">
$(document).ready(function () {

  $(document).on('click', 'td.details-control', function () {
        property_id=$(this).data('property_id');
        unit_id=$(this).data('unit_id');
      
             if(property_id!==""  && unit_id!==""){
          var family_data_url = '{{url('admin/my-family-data')}}/' + property_id + '/' + unit_id;
             $.ajax({
            type: "GET",
            url: escap_space(family_data_url),
            success: function (data) {
                
                 $('.modal-family-body').html(format(data))
            }
        });    
        }
         
          
     
    } );
});
 
</script>