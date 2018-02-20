@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <style type="text/css">
        .error_msg {
            margin-top: 40px;
        }
    </style>
    <?php  $type = Auth::user()->type; $ptd_id_user = str_replace(' ', '-', Auth::user()->ptd_id);?>
    @if( $type == 5)
        <div id="page-wrapper" style="min-height: 140px;">    
           <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">Resident/Tenant for unit 
           {{ isset($unit_info) ? 'Block '.$unit_info[0]->block_number .' '. $unit_info[0]->unit_number: ''    }}
                </span><a href="{{ url('admin/unit') }}" class="btn btn-default my_btn">Back</a></h1>
            </div>
            <div class="alert alert-warning error_msg" id="alreadyexist">
                <p>Data Already Exist</p>
            </div>
            <div class="alert alert-warning error_msg" id="nricexist">
                <p>NRIC Already Exist</p>
            </div>
            <div class="alert alert-warning error_msg" id="cellnumberexist">
                <p>Cell Number Already Exist</p>
            </div>
                <div class="align-window clearfix col-sm-12">
                    
                    @if (Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                       <script type="text/javascript">
                            $(document).ready(function () { 
                            });
                       </script>
                    @endif
                    @if (Session::has('error'))
                       <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                   <form method="POST" action="javascript:unitsubmit()" id="addunituser-form" class="form-horizontal conatct-form  " enctype="multipart/form-data">
                        
                        <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                        <input type="hidden" name="ptd_id" id="ptd_id" value="{{$ptd_id_user}}">
                        <input type="hidden" name="unit_id" id="unit_id" value="{{$property_unit_id}}">
                        <input type="hidden" name="hidden" id="hidden" value="">

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="name" id="name" value=""  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="nric">NRIC</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="nric" id="nric" value=""  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="email">Email</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="email" id="email" value=""  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="cell_number">Mobile Number</label>
                            <div class="col-sm-9">
                                <select class="form-control country_code" name="country_code" id="country_code">
                                    <option value="60">MY</option>
                                    <option value="65">SG</option>
                                    <option value="91">IN</option>
                                </select>  
                                <input class="form-control country_phone_code" type="text"  name="country_phone_code" id="country_phone_code" disabled="true"  />
                                <input class="form-control cell_number" type="text"  name="cell_number" id="cell_number"  />
                            </div>
                        </div>
                       @if($property_unit_id)
                       <input class="form-control" type="hidden"  name="property_unit_id" id="property_unit_id"   value="{{$property_unit_id}}"/>   
                        @endif
                        <!-- <div class="form-group">
                            <label class="col-sm-2 control-label" for="password">Password</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password"  name="password" id="password"  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="confirm_password">Confirm Password</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password"  name="confirm_password" id="confirm_password"  />
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="account_type">Account Type</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="account_type" id="account_type">
                                    <option value="1">Resident</option>
                                    <option value="2">Tenant</option>
                                </select>  
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-default my_btn">  
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif    
    @endsection
@endguest
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    function escap_space(string) {
        return string.replace(/\s/g, '');
    }

    $(document).ready(function() {

        $("#country_phone_code").val('60');

        $('#country_code').on('change', function() {
            var code = $('#country_code').val();
            $("#country_phone_code").val(code);
          
        });


        $("#alreadyexist").hide();
        $("#nricexist").hide();
        $("#cellnumberexist").hide();

        $("#cell_number").blur(function(){
            $("#alreadyexist").hide();
            $("#nricexist").hide();
            $("#cellnumberexist").hide();
            var cell_number = $("#cell_number").val();
            var nric = $("#nric").val();
            var ptd_id = $("#ptd_id").val();
            var unit_id = $("#unit_id").val();
            
            if (cell_number != "" && nric != "") {
                var check_url = '{{url('admin/check-cellnumber-nric-data')}}/' + ptd_id + '/' + nric + '/' + cell_number + '/' + unit_id;
                $.ajax({
                    type: "GET",
                    url: escap_space(check_url),
                    success: function (data) {
                       if (data.response == 0) {
                        $("#hidden").val(1);
                       } else if (data.response == 1) {
                        $("#alreadyexist").show();
                       } else if (data.response == 2) {
                        $("#cellnumberexist").show();
                       } else if (data.response == 3) {
                        $("#nricexist").show();
                       }
                    }
                });  
            }
        });
    });

    function unitsubmit(){
        var hidden_field = $("#hidden").val();
        if (hidden_field == 1) {
            var name = $("#name").val();
            var email = $("#email").val();
            var cell_number = $("#cell_number").val();
            var nric = $("#nric").val();
            var password = $("#password").val();
            var unit_id = $("#unit_id").val();
            var account_type = $("#account_type").val();
            var ptd_id = $("#ptd_id").val();
            var country_phone_code = $("#country_phone_code").val();

            var post_url = '/condo-management/admin/addNewUnitUser';
            var data = {
                name: name,
                nric: nric,
                email: email,
                cell_number: cell_number,
                unit_id: unit_id,
                password: password,
                account_type: account_type,
                ptd_id: ptd_id,
                country_phone_code: country_phone_code
            }

            $.ajax({
              type: "POST",
              url: post_url,
              data: data,
              dataType: 'json',
              success: function(data){
                console.log(data);
                if (data.response == 1) {
                    document.getElementById('addunituser-form').reset();
                    location.reload();
                }
              } 
            });
        }
    }
</script>