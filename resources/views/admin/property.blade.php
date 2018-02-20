@extends('admin-layouts.app')
@section('title',"ICARES | Property")
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <?php  $type = Auth::user()->type; ?>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

    <div id="page-wrapper"  style="min-height: 140px;">    
        <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">    
        
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Taman/Condo</span>@if($type == 0)<a href="{{ url('add-taman-condo') }}" class="btn btn-default my_btn">Add Taman/Condo</a>@endif</h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="clearfix">
                   @if(Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                    @endif
            </div> 
            <div class="main-div">               
                <div class="success_msg" style="height: 30px;clear: both;"></div>
                <table id="property_list" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr class="list_head">
                        
                            <th>Image</th>
                            <th>Property Name</th>
                             <th>State</th>
                            <th>City</th>
                           
                             <th>Type</th>
                            <th>Address</th>
                            <th>Property<br>Management<br>Contact</th>
                            <th>Resident<br>Committee<br>Contact</th>
                             @if($type == 0)<th>ManagementCompany /<br> Resident Committee</th>@endif
                            @if($type == 0)<th>Action</th>@endif
                           

                        </tr>
                    </thead>
                    <tbody id="the_list">
                        @if(isset($data))
                            @foreach ($data as $value)
                                <?php $ptd_genrate = str_replace(' ', '-', $value->ptd_id); ?>
                                <tr id="property_{{$value->id}}">
                                
                                     <td ><img src="{{$value->image}}" style="max-width: none;" width="60" height="60" ></td>
                                 <td ><a href="set-property/{{$value->id}}/menu">{{$value->township_name}}</a>
                                    </td>
                                    <td >{{$value->state}}</td>
                                    <td >{{$value->city_name}}</td>                                  
                                      <td>{{$value->property_type}}</td>
                                    <td class="address_break">{!!$value->address!!}</td>
                                    <td class="property_management_contact">{{$value->property_management_contact}}</td>
                                    <td class="resident_committee_contact">{{$value->resident_committee_contact}}</td>
                                      @if($type == 0)
                                     <td class="text-center"><a href="{{ url('set-property') }}/{{$value->id}}/manage"><span data-id="{{$value->id}}" >Manage</span></a> </td>@endif

                                    @if($type == 0)<td ><span data-country="{{ $value->country.','.$value->country_code.','.$value->country_phone_code }}" data-zipcode="{{$value->zipcode}}" data-township="{{$value->township_name}}" data-id="{{$value->id}}" data-image="{{$value->image}}" data-state="{{$value->state}}" data-cityname="{{$value->city_name}}" data-address="{{$value->address}}" data-area_name="{{$value->area_name}}" data-property_type="{{$value->property_type}}" data-property_management_contact="{{$value->property_management_contact}}" data-resident_committee_contact="{{$value->resident_committee_contact}}" class="edit_btn"><i  class="fa fa-pencil" aria-hidden="true"></i></span> / <span data-id="{{$value->id}}" class="delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i></span> </td>@endif

                                     
                                </tr>
                            @endforeach
                        @else    
                            <tr><td colspan='2'>No records found</td></tr>
                        @endif
                    </tbody>
                </table>  
                 
            </div>
            <!-- Modal -->
            <div id="editmodal" class="modal fade" role="dialog">
                <div class="modal-dialog detail-body">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header middle">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit <span id="title_set">Property</span> </h4>
                        </div>
                        <div class="modal-body pad1">
                            <form method="post" class="conatct-form form-horizontal" action="{{action('AdminController@updateProperty')}}" id="update_property_form" enctype="multipart/form-data">
                                <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                                <input type="hidden" name="id" id="id" value="">
                                
                                <div class="form-group">
                                        <label class="col-sm-4 control-label" for="township_name"><strong>Property Name</strong> </label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" name="township_name" id="township_name" value=""/>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="country_name"><strong>Country Name</strong> </label>
                                    <div class="col-sm-8">
                                         <select name="country_name" class="form-control" id="country_name">
                                            @if(isset($country))
                                                @foreach ($country as $key => $value)
                                                    <option value="{{$value['name'].','.$key.','.$value['code']}}">{{$value['name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
								<div class="form-group">
                                  <label class="col-sm-4 control-label"><strong>State</strong> </label>
                                  <div class="col-sm-8">
                                      <input type="text" class="form-control" name="state" id="state" value="">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-4 control-label"><strong>City</strong> </label>
                                  <div class="col-sm-8">
                                      <input type="text" class="form-control" name="city_name" id="city_name" value="">
                                  </div>
                                </div>
								
                                <div class="form-group">
                                        <label class="col-sm-4 control-label" for="Postcode"><strong>Postcode</strong> </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control"  name="zipcode" id="zipcode" value="" />
                                        </div>
                                </div>
								<div class="form-group">
                                  <label class="col-sm-4 control-label"><strong>Area</strong> </label>
                                  <div class="col-sm-8">
                                      <input type="text" class="form-control" name="area_name" id="area_name" value="">
                                  </div>
                                </div>
								 <div class="form-group">
                                    <label class="col-sm-4 control-label" for="property_type"><strong>Property Type</strong> </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="property_type" id="property_type">
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
                                  <label class="col-sm-4 control-label"><strong>Address </strong> </label>
                                  <div class="col-sm-8">
                                      <input type='text' class="form-control" name="address" id="address" >
                                  </div>
                                  
                                </div>
								<div class="form-group">
                                  <label class="col-sm-4 control-label"><strong>Property Management Contact</strong> </label>
                                  <div class="col-sm-8">
                                      <input type="text" class="form-control" name="property_management_contact" id="property_management_contact" value="">
                                  </div>
                                </div>
								<div class="form-group">
                                  <label class="col-sm-4 control-label"><strong>Resident Committee Contact</strong> </label>
                                  <div class="col-sm-8">
                                      <input type="text" class="form-control" name="resident_committee_contact" id="resident_committee_contact" value="">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-4 control-label"><strong>Image</strong> </label>
                                    <div class="col-sm-8">
                                        <img src="" id="set_image" width="100" height="100">
                                        <input class="form-control" onchange="readURL(this);" id="image_file" name="image_file" type="file">
                                    </div>
                                </div>
                                <div class="form-group">
                                  
                                  <div class="col-sm-offset-10 col-sm-2">
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
                    $('#property_list').DataTable( {
                        'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': [-1,-2] /* 1st & 2nd , start by the right */
                    }]     
                    } );
                } );
            </script>
            <script type="text/javascript">
                $('.delete_btn').click(function(){
                    var id = $(this).data('id');
                    var url = '{{url('deleteproperty')}}/'+id;
                    
                    var r = confirm("Confirm delete this package!");
                    if (r == true) {
                       $.ajax({
                            type: "GET",
                            url : url,
                            success : function(data){
                                if(data.response == 1){
                                  $( '#property_'+id ).remove();
                                    $('.success_msg').html('Property remove successfully');
                                    setTimeout(function() {
                                        $('.success_msg').fadeOut('slow');
                                    }, 2000);
                                }
                              
                            }

                        });     
                    } else {
                      
                    }
                });
                $('.edit_btn').click(function(){
                    $('#id').val($(this).data('id'));                    
                   // $('#' + country).prop('selected', true);
                    $('#township_name').val($(this).data('township'));
                    $('#zipcode').val($(this).data('zipcode'));
					$('#state').val($(this).data('state'));
                    $('#country_name').val($(this).data('country'));
                    $('#city_name').val($(this).data('cityname'));
                    $('#address').val($(this).data('address'));
                    $('#set_image').attr('src',$(this).data('image'));
                    $('#area_name').val($(this).data('area_name'));
                    $('#property_type').val($(this).data('property_type'));
                    $('#property_management_contact').val($(this).data('property_management_contact'));
                    $('#resident_committee_contact').val($(this).data('resident_committee_contact'));
                    $('#editmodal').modal('show');
                });
          
                function readURL(input) {
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
        </div>
    </div>
    @endsection
@endguest