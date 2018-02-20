@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
   @section('content')
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
				                <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                                                <div class="row">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-4">.col-sm-4</div>
                                                <div class="col-lg-4">.col-sm-4</div> 
                                              </div>
								
<!--									<div class="form-group">
										<label for="charge" class="col-sm-2 control-label">Amount</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="charge" id="charge"/>
										</div>
									</div>									
									<div class="form-group">
										<label for="charge" class="col-sm-2 control-label">Due Amount </label>
										<div class="col-sm-10">
											<input type="text" class="form-control" value="0.00" name="amount_due" id="amount_due"/>
										</div>
									</div>

									<div class="form-group">
										<label for="charge" class="col-sm-2 control-label">Total Amount</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="balance" id="balance"/>
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
										<div class="col-sm-offset-2 col-sm-10">
											<input class="btn btn-default my_btn" type="submit" value="Add"> 
											
										</div>
									</div>

									<div class="form-group">
										<label for="charge" class="col-sm-2 control-label">Remark</label>
										<div class="col-sm-10">
											<textarea id="remark" class="form-control" name="remark"></textarea>
										</div>
									</div>-->
									
									
							</form>
					</div>
		  		</div>
		  	</div>
		</div>
	
	<script>
          function escap_space(string){
                return string.replace(/\s/g,'');
            }
	$('#cancel_btn').on('click', function() {
		 window.location = escap_space('{{ url('admin/maintenance-fee') }}/{{$id}}/{{$user_id}}');	  
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
