@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <?php  $type = Auth::user()->type; ?>
    @if( $type == 0)
        <div id="page-wrapper" class="add-unit1" style="min-height: 140px;">    
           <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Withdraw Amount</span><a href="{{ url('admin/account') }}" class="btn btn-default my_btn">Back</a></h1>
            </div>
                <div class="align-window clearfix col-sm-12">
                  <div class="add_unit">
                    
                    @if (Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                       <script type="text/javascript">
                            $(document).ready(function () { 
                           ///     $(".alert.alert-info").slideUp( 300 ).delay( 800 ).fadeIn( 8000 );
                              //  window.location.href = "{{ url('all-user') }}/{{$ptd_id_user}}";
                            });
                       </script>
                    @endif
                    @if (Session::has('error'))
                       <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                    <form id="addunit-form" class="form-horizontal conatct-form" enctype="multipart/form-data">
                        
                        <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>"> 
                        
                        <input type="hidden" name="property_id" id="property_id" value="{{$property_id}}"> 

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="name">BillPlz URL</label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text"  name="billplz" id="billplz"  />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="bank_name">Message URl</label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text"  name="message" id="message"  />
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="bank_code">Android URL</label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text"  name="android" id="android"  />
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="account_number">IOS URL</label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text"  name="ios" id="ios"  />
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <div class="col-sm-offset-8 col-sm-4">
                                <input id="submit" type="button" value="Save" class="btn btn-default my_btn">  
                            </div> 
                        </div>
                    </form>
                </div>
                </div>

            </div>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	        <div class="modal-dialog modal-lg">
	          <div class="modal-content">
	            <div class="modal-header middle">
	              <h4 class="modal-title" id="myModalLabel">Data Added Successfully</h4>
	            </div>
	            <div class="modal-family-body clearfix">        
	            </div>     
	          </div>
	        </div>
	   </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#submit').click(function(){
                    var billplz = $('#billplz').val();
                    var message = $('#message').val();
                    var android = $('#android').val();
                    var ios = $('#ios').val();
                    var property_id = $("#property_id").val();

                    var post_url = '/condo-management/admin/save-setting';
                    
                    var data = {
                        billplz: billplz,
                        message: message,
                        android: android,
                        ios: ios,
                        property_id: property_id
                    }

                    console.log(data);

                    $.ajax({
                      type: "POST",
                      url: post_url,
                      data: data,
                      dataType: 'json',
                      success: function(data){
                        if (data == 1) {
                            $('#myModal').modal('show');
                            setTimeout(function() {
                                $('#myModal').modal('hide');
                                window.location = '{{ url('admin/setting') }}';
                            }, 1000);
                        }
                      } 
                    });
                });
            });
        </script>
    @endif    
    @endsection
@endguest
	