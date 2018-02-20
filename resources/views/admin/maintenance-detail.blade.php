@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
@section('content')
@section('title',"Maintenance")

    <?php  $type = Auth::user()->type; ?>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

    <div id="page-wrapper" class="maintenance-detail" style="min-height: 140px;">    
        <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">  

            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Maintenance</span><a href="{{ url('admin/manage-property') }}" class="btn btn-default  my_btn">Back</a></h1>
            </div>
            <!-- /.col-lg-12 -->
        
            <div class="main-div">
                <div class="success_msg" style="color:green;height: 30px;clear: both;"></div>
                <table id="contact_list"  class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr class="list_head">
                            <td></td>
                            <th>UNIT ID</th>
                            <th>Block</th>
                            <th>Unit Number</th>
                            <th>Address</th>
                            <th>Status</th>                             
                            <th>Add Invoice</th>
                            <th>Details</th>
                        </tr>
                    </thead>     
                    <tbody id="the_list"> 
                    @if(isset($unit) & !empty($unit)) 
                    @foreach ($unit as $value)
                    <tr class="unit_row">
                        <td class="details-control"   data-property_unit_id="{{$value->id}}" data-user_id="{{$value->id}}" ></td>
                        <td  data-property_unit_id="{{$value->id}}"  >{{strtoupper( str_replace('_',' ',$value->unit_ptd))}}</td>
                        <td>{{$value->block_number}}</td>
                        <td>{{$value->unit_number}}</td>                      
                        <td>{{$value->address}}</td>
                        <td >
                            @if($value->status == 1)
                             <label  class="label label-success">Active</label>
                            @else
                           <label  class="label label-default">InActive</label>
                          @endif
                       </td>
                        <td ><a href="{{url('/')}}/admin/maintenance/{{$value->id}}"><i class="fa fa-plus"></i> Invoice</a> </td>
                        <td class="details"   data-property_unit_id="{{$value->id}}" data-user_id="{{$value->id}}" > <i class="fa fa-eye" ></i></td>
                    </tr>
                    @endforeach
                    @else    
                    <tr><td colspan='5'>No records found</td></tr>
                    @endif
                </tbody>
                </table>    
            </div>
            <!-- Modal -->
        
            <script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}">
            </script>
            <script type="text/javascript" src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
           
        </div>
    </div>
    @endsection
@endguest
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

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
        var table =  $('#contact_list').DataTable({      
           "order": [[1, "desc"]],
           "columnDefs": [{ "orderable": false, "targets": [0,5] }]
        });

            // Add event listener for opening and closing details
    $('#contact_list tbody').on('click', 'td.details-control, td.details', function () {
      
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        ptd_id = 0;
         property_unit_id = $(this).data('property_unit_id'); 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');           
        }
        else {
            if(ptd_id!==""  && property_unit_id!==""){
                var property_data_url = '{{url('admin/property-user-data')}}/' + ptd_id + '/' + property_unit_id;
                    $.ajax({
                        type: "GET",
                        url: escap_space(property_data_url),
                        success: function (data) {
                           row.child( format(data) ).show();
                        }
                    });    
            }        
            tr.addClass('shown');
        }
    } );
    });

</script>

