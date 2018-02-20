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
    </head>

    <body>
        <!-- Note: The background image is set within the business-casual.css file. -->
        <header class="first_part autoheight second_part">
            <div class="container-fluid pad">
               
                    <div class="main-header">
                        <div class="col-sm-12 col-md-12 pad">
                            <div class="top-heading1">
                            <a href="{{url('security/security-visitor') }}" class="btn btn-secondary"> <span class="glyphicon glyphicon-menu-left"></span></a> 
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="logo">
                                <img src="{{ asset('assets/security/security-icon') }}/login.png">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="visitor_list">
                                <h3>Visitor List</h3>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="visitor_tbl">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Visitor Code</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(isset($visitor_data) && !empty($visitor_data))
                                        @foreach ($visitor_data as $value)
                                        <tr>
                                            <td>{{date("d M Y", strtotime($value->created_date))}}</td>
                                            <td>{{$value->name}}</td>
                                            <td>
                                                <a href="{{url('security/visitor-pass/') }}/{{$value->id}}" class="btn btn-secondary">{{$value->ptd_id}}</a> 
                                            </td>
                                        </tr>
                                        @endforeach

                                        @else
                                        <tr>

                                            <td colspan="3">Not any visitor found </td>
                                        </tr>
                                        @endif



<!--                                        <tr>
      <td>12-sep--17</td>
      <td>Jensen liew Chi Ren</td>
      <td><a href="{{url('security/visitor-pass') }}" class="btn btn-secondary">270912001</a></td>

  </tr>-->


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                        </div>


                        <div class="caring">
                            <!--                            <h3>Creates caring community</h3>-->
                        </div>
                    </div>
                
            </div>
        </header>




        <!-- Page Content -->

        <!-- /.container -->

        <!-- jQuery -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
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
