@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <?php  $type = Auth::user()->type; ?>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">
        <div id="page-wrapper" style="min-height: 140px;"> 
            <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <form id="mnt_details" action="#">
                <div class="col-lg-12 no-pad">
                    <h1 class="heading_text text-right"><span class="pull-left">Add Unit</span><a href="{{ url('admin/maintenance') }}" class="btn btn-default  my_btn">Back</a></h1>
                </div>
                <input type="hidden" name="unit_id" id="unit_id" value="{{$id}}">
                <input type="hidden" name="ptd_id" id="ptd_id" value="{{$ptd_id}}">
                <div class="col-sm-6">
                    <div>
                        <b>PTD: {{$unitData->ptd_id}}</b><br>
                        <b>Block: {{$unitData->block_number}}</b><br>
                        <b>Unit: {{$unitData->unit_number}}</b>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Invoice Date</label>
                        <div class="col-xs-5 date">
                            <div class="input-group input-append date" id="datePicker1">
                                <input id="date1" type="text" class="form-control" name="date1" />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Payment Date</label>
                        <div class="col-xs-5 date">
                            <div class="input-group input-append date" id="datePicker2">
                                <input id="date2" type="text" class="form-control" name="date2" />
                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div id="list">
                        <ul class="nav nav-tabs" role="tablist">
                            <span class="hidden-xs text-capitalize">Edit Columns</span>
                        </ul>
                    </div>
                </div>

                <div class="crcform">
                  
                         <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                        <table class="table table-bordered" id="dynamic_field">
                            <tr class="product_details" id="row1">
                                <td>
                                    <input id="title1" type="text" required autocomplete="off" name="title[]" value="Maintenance fee"/>
                                    </td>
                                <td>
                                       <input id="desc1" type="text"  autocomplete="off" name="desc[]" value="" />
                                   </td>
                                <td class="qty">
                                        <input id="qty1" type="text"  min="1" step="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"  autocomplete="off" value="1"  name="qty[]"/>
                                 </td>
                                 <td class="amount">
                                    <input id="amount1" type="text" oninput="this.value=this.value.replace(/[^0-9]/g,'');"  min="1" step="1" pattern="\d*"  autocomplete="off" value="0"  name="amount[]"/>
                                    </td>
                                <td class="subtotal"><input id="subtotal1" type="text" class="input_subtotal" value="0"  name="subtotal[]"></td>
                                <td></td>

                            </tr>
                        </table>
                        <table class="table table-bordered" style="width: 300px;" >
                            <tr class="">
                                <td colspan="1"> Subtotal</td>                    
                                <td class="total_subtotal"><input type="text" id="total_subtotal" value="0"  name="total_subtotal"></td>
                            </tr>
                            
                            <tr class="">
                                <td colspan="1"> Tax (%)<input type="text" id="tax_pre" style="width: 80%" value="0.00"  name="tax_pre"></td> 
                                <td class="tax_amount"><input type="text" id="tax_amount" value="0"  name="tax_amount"></td>
                            </tr>
                            <tr class="">
                                <td colspan="1"> Subtotal</td>                    
                                <td class="grand_total"><input type="text" id="grand_total" value="0"  name="grand_total"></td> 
                            </tr>
                        </table>
                        <input type="button" name="submit" id="submit"  class="btn btn-info" value="Submit" />
                   
                </div>
                 </form>
                <script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
                <script type="text/javascript" src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
                <script type="text/javascript">
                       $(document).ready(function() {
                            $('#datePicker1').datepicker({
                                dateFormat: 'dd/mm/yy',
                                minDate: 0,
                                autoclose: true
                            }).on('changeDate', function(e) {
                                
                            });

                            $('#datePicker2').datepicker({
                                dateFormat: 'dd/mm/yy',
                                minDate: 0,
                                autoclose: true
                            }).on('changeDate', function(e) {
                                
                            })

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
                     $('#tax_amount').val(tax_amount);
                     totalAmount();
                });



                            var i = 1;
            $('#add').click(function(){
                i++;
                $('#dynamic_field').append('<tr  class="product_details" id="row'+i+'"> <td><input id="title'+i+'" type="text" required autocomplete="off" name="title[]"/></td><td><input id="desc'+i+'" type="text" autocomplete="off" name="desc[]"/></td><td  id="qty'+i+'" class="qty"><input id="qty'+i+'" min="1" step="1" type="text" autocomplete="off" name="qty[]" value="0"/></td><td class="amount"><input id="amount'+i+'" min="1" step="1" type="text"  autocomplete="off"  value="0"  name="amount[]"/></td><td class="subtotal"><input id="subtotal'+i+'" type="text" class="input_subtotal"   value="0" name="subtotal[]"></td><td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
            });

            $(document).on('click','.btn_remove', function(){
                var button_id = $(this).attr("id");
                $("#row"+button_id+"").remove();
            });

            $(document).ready(function() {
              
              $('#dynamic_field').on('keyup', '.amount, .qty', function() {
                    var pr_price = $(this).closest('.product_details').find('.amount input').val();
                    var qty = $(this).closest('.product_details').find('.qty input').val();
                    var sub_total = pr_price * qty;
                    $(this).closest('.product_details').find('.subtotal input').val(sub_total);

                    subTotal();
                    totalAmount();
              });

            });

                $('#submit').click(function(){
                   /* var invoiceDate = $('#date1').val();
                    var paymentDate = $('#date2').val();
                    var unit_id = $('#unit_id').val();
                    var ptd_id = $('#ptd_id').val();*/
                    var formData = $("#mnt_details").serializeArray();

                    var dataArray = {data: formData};
                    
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        async: true,
                        url: "http://localhost/condo/condo-management/admin/postInvoiceData",
                        type: "POST",
                        data: dataArray,
                        dataType : 'json',
                        success:function(rt)
                        {
                            //$('#internship_details')[0].reset();
                        }
                    });
                });
            });
                </script>
            </div>
        </div>
    @endsection
@endguest