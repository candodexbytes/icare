@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

    <div class="container main-div full-height">
            
        <div class="top_part">
            <div class="col-lg-12">
                <h1 class=" text-right"><span class="pull-left">Property</span><a href="{{ url('add-property') }}" class="btn btn-default my_btn">Add Property</a></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
                <div class="main-div">
                    <div class="success_msg" style="height: 30px;clear: both;"></div>
                    <table id="property_list" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr class="list_head">
                                <th>PTD ID</th>
                                <th>Image</th>
                                <th>Township Name</th>
                                <th>City Name</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="the_list">
                            @if(isset($data))
                                @foreach ($data as $value)
                                    <tr>
                                        <td >{{$value->ptd_id}}</td>
                                        <td ><img src="{{ url('/') }}/public/images/{{$value->image}}" width="100" height="100" ></td>
                                        <td >{{$value->township_name}}</td>
                                        <td >{{$value->city_name}}</td>
                                        <td >{{$value->address}}, {{$value->city_name}}, {{$value->country}}, {{$value->zipcode}}</td>
                                        <td ><span data-country="{{strtolower(str_replace(' ','_',$value->country))}}" data-zipcode="{{$value->zipcode}}" data-township="{{$value->township_name}}" data-id="{{$value->id}}" data-image="{{ url('/') }}/public/images/{{$value->image}}" data-cityname="{{$value->city_name}}" data-address="{{$value->address}}" class="edit_btn"><i  class="fa fa-pencil" aria-hidden="true"></i></span> / <span data-id="{{$value->id}}" class="delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i></span></td>
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
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit <span id="title_set">Property</span> </h4>
              </div>
              <div class="modal-body">
              <form method="post" action="{{action('AdminController@updateProperty')}}" id="update_property_form" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                <input type="hidden" name="id" id="id" value="">
                
                <div class="modelFormRow">
                        <label for="township_name">Township Name</label><br>
                        <input type="text"  name="township_name" id="township_name" value=""/>
                </div>
                <div class="modelFormRow">
                    <label for="country_name">Country Name</label><br>
                    <select name="country_name" id="country_name">
                        <option id="malaysia" value="Malaysia">Malaysia</option>
                        <option id="malaysia_as" value="Malaysia AS">Malaysia AS</option>
                    </select>
                </div>
                <div class="modelFormRow">
                  <label>City Name</label><br>
                  <input type="text" name="city_name" id="city_name" value=""></br>
                </div>
                <div class="modelFormRow">
                        <label for="zipcode">Zipcode</label><br>
                        <input type="text"  name="zipcode" id="zipcode" value="" />
                </div>
               <div class="modelFormRow">
                  <label>Address</label><br>
                  <textarea name="address" id="address" ></textarea>
                  
                </div>
                <div class="modelFormRow">
                  <label>Image</label><br>
                    <img src="" id="set_image" width="100" height="100">
                    <input class="form-control" onchange="readURL(this);" id="image_file" name="image_file" type="file">
                </div>
                
                <input type="submit" value="Update">
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
                    responsive: true
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
                var id = $(this).data('id');
                var image = $(this).data('image');
                var cityname = $(this).data('cityname');
                var address = $(this).data('address');
                
                var country = $(this).data('country');
                var zipcode = $(this).data('zipcode');
                var township = $(this).data('township');
                
                $('#id').val(id);
                
                $('#' + country).prop('selected', true);
                $('#township_name').val(township);
                $('#zipcode').val(zipcode);
                $('#country').val(country);
                $('#city_name').val(cityname);
                $('#address').val(address);

                $('#set_image').attr('src',image);
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
    @endsection
@endguest