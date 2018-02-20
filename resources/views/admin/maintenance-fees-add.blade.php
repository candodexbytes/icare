@extends('admin-layouts.app')
@guest
@include('admin-layouts.error')                         
@else
@section('content')
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<div id="page-wrapper" style="min-height: 140px;">    
    <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
        <div class="col-lg-12 no-pad">
            <h2 class="heading_text text-right"><span class="pull-left">Add Maintenance fee</span><button type="button" class="btn btn-cancel my_btn" name="cancel_btn" id="cancel_btn" value="Back">Back</button></h2>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-12 no-pad">
            <h4 class="new-tab"></h4>
            <!-- Add New maintenancefees div -->		

            @if (Session::has('success'))
            <div class="alert alert-info">{{ Session::get('success') }}</div>
            @endif
            <div id="add_new_maintenancefees" class="add_new_property">

                <form method="POST" action="{{action('AdminController@addMaintenanceFess')}}" id="maintenancefees-add-form" class="conatct-form form-horizontal	maintenancefees_form" enctype="multipart/form-data">

                    <input type="hidden" name="ptd_id" id="ptd_id" value="">
                    <input type="hidden" name="user_id" id="user_id" value="{{$user_id}}">
                    <input type="hidden" name="_token" id="token" value="<?= csrf_token(); ?>">
                    <div class="row">
                        <div class="col-lg-4 table-bordered">
                            <div>PTD: 100006</div>
                            <div>Block: A</div>
                            <div>Unit: 01-06</div>
                            <div>Atten: Mr Jason Kim</div>
                        </div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">

                            <div class="form-group">
                                <label class="col-lg-6" for="name">Invoice Date</label>
                                <div class="col-lg-6">
                                    <input  class="form-control hasDatepicker" name="invoice_date"  id="invoice_date"  type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-6" for="payment_due">Payment Due</label>
                                <div class="col-lg-6">
                                    <input  class="form-control hasDatepicker" name="payment_due"  id="payment_due"  type="text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                  <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
                                   <th>S. No</th>
                                <th>Product</th>
                                <th></th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                    <td><input type='checkbox' class='case'/></td>
                                     <td><span id='snum'>1.</span></td>
                                <td>  <input  class="form-control" name="title[]"  id="title"  type="text">

                                </td>
                                <td>  <input  class="form-control" name="desc[]"  id="desc"  type="text"></td>
                                <td>  <input  class="form-control" name="price[]"  id="price"  type="text"></td>
                                <td>  <input  class="form-control" name="quantity[]"  id="quantity"  type="text"></td>
                                <td> <input type="file" class="form-control " name="pdf_file[]" id="pdf_file"  style="display: none" /> <a href="" onclick='$("#pdf_file").click()' >add pdf</a> RM 120.00 <p class="btn" ><i class="fa fa-trash delete"></i></p></td>
                            </tr>

                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-lg-3 link">Edit Income Account</div>  
                        <div class="col-lg-3"></div>
                        <div class="col-lg-3">
                                 <div class="form-group">
                                <label class="col-lg-2 text-right" for="name">Tax</label>
                                 <div class="col-lg-10">
                                    <select class="form-control"  name="tax" id="tax">
                                        <option value="" >Select a tax</option>
                                        <option value="5" >5%</option>
                                        <option value="10" >10%</option>
                                        <option value="15" >15%</option>
                                        <option value="20" >20%</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-lg-3 text-right">-</div>
                    </div> 
                    <br/>
                    <div class="row">
                        <div class="col-lg-12  well well-sm text-center"><a  class='addmore' ><i class="fa fa-plus"></i>Add an item</a></div>  
                    </div> 
                    
                   
                    <div class="row">
                        <div class="col-lg-8"></div>  
                          <div class="col-lg-2">Subtotal</div>  
                          <div class="col-lg-2"><p>RM120.00</p></div>  
                    </div>  
                    
                <div class="row">
                  <div class="col-lg-5"></div>   
                    <div class="col-lg-5">  
                      <div class="form-group">
                                <label class="col-lg-6 text-right" for="name">Total</label>
                                <div class="col-lg-6">
                                    <select class="form-control"  name="" id="">
                                        <option value="" >MVR(RM)-Malaysian Ring</option>
                                        <option value="" >MVR(RM)-Malaysian Ring</option>
                                    </select>
                                </div>
                            </div>
                    </div>   
                      <div class="col-lg-2"></div>   
                    </div>  
                    <div class="text-right">
                          <button type="button" class="btn btn-primary">Send Invoice</button>
                    </div>
                    <!--									<div class="form-group">
                                                                                                    <label for="charge" class="col-sm-2 control-label">Amount</label>
                                                                                                    <div class="col-sm-10">
                                                                                                            <input type="text" class="form-control calculate_amount" name="charge"  id="charge"/>
                                                                                                    </div>
                                                                                            </div>
                                                                                            
                                                                                            <div class="form-group">
                                                                                                    <label for="charge" class="col-sm-2 control-label">Due Amount </label>
                                                                                                    <div class="col-sm-10">
                                                                                                            <input type="text" value="0.00" class="form-control calculate_amount" name="amount_due" id="amount_due"/>
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                    <label for="charge" class="col-sm-2 control-label">Total Amount</label>
                                                                                                    <div class="col-sm-10">
                                                                                                            <input type="text" value="0.00" class="form-control" name="balance" id="balance"/>
                                                                                                    </div>
                                                                                            </div>
                                                                                            
                                                                                            <div class="form-group">
                                                                                                    <label for="country_name" class="col-sm-2 control-label">Invoice Month</label>
                                                                                                    <div class="col-sm-10">
                                                                                                            <select name="invoice_month" class="form-control" id="invoice_month">
                                                                                                                    <option value="jan">January</option>
                                                                                                                    <option value="feb">February</option>
                                                                                                                    <option value="mar">March</option>
                                                                                                                    <option value="apr">April</option>
                                                                                                                    <option value="may">May</option>
                                                                                                                    <option value="jun">June</option>
                                                                                                                    <option value="jul">Jully</option>
                                                                                                                    <option value="aug">August</option>
                                                                                                                    <option value="sep">September</option>
                                                                                                                    <option value="oct">October</option>
                                                                                                                    <option value="nov">November</option>
                                                                                                                    <option value="dec">December</option>
                                                                                                            </select>
                                                                                                    </div>
                                                                                            </div>
                                                                                    <div class="form-group">
                                                                                            <label for="charge" class="col-sm-2 control-label">Pdf File</label>
                                                                                            <div class="col-sm-10">
                                                                                                    <input type="file" class="form-control " name="pdf_file" id="pdf_file"  /></div>
                                                                                    </div>
                                                                                            
                                                                                            <div class="form-group">
                                                                                                    <label for="charge" class="col-sm-2 control-label">Remark</label>
                                                                                                    <div class="col-sm-10">
                                                                                                            <textarea id="remark" class="form-control" name="remark"></textarea>
                                                                                                    </div>
                                                                                            </div>
                                                                                    <div class="form-group">
                                                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                                                    <input class="btn btn-default my_btn" type="submit" value="Add"> 
                                                                                                    
                                                                                            </div>
                                                                                    </div>	-->
                </form>
            </div>
        </div>
    </div>
</div>
  
<script>
     $(function() {
      //   alert();
          
          });
       $(document).ready(function(){
             $("#invoice_date").datepicker();
//            $("#payment_due").datepicker({ minDate: 0,dateFormat: 'yy-mm-dd'});
$(".delete").on('click', function() {
	$('.case:checkbox:checked').parents("tr").remove();
    $('.check_all').prop("checked", false); 
	check();

});
var i=2;
$(".addmore").on('click',function(){
	count=$('table tr').length;
    var data="<tr><td><input type='checkbox' class='case'/></td><td><span id='snum"+i+"'>"+count+".</span></td>";
    data +="<td><input class='form-control' type='text' id='title"+i+"' name='title[]'/></td> <td><input class='form-control' type='text' id='desc"+i+"' name='desc[]'/></td><td><input class='form-control' type='text' id='quantity"+i+"' name='quantity[]'/></td><td><input class='form-control' type='text' id='price"+i+"' name='price[]'/></td><td><input type='file' class='form-control' name='pdf_file[]' id='pdf_file"+i+"'  style='display: none' /> <a href=''  >add pdf</a> RM 120.00 </td></tr>";
	$('table').append(data);
	i++;
});

function select_all() {
	$('input[class=case]:checkbox').each(function(){ 
		if($('input[class=check_all]:checkbox:checked').length == 0){ 
			$(this).prop("checked", false); 
		} else {
			$(this).prop("checked", true); 
		} 
	});
}

function check(){
	obj=$('table tr').find('span');
	$.each( obj, function( key, value ) {
	id=value.id;
	$('#'+id).html(key+1);
	});
	}
});
    $('#cancel_btn').on('click', function () {
        window.location = '{{ url('admin / maintenance - fee') }}/{{$id}}/{{$user_id}}';
    });

    $('.calculate_amount').on('change', function () {
        var charge = $("#charge").val();
        var amount_due = $("#amount_due").val();

        if (amount_due != '') {
            $("#balance").val(parseInt(charge) + parseInt(amount_due));
        } else {
            $("#balance").val(parseInt(amount_due));
        }

    });

    function readURL(input) {
        $('#set_image').show();
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#set_image')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
@endguest