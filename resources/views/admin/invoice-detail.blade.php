@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
@section('title', 'Add Maintenance ')
@section('content')
    <?php  $type = Auth::user()->type; ?>

        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">
        <center>                 
            <div id="loader-model" class="loader-model" style="display: block;"></div>            
        </center>
        <div id="page-wrapper" class="invoice-detail" style="min-height: 140px;"> 
            <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
                <div class="col-lg-12 no-pad">
                    <h1 class="heading_text text-right"><span class="pull-left">Add Maintenance</span>
                        <a href="{{ url('admin/maintenance') }}" class="btn btn-default  my_btn">Back</a></h1>
                </div>
                <div>
          <form method="POST"  action="{{action('AdminController@addMaintenance')}}" id="maintenancefees-add-form" class="conatct-form form-horizontal   maintenancefees_form" enctype="multipart/form-data"  onSubmit="document.getElementById('submit_invoice').disabled=true;">
              <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
              <input type="hidden" name="unit_id" value="{{ $id }}">
            
               <div class="col-lg-12 no-pad">
                    <div class="col-sm-6">
                        <div class="block">
                            <p><strong>PTD No. : </strong>{{$unitData->ptd_id}}</p>
                            <p><strong>Block: </strong>{{$unitData->block_number}}</p>
                            <p><strong>Unit: </strong>{{$unitData->unit_number}}</p>
                            <p><strong>Address: </strong>{{$unitData->address}}</p>
                            <p><strong>Resident: </strong> @if($unit_user) @foreach ($unit_user as $user) {{ $user->name }},   @endforeach  @else <i style="color: red;"> At least one resident is required </i> @endif</p>
                        </div>
                       
                    </div>
                    <div class="col-sm-6 col-sm-6">
                        <div class="right_block">
                        <div class="form-group">
                            <label class="col-xs-4 col-sm-4 control-label">Invoice Date</label>
                            <div class="col-xs-8 col-sm-8 date">
                                <div class="input-group input-append date" id="datePicker1">
                                    <input type="text" class="form-control" name="invoice_date" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-xs-4 col-sm-4 control-label">Due Date</label>
                            <div class="col-xs-8 col-sm-8 date">
                                <div class="input-group input-append date" id="datePicker2">
                                    <input type="text" class="form-control" name="due_due" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="form-group">
                            <label class="col-xs-4 col-sm-4 control-label">Attachment</label>
                            <div class="col-xs-8 col-sm-8 date">
                                <div class="input-group input-append date">
                                    <input type="file" class="form-control" name="pdf_file" />
                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-paperclip"></span></span>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
                  <div class="add_item">
                         <a href="javascript:void(0);" id='add'>Add Item </a> 
                  </div>
                     <div class="col-lg-12 no-pad">
                        <div class="new_tbl">
                            <table id="user_list2" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="list_head">
                                        <th>Title</th>
                                        <th></th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="the_list">
                                    <tr class="product_details">
                                        <td> 
                                            <input type="text" id="title" class="form-control" placeholder="mantainence Free"  required autocomplete="off" name="title[]" value="Maintenance fee">
                                        </td>
                                        <td>
                                            <input type="text" id="desc" required autocomplete="off" name="desc[]" value="" class="form-control" placeholder="January 2018">
                                        </td>
                                        <td class="qty">                                             
                                            <input type="text" id="qty" required class="form-control"  placeholder="1"  min="1" step="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"  autocomplete="off" value="1"  name="qty[]">                                          
                                        </td>
                                        <td class="amount">
                                            <input class="form-control" id="amount" required type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');"  min="1" step="1" pattern="\d*"  autocomplete="off" value="0"  name="amount[]" placeholder="120.0">                                           
                                        </td>
                                        <td class="subtotal">                                            
                                                 <input type="text" class="form-control input_subtotal" id="input_subtotal" value="0"  name="subtotal[]" readonly="readonly">                                             
                                        </td>
                                    </tr> 
                                    
                                    </tbody>
                                    </table>
                               
                                <table class="maintenance_second_table"> 
                                 
                                <tbody class="">
                                   <tr>
                                        <td> </td>
                                        <td> </td>
                                        <td colspan="2"><strong>Sub Total</strong> </td>
                                       
                                        <td>  <input type="text" class="form-control put" id="total_subtotal" name="total_subtotal" placeholder="00.0" value="0.0" readonly="readonly"></td>
                                    </tr>                               
                                   <tr>
                                        <td> </td>
                                        <td> </td>
                                        <td> <strong>GST(%) </strong> </td>
                                        <td class="extra"> <input type="text" id="tax_pre" style="width: 50%" value="0.00"  name="tax_pre"></td>
                                        <td><input  type="text" class="form-control put" id="tax_amount" name="tax_amount" placeholder="00.0" value="0.0" min="0" readonly="readonly">
                                        </td>
                                       
                                    </tr>                                 
                                     <tr>
                                        <td> </td>
                                        <td> </td>
                                        <td colspan="2"><strong>Total</strong> </td>
                                      
                                        <td>  <input type="text" class="form-control put" id="grand_total" name="grand_total" placeholder="00.0" value="0.0" readonly="readonly"></td>
                                    </tr>
                                    <tr>
                                       <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td colspan="2" class="text-right">
                                             <button type="submit" name="submit" id="submit_invoice" class="btn btn-primary">Send Invoice</button>
                                         </td>
                                    </tr>
                                </tbody>
                            </table> 
                        </div>
                      </div>
                  </form>
                  </div>
                <script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
                <script type="text/javascript" src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
             <script type="text/javascript">
               $(document).ready(function() {
                $('#loader-model').hide();
                    setTimeout(function() {
                        $('#user_list2').DataTable({  
                                    "retrieve": false,  
                                    "paging":   false,
                                    "ordering": false,
                                    "info":     false,
                                    "searching": false,
                                    "columnDefs": [{ "orderable": false, "targets": [0,1,2,3,4] }]
                                    });
                    }, 1000);

                    var date = new Date();
                    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

                    $('#datePicker1').datepicker({
                        dateFormat: 'dd/mm/yy',
                        minDate: 0,
                        autoclose: true,
                        todayHighlight: true,
                        startDate: today  
                    }).on('changeDate', function(e) {
                        console.log(e);
                        //$('#datepicker2').datepicker('setDate', today);
                    });

                    $('#datePicker2').datepicker({
                        dateFormat: 'dd/mm/yy',
                        minDate: 0,
                        autoclose: true,
                        todayHighlight: true,
                        startDate: today 
                    }).on('changeDate', function(e) {
                        
                    });
               }); 
        </script>
        <script>
            $(document).ready(function(){
             function subTotal(){
                var arr = $('.input_subtotal');
                var total = 0;
                for(var i = 0 ; i < arr.length ; i++ ){
                    if(parseFloat(arr[i].value))
                        total += parseFloat(arr[i].value);
                }
                document.getElementById('total_subtotal').value = total;                
            }

            function totalAmount(){
                var total_subtotal = parseFloat($('#total_subtotal').val());
                var tax_amount = parseFloat($('#tax_amount').val());
                document.getElementById('grand_total').value = total_subtotal + tax_amount;                
            }

            $("#tax_pre").keyup(function(){
                 var total_subtotal = parseFloat($('#total_subtotal').val());
                 var tax_pre = parseFloat($('#tax_pre').val());
                 var tax_amount = total_subtotal*tax_pre/100;
                 if(tax_pre!='' && tax_pre > 0){
                     $('#tax_amount').val(tax_amount);
                     totalAmount();
                 }
            });

            var i = 1;
            $('#add').click(function(){
                i++;
                $('#the_list').append('<tr  class="product_details" id="row'+i+'"> <td><input type="text" required class="form-control" autocomplete="off" placeholder="Enter title" name="title[]"/></td><td><input type="text" autocomplete="off"  placeholder="Enter description" class="form-control" required name="desc[]"/></td><td class="qty"><input min="1" step="1" type="text" class="form-control" required autocomplete="off" name="qty[]" value="1"/></td><td class="amount"><input class="form-control" required min="0" step="1" type="text"  autocomplete="off"  value="0"  name="amount[]"/></td><td class="subtotal"><input type="text" class="input_subtotal form-control"   value="0" name="subtotal[]"></td><td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
            });

            $(document).on('click','.btn_remove', function(){
                var button_id = $(this).attr("id");
                $("#row"+button_id+"").remove();
            });

            $(document).ready(function() {
              
              $('#the_list').on('keyup', '.amount, .qty', function() {
                    var pr_price = $(this).closest('.product_details').find('.amount input').val();
                    var qty = $(this).closest('.product_details').find('.qty input').val();
                    var sub_total = pr_price * qty;
                    $(this).closest('.product_details').find('.subtotal input').val(sub_total);

                    subTotal();
                    totalAmount();
              });

            });


            $(document).on('click','.submit_invoice', function(){
                if ($('#datePicker1').val() != '' && $('#datePicker2').val() != '' && $('#title').val() != '' && $('#title').val() != '' &&
                    $('#desc').val() != '' && $('#qty').val() != '' && $('#amount').val() != '' &&
                    $('#input_subtotal').val() != '' && $('#total_subtotal').val() != '' &&
                    $('#tax_amount').val() != '' && $('#grand_total').val() != '') {
                        $('#loader-model').show();
                }
            });
        });

        $("input").on("change paste keyup", function() {
             $('#submit_invoice').prop('disabled', false);
        });


    </script>
    </div>
</div>

@if(!$unit_user)
<script type="text/javascript">
    $(document).ready(function () {
        $('input').prop('disabled', true);  
       $('#submit_invoice').prop('disabled', true); 
    });
 </script>     
@endif

    @endsection
@endguest

