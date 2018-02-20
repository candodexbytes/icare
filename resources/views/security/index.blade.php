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
        <!--<link href="css/bootstrap.min.css" rel="stylesheet">-->

        <!-- Custom CSS -->
        <!--    <link href="css/business-frontpage.css" rel="stylesheet">
             <link href="css/style.css" rel="stylesheet">
              <link href="css/responsive.css" rel="stylesheet">-->


        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

        <link href="{{ asset('assets/security/css/business-frontpage.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/security/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/security/css/responsive.css') }}" rel="stylesheet">
        <!-- Styles -->

    </head>

    <body>





        <!-- Note: The background image is set within the business-casual.css file. -->
        <header class="first_part autoheight">
            <div class="container">
                <div class="row">
                    <div class="main-header">
                        
                        <div class="col-sm-12 col-md-12">
                            <div class="logo">
                                <img src="{{ asset('assets/security/img') }}/condo-logo-128.png">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="block1">
                                <h3><a href="{{url('security/security-visitor') }}">SECURITY SYSTEM</a></h3>
                            </div>


                          
                        </div>
                        <div class="col-sm-12 col-md-12">

                        </div>
                        <div class="caring">
                            <!--<h3>Creates caring community</h3>-->
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- Page Content -->

        <!-- /.container -->

        <!-- jQuery -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <!--<script src="js/jquery.js"></script>-->
        <!-- Bootstrap Core JavaScript -->
        <!--<script src="js/bootstrap.min.js"></script>-->
        <script type="text/javascript">
var setElementHeight = function () {
    var height = $(window).height();
    $('.autoheight').css('min-height', (height));
};

$(window).on("resize", function () {
    setElementHeight();
}).resize();
        </script>
        <style type="text/css">
            html, body {
                height:100%;
                width:100%;
            }
            .autoheight {
                height:100%;
            }
        </style>
    </body>

</html>
