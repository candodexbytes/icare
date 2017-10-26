@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
   @section('content')
		<div class="container">

	    <h2>Admin Add New Property</h2>

		</div>


	  <div class="container">
		<h4 class="new-tab"></h4>
			<!-- Add New property div -->		
			
    		@if (Session::has('success'))
			   <div class="alert alert-info">{{ Session::get('success') }}</div>
			@endif
			<div id="add_new_property">
							<p><small>Fields denoted with an asterisk (*) are mandatory</small></p>
				<form method="POST" action="{{action('AdminController@sendProperty')}}" id="property-add-form" class="conatct-form	property_form" enctype="multipart/form-data">
				
	           
	                <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
					
						<p>
							<label for="township_name">Township Name</label><br>
							<input type="text"  name="township_name" id="township_name"/>
						</p>
						<p>
							<label for="country_name">Country Name</label><br>
							<select name="country_name" id="country_name">
								<option value="Malaysia">Malaysia</option>
							</select>
						</p>
						<p>
							<label for="city_name">City Name</label><br>
							<input type="text"  name="city_name" id="city_name"/>
						</p>
						<p>
							<label for="zipcode">Zipcode</label><br>
							<input type="text"  name="zipcode" id="zipcode"/>
						</p>
						<p>
							<label for="address">Address</label><br>
							<textarea id="address" name="address"></textarea>
						</p>
						
						<img  src="" id="set_image" class="img_hide" width="100" height="100">
						<p>
							<label>Upload Image File:</label><br/>
							
			                <input class="form-control" onchange="readURL(this);" id="image_file" name="image_file" type="file">
			                
						</p>
					<p>
						<input class="btn btn-default" type="submit" value="Add"> 
						<button type="button" class="btn btn-cancel" name="cancel_btn" id="cancel_btn" value="Cancel">Cancel</button>
					</p>	
				</form>
			</div>
	  </div>
	
	<script>
	$('#cancel_btn').on('click', function() {
		 window.location = '{{ url('property') }}';	  
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