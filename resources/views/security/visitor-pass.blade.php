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
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">

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
            <div class="container">
                <div class="row"> 
                    <div class="main-header">
                        <div class="col-sm-12 col-md-12">
                            <div class="visitor_pass1">
                               <a href="{{url('security/visitor-list') }}" class="btn btn-secondary"><span class="glyphicon glyphicon-menu-left"></span></a><h3>Visitor Pass</h3>
                            </div>
                        </div>
                       
                        <div class="col-sm-12 col-md-12">
                            <div class="img_block">
                                <img src="{{isset($visitors_info[0]->mycard_image)? $visitors_info[0]->mycard_image: ""}}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="visitor_form">
                                <form class="form-horizontal">
                                    <?php
                                    // print_r($visitors_info);
                                    ?>

                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-4 col-xs-4 control-label">Name</label>
                                        <div class="col-sm-8 col-xs-8">
                                            {{$visitors_info[0]->name}}
                                            <!--<input type="email" class="form-control" id="inputEmail3" placeholder="Jensen Liew Chi Ren" value="{{$visitors_info[0]->name}}">-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-4 col-xs-4 control-label">NRIC</label>
                                        <div class="col-sm-8 col-xs-8">
                                            {{$visitors_info[0]->visitor_nric}}
                                            <!--<input type="email" class="form-control" id="inputEmail3" placeholder="123456-07-8910" value="{{$visitors_info[0]->visitor_nric}}">-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-4 col-xs-4 control-label">Mobile</label>
                                        <div class="col-sm-8 col-xs-8">
                                            {{$visitors_info[0]->cell_number}}
                                            <!--<input type="email" class="form-control" id="inputEmail3" placeholder="+60123456789" value="{{$visitors_info[0]->cell_number}}">-->
                                        </div>
                                    </div>
                                      <div class="form-group">
                                        <label for="inputName" class="col-sm-4 col-xs-4 control-label">Car Models</label>
                                        <div class="col-sm-8 col-xs-8">
                                            <!--<input type="email" class="form-control" id="inputEmail3" placeholder="Block A, 01-01" value="">-->
                                             {{$visitors_info[0]->car_model}}
                                        </div>
                                      </div>
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-4 col-xs-4 control-label">Car Plate</label>
                                        <div class="col-sm-8 col-xs-8">
                                            {{$visitors_info[0]->car_number}}
                                            <!--<input type="email" class="form-control" id="inputEmail3" placeholder="jjj 1234"  value="{{$visitors_info[0]->car_number}}" >-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-4 col-xs-4 control-label">Total Visitor</label>
                                        <div class="col-sm-8 col-xs-8">
                                            {{$visitors_info[0]->total_visitor}}
                                            <!--<input type="email" class="form-control" id="inputEmail3" placeholder="Block A, 01-01"  value="">-->
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 col-md-12">
                            <div class="visitor_img">
                                <img src="{{ asset('assets/security/img') }}/icon-1.png">
                            </div>
                        </div>-->
                        <div class="col-sm-12 col-md-12">
                            <div class="visitor_code">
                                <p>Visitor Code</p>
                                <h3>{{$visitors_info[0]->visitor_code}}</>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 no-pad">
                            <ul class="menu">
                                <!--<li><a href="#" class="btn btn-secondary">Reject</a></li>-->
                               
                                @if($visitors_info[0]->invitation_status==1 ||  $visitors_info[0]->invitation_status==2)
                                <li><a href="" class="btn btn-secondary" data-toggle="modal"  data-id="{{$visitors_info[0]->visitor_pass_id}}" id="btn_checkin">Check In</a>
                                    @endif
                                    @if($visitors_info[0]->invitation_status==4)
                                <!--<li><a href="{{url('security/visitor-list') }}" class="btn btn-secondary"  >Check Out</a>-->
                                    @endif
                                    <div id="myModal" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <h3>VISITORS COMFIRMED</h3>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="col-sm-12 col-md-12"> 
                            <div class="caring caring2">
                                <!--                       <h3>Creates caring community</h3>-->
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </header>




        <!-- Page Content -->

        <!-- /.container -->

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript">
function escap_space(string) {
    return string.replace(/\s/g, '');
}
var setElementHeight = function () {
    var height = $(window).height();
    $('.autoheight').css('min-height', (height));
};

$(window).on("resize", function () {
    setElementHeight();
}).resize();
$(document).ready(function () {

    $("#btn_checkin").click(function () {
        var visitor_pass_id = $(this).data('id');
       var url = '{{url('security/change-visitor_status')}}/' + visitor_pass_id;
        $.ajax({
        type: "GET",
                url: escap_space(url),
                success: function (data) {
                if (data.response == 1) {
//                $('#myModal').modal('show');
                $('#btn_checkin').text('Check Out')
                 setTimeout(function(){
                     location.reload(true);
                }, 2000);
                }

                }

        }
        );

    });
});
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
