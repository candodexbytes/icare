<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Mobile</title>

        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{ asset('assets/security/css/business-frontpage.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/security/css/style.css') }}" rel="stylesheet">
          <link href="{{ asset('assets/security/css/font-awesome.css') }}" rel="stylesheet">
           <link href="{{ asset('assets/security/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/security/css/responsive.css') }}" rel="stylesheet">
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="{{ asset('assets/js/jquery.validate.js') }}"></script>
          <script type="text/javascript" src="{{ asset('assets/js/form_validate.js') }}"></script>
    </head>

    <body>





        <!-- Note: The background image is set within the business-casual.css file. -->
        <header class="first_part second_part">
            <div class="container">
                <div class="row">
                    <div class="main-header">

                        <div class="col-sm-12 col-md-12">
                          <div class="visitor_pass1">
                               <a href="{{url('security/security-visitor')}}" class="btn btn-secondary"><span class="glyphicon glyphicon-menu-left"></span></a><h3>Visitor SignUp</h3>
                            </div>
                            
                        </div>
                       
                          <form class="form-horizontal" action="{{action('SecurityController@addpassbook')}}" method="post" id="security_visitor_reg" enctype="multipart/form-data">
                        <div class="col-sm-12 col-md-12" >
                            <input type="file" name="car_file"  id="car_file" style="display: none"  onchange="readURL(this);">
                            <div class="cemera_img" >
                                <img src="{{ asset('assets/security/img') }}/cemera.png" id="car_img">
                                
                                 <p id="car_pic" onclick='$("#car_file").click()'  value="Upload" >
                                    Tap to take photo of your Card</p>
                                
                            </div>
                        </div>
                      
                        <div class="col-sm-12 col-md-12">
                            <div class="visitor_form"> 
                                <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-4 col-xs-4 control-label">Name</label>
                                        <div class="col-sm-8 col-xs-8">
                                            <input type="text" class="form-control" id="name"  name="name" placeholder="Jensen Liew Chi Ren" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nric" class="col-sm-4 col-xs-4 control-label">NRIC</label>
                                        <div class="col-sm-8 col-xs-8">
                                            <input type="text" class="form-control" id="nric"  name="nric" placeholder="123456-07-8910" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile" class="col-sm-4 col-xs-4 control-label">Mobile</label>
                                        <div class="col-sm-8 col-xs-8">
                                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="989314587" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="car_model" class="col-sm-4 col-xs-4 control-label">Car Model</label>
                                        <div class="col-sm-8 col-xs-8">
                                           <input type="text" class="form-control" id="car_model" name="car_model" placeholder="BMW 320i White" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="car_plate" class="col-sm-4 col-xs-4 control-label">Car plate</label>
                                        <div class="col-sm-8 col-xs-8">
                                          <input type="text" class="form-control" id="car_number" name="car_number" placeholder="jjj 1234">
                                        </div>
                                    </div>
                               
                            </div>
                        </div>
                  
                        <div class="col-sm-12 col-md-12">
                            <div class="security">
                
                                <input type="submit"  class="btn btn-secondary" value="Register" >
                            </div>
                        </div>
                                     </form>
                        <div class="col-sm-12 col-md-12">
                            <ul class="menu">

<!--                                <li><a href="#" class="btn btn-secondary">Back</a></li>
                                <li><a href="#" class="btn btn-secondary">Reject</a></li>
                                <li><a href="#" class="btn btn-secondary">Logout</a></li>-->
                            </ul>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="caring">
                                <!--<h3>Creates caring community</h3>-->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </header>



        <!-- Page Content -->

        <!-- /.container -->

        <!-- jQuery -->
        
        <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript">

                  function readURL(input) {
                      if (input.files && input.files[0]) {
                        var reader = new FileReader();
                   reader.onload = function (e) {
                            $('#car_img')
                                .attr('src', e.target.result)
                                .width(54)
                                .height(54);
                        };

                        reader.readAsDataURL(input.files[0]);

                    }
                }
        </script>
    </body>

</html>
