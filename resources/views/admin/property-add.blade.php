@extends('admin-layouts.app')
@guest
@include('admin-layouts.error')                         
@else
@section('content')
@section('title', 'Add Taman/Condo')
<div id="page-wrapper" style="min-height: 140px;">    
    <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
        <div class="col-lg-12 no-pad">
            <h1 class="heading_text text-right"><span class="pull-left">Add Taman/Condo</span>
                <a href="{{ url('taman-condo') }}" class="btn btn-default my_btn">Back</a></h1>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-12 no-pad">
            <h4 class="new-tab"></h4>
            <!-- Add New property div -->		

            @if (Session::has('success'))
            <div class="alert alert-info">{{ Session::get('success') }}</div>
            @endif
            <div id="add_new_property" class="add_new_property">

                <form method="POST" action="{{action('AdminController@sendProperty')}}" id="property-add-form" class="conatct-form form-horizontal	property_form" enctype="multipart/form-data">


                    <input type="hidden" name="_token" id="token" value="<?= csrf_token(); ?>">

                    <div class="form-group">
                        <label for="township_name" class="col-sm-2 control-label">Property Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="township_name" id="township_name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country_name" class="col-sm-2 control-label">Country Name</label>
                        <div class="col-sm-10">
                            <select name="country_name" class="form-control" id="country_name">
                                @if(isset($country_array))
                                    @foreach ($country_array as $key => $value)
                                        <option {{  $key =="MY" ? 'selected' : '' }}  value="{{$value['name'].','. $key.','.$value['code']}}">{{$value['name']}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="state" class="col-sm-2 control-label">State</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="state" id="state"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="city_name" class="col-sm-2 control-label">City</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="city_name" id="city_name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="zipcode" class="col-sm-2 control-label">Postcode</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="zipcode" id="zipcode"/>
                        </div>	
                    </div>
                    <div class="form-group">
                        <label for="area" class="col-sm-2 control-label">Area</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="area_name" id="area_name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country_name" class="col-sm-2 control-label">Property Type</label>
                        <div class="col-sm-10">
                            <select name="property_type" class="form-control" id="property_type">
                                <option value="Condo">Select Property Type </option>
                                <option value="Apartment">Apartment</option>
                                <option value="Condominium">Condominium</option>
                                <option value="Serviced Apartment">Serviced Apartment</option>
                                <option value="Flat">Flat</option>
                                <option value="Townhouse">Townhouse</option>
                                <option value="Stratified Landed">Stratified Landed</option>
                                <option value="Landed">Landed</option>
                                <option value="SOHO/ SOVO">SOHO/SOVO</option>
                                <option value="Office Tower">Office Tower</option>
                                <option value="Stratified Commercial">Stratified Commercial</option>
                                <option value="Stratified Retail Lot">Stratified Retail Lot</option>
                                <option value="Stratified Shop Houses">Stratified Shop Houses</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" id="address" class="form-control" name="address"> 
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="property_management_contact" class="col-sm-2 control-label">Property Management Contact </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="property_management_contact" id="property_management_contact"/>
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="resident_committee_contact" class="col-sm-2 control-label">Resident Committee Contact</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="resident_committee_contact" id="resident_committee_contact"/>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Upload Image File:</label>
                        <div class="col-sm-10">
                            <img  src="" id="set_image" class="img_hide" width="100" height="100">
                            <input class="form-control" onchange="readURL(this);" id="image_file" name="image_file"  type="file">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input class="btn btn-default my_btn" type="submit" value="Add"> 

                        </div>
                    </div>	
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#cancel_btn').on('click', function () {
        window.location = '{{ url('taman - condo') }}';
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