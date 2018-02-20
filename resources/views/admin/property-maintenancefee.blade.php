@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <?php  $type = Auth::user()->type; ?>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

        <div id="page-wrapper" style="min-height: 140px;">    
            <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">    
                <div class="col-lg-12 no-pad">
                    <h1 class="heading_text text-right"><span class="pull-left">Maintenance Fee</span><a href="{{ url('admin/all-user') }}" class="btn back_btn btn-default my_btn">Back</a>@if($type == 5)<a href="{{ url('admin/add-maintenance-fees') }}/{{$id}}/{{$user_id}}" class="btn btn-default my_btn">New Maintenance Fees</a>@endif</h1>
                </div>
                <div class="main-div">
                    <table id="user_list" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr class="list_head">
                                <th>Month</th>
                                <th>Date</th>
                                <th>Amount</th>                               
                                <th>Due Amount</th>
                                 <th>Total Amount</th>
                                <th>Payment Status</th>                               
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="the_list">
                            @if(isset($data))
                                @foreach ($data as $value)
                                    <?php 
                                        if($value->payment_status == 0){
                                            $set_status = '<span class="label label-default">Pending</span>';
                                        }else{
                                            $set_status = '<span class="label label-info">Paid</span>';
                                        }
                                    ?>
                                <tr>
                                    <td  data-id="{{$value->id}}"  data-ptd_id="{{$value->ptd_id}}" data-toggle="modal"  name="modal_td" data-target="#transactionModal" ><u>{{ $value->invoice_month}}</u></td>
                                    <td >
                                    <span class="hidden">{{$value->created_date}}</span>
                                        {{date("d M Y g:i:A",strtotime($value->created_date))}}</td>
                                    <td>{{$value->pay_amount}}</td>                                    
                                    <td>{{$value->previous_due}}</td>
                                    <td>{{$value->total_amount}}</td>
                                    <td>{!! $set_status !!}</td>
                                    
                                    <td>@if($type == 5)<span data-invoicemonth="{{$value->invoice_month}}" data-payamount="{{$value->pay_amount}}" data-totalamount="{{$value->total_amount}}" data-previousdue="{{$value->previous_due}}" data-id="{{$value->id}}" data-pdfname="{{$value->pdfname}}" data-paymentstatus="{{$value->payment_status}}" data-remarks="{{$value->remarks}}" class="edit_btn"><i  class="fa fa-pencil" aria-hidden="true"></i></span> / <span data-id="{{$value->id}}" class="delete_btn" ><i class="fa fa-trash-o" aria-hidden="true"></i></span> / @endif<a target="_blank" href="{{$value->pdf_url}}"> View Pdf</a> </td>
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
		
		
		<!-- transaction details view Modal -->
  <div class="modal fade" id="transactionModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Transaction Details</h4>
		  </div>
        <div class="modal-body clearfix" id="transaction-modal" >
        </div>
	
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
         <!-- Modal -->
            <div id="editmodal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit <span id="title_set">Maintenance Fee</span> </h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" class="conatct-form form-horizontal" action="{{action('AdminController@updateMaintenanceFees')}}" id="update_maintenancefees_form" enctype="multipart/form-data">
                                <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                                <input type="hidden" name="id" id="id" value="">
                                <input type="hidden" name="pdf_name" id="pdf_name" value="">
                                <div class="form-group">
                                        <label for="charge" class="col-sm-2 control-label">Charge</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="charge" id="set_charge"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="charge" class="col-sm-2 control-label">Balance</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="balance" id="set_balance"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="charge" class="col-sm-2 control-label">Amount Due</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="amount_due" id="set_amount_due"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="charge" class="col-sm-2 control-label">Remark</label>
                                        <div class="col-sm-10">
                                            <textarea id="set_remark" class="form-control" name="remark"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="country_name" class="col-sm-2 control-label">Invoice Month</label>
                                        <div class="col-sm-10">
                                            <select name="payment_status" class="form-control" id="set_payment_status">
                                                <option id="status_0" value="0">Pending</option>
                                                <option id="status_1" value="1">Paid</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="country_name" class="col-sm-2 control-label">Payment Status</label>
                                        <div class="col-sm-10">
                                            <select name="invoice_month" class="form-control" id="set_invoice_month">
                                                <option id="status_jan"  value="jan">January</option>
                                                <option id="status_feb" value="feb">February</option>
                                                <option id="status_mar" value="mar">March</option>
                                                <option id="status_apr" value="apr">April</option>
                                                <option id="status_may" value="may">May</option>
                                                <option id="status_jun" value="jun">June</option>
                                                <option id="status_jul" value="jul">Jully</option>
                                                <option id="status_aug" value="aug">August</option>
                                                <option id="status_sep" value="sep">September</option>
                                                <option id="status_oct" value="oct">October</option>
                                                <option id="status_nov" value="nov">November</option>
                                                <option id="status_dec" value="dec">December</option>
                                            </select>
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label for="charge" class="col-sm-2 control-label">Pdf File</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="pdf_file" id="set_pdf_file" accept="application/pdf" /> 
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                  
                                  <div class="col-sm-offset-2 col-sm-10">
                                      <input type="submit" class="btn btn-default my_btn" value="Update">
                                  </div>
                                </div>
                               
                            </form>
                        </div>  
                    </div>
                </div>
            </div>
        <script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}">
        </script>
        <script type="text/javascript" src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#user_list').DataTable( {
                    responsive: true
                } );
            } );
            $('.edit_btn').click(function(){
                    var id = $(this).data('id');
                    var charge = $(this).data('payamount');
                    var balance = $(this).data('totalamount');
                    var amount_due = $(this).data('previousdue');
                    
                    var paymentstatus = $(this).data('paymentstatus');
                    var remarks = $(this).data('remarks');
                    var pdfname = $(this).data('pdfname');
                    var invoicemonth = $(this).data('invoicemonth');
                    
                    $('#id').val(id);
                    
                    $('#status_'+paymentstatus).prop('selected', true);
                    $('#status_'+invoicemonth).prop('selected', true);
                    $('#set_charge').val(charge);
                    $('#set_balance').val(balance);
                    $('#set_amount_due').val(amount_due);
                    $('#set_remark').val(remarks);
                    $('#pdf_name').val(pdfname);

                    $('#editmodal').modal('show');
                          
                    
                });
            $("td[name = 'modal_td']").click(function(){
                
                  ///   $('#transaction-modal').html('');
                    var maintenance_id=$(this).attr('data-id');
                    var ptd_id=$(this).attr('data-ptd_id');
                    var url = '{{url('admin/gettransactiondata')}}/'+maintenance_id+'/'+encodeURIComponent(ptd_id);  
                    $.ajax({
                      type: "GET",
                      url : url,
                      success : function(data){
                    $('#transaction-modal').html(data);

                      }

                      });   
                      });
            $('.delete_btn').click(function(){
                   var id = $(this).data('id');
                      var x = confirm("Are you sure you want to delete?");
                    if (x){
                        //  return true;
                           var del_url = '{{url('admin/deletemaintenancefee')}}/'+id;  
                    $.ajax({
                      type: "GET",
                      url : del_url,
                      success : function(data){
                          if(data.response==1){
                              location.reload(true);
                          }
                      }

                      });  
                      }
                       else{
                       return false;
                   }
              
            });
        </script>
    @endsection
@endguest