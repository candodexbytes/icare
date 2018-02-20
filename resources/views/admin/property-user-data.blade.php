 <?php $type = Auth::user()->type; ?>
 <div class="col-sm-12 col-md-12 graphs clearfix pad-btm-50">    
        <!-- <div class="col-lg-12 no-pad pad-btm-10">
           <h3 class="text-right"><span class="pull-left">Resident / Tenant</span></h3>
        </div> -->
   <div class="property_div">
      <table id="user_list2" class="table table-bordered family_tables" cellspacing="0" width="100%" role="grid" aria-describedby="user_list1_info" style="width: 100%;">
          <thead>
              <tr class="" role="row">
                  <th class="sorting_asc" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1 style="width: 72px;">Invoice Month</th>
                  <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" style="width: 72px;">Amount</th>
                  <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" style="width: 101px;">Invoice Date</th>
                  
                  <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" style="width: 119px;">Due Date</th>
               
                  <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" style="width: 119px;">Status</th>

                  <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" style="width: 119px;">Bill ID</th>

                  <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" style="width: 119px;">Transaction ID</th>

                  <th class="sorting" tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" style="width: 119px;"></th>
              </tr>
          </thead>
          <tbody id="the_list1">
            @if(isset($unit_property) && !empty($unit_property))
            @foreach ($unit_property as $value)            
                <tr>
                    <td>{{$value->invoice_month}}</td>
                    <td>RM {{$value->total_amount}}</td>
                    <td>{{$value->invoice_date}}</td>
                    <td>{{$value->due_due}}</td>
                    <td>
                      @if($value->payment_status == 0)
                        Pending
                        @elseif($value->payment_status == 1)
                        Paid 
                        @else
                        Failed 
                      @endif
                    </td>
                    <td>
                      @if($value->bill_id)
                          {{$value->bill_id}}
                          @else
                          -- 
                      @endif
                    </td>
                    <td>
                      @if($value->slug)
                          {{$value->slug}}
                          @else
                          -- 
                      @endif
                    </td>
                    <td>
                        <a  data-toggle="modal" data-target="#myModal" class="details-control-next btn-link" data-ptd_id="{{str_replace('-',' ',$value->ptd_id)}}" data-unit_id="{{$value->unit_id}}"
                          data-id="{{$value->id}}"><i class="fa fa-eye"></i></a>
                          <a id="reminder" data-ptd_id="{{str_replace('-',' ',$value->ptd_id)}}" data-unit_id="{{$value->unit_id}}"
                          data-id="{{$value->id}}"><i class="fa fa-bell"></i></a>
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

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body">
    <div class="alert alert-success">
      <strong>Success!</strong> Reminder send successfully.
    </div>
  </div>
</div>

 <!-- Model -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Maintenance Detail</h4>
      </div>
      <div class="modal-body clearfix">        
      </div>     
    </div>
  </div>
 
 </div>  
<!-- Model end -->
 <script type="text/javascript">
  $(document).ready(function () {
    // $('.success').hide();
   var table1 =  $('#user_list2').DataTable({  
       "retrieve": true,  
      "paging":   false,
      "ordering": false,
      "info":     false,
      "searching": false,
    });
    $(document).on('click','.btn-link',function(){
        var tr = $(this).closest('tr');
        var row = table1.row( tr );
        ptd_id = $(this).data('ptd_id');
        unit_id = $(this).data('unit_id');
        id = $(this).data('id');
     
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            if(ptd_id!==""  && unit_id!==""){
              var property_data_url = '{{url('admin/property-data')}}/' + ptd_id + '/' + unit_id + '/' + id;
              $.ajax({
                type: "GET",
                url: escap_space(property_data_url),
                success: function (data) {
                 //   alert(data);
                    $('.modal-body').html(format(data))
                     //  row.child( format(data) ).show();
                    //   $('#add_unit_user').attr('href','{{url('admin/add-unit-user')}}/'+ ptd_id + '/' + user_id);
                }
              });    
          }
          tr.addClass('shown');
        }
    }); 

    $(document).on('click','#reminder',function(){
        ptd_id = $(this).data('ptd_id');
        unit_id = $(this).data('unit_id');

        var post_url = '/condo-management/admin/reminder';
        var data = {
            ptd_id: ptd_id,
            unit_id: unit_id
        }

        $.ajax({
          type: "POST",
          url: post_url,
          data: data,
          dataType: 'json',
          success: function(data){
            console.log(data);
            $("#myModal1").modal('show');

            setTimeout(function() {
              $("#myModal1").modal('hide');
            },2000);
            
          } 
        });
    });
  });
 </script>

 <style type="text/css">
   .modal-body {
      width: 50%;
      text-align: center;
      margin: 0 auto;
   }
 </style>