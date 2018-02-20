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
        <link href="{{ asset('assets/security/css/responsive.css') }}" rel="stylesheet">
</head>

<body>

   
    

   
    <!-- Note: The background image is set within the business-casual.css file. -->
    <header class="first_part">
        <div class="container">
         <div class="row">
            <div class="main-header">
                <div class="col-sm-12 col-md-12">
                    <div class="top-heading">
                        <h1>iCAReS</h1>
                        <P>Interactive community and Desident system</P>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="security">
                        <h3>Visitor Details</h3>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="img_block">
                       <img src="{{isset($visitors_info)? $visitors_info[0]->mycard_image:""}}">
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="car_tbl">
                       <table class="table-bordered">
                         <tbody>
                           <tr>
                             <td class="chnge">Name</td>
                             <td class="chnge">{{isset($visitors_info)? $visitors_info[0]->name:""}}</td>
                           </tr>
                         </tbody>
                       </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="car_tbl">
                       <table class="table-bordered">
                         <tbody>
                           <tr>
                             <td class="chnge">NRIC</td>
                             <td class="chnge">{{isset($visitors_info)? $visitors_info[0]->visitor_nric:""}} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
                           </tr>
                         </tbody>
                       </table>
                    </div>
                </div>
                 <div class="col-sm-12 col-md-12">
                    <div class="car_tbl">
                       <table class="table-bordered">
                         <tbody>
                           <tr>
                             <td class="chnge">Mobile</td>
                             <td class="chnge">{{isset($visitors_info)? $visitors_info[0]->cell_number:""}} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
                           </tr>
                         </tbody>
                       </table>
                    </div>
                </div>
                 <div class="col-sm-12 col-md-12">
                    <div class="car_tbl">
                       <table class="table-bordered">
                         <tbody>
                           <tr>
                             <td class="chnge">Car</td>
                             <td class="chnge">{{isset($visitors_info)? $visitors_info[0]->car_model:""}} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
                           </tr>
                         </tbody>
                       </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="car_tbl">
                       <table class="table-bordered">
                         <tbody>
                           <tr>
                             <td class="chnge">Car Place</td>
                             <td class="chnge"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
                           </tr>
                         </tbody>
                       </table>
                    </div>
                </div>
                 <div class="col-sm-12 col-md-12">
                    <div class="registration">
                       <a href="{{url('security/visitor-list')}}" class="btn btn-secondary">Registration Done</a>
                    </div>
                </div>
            
             <div class="col-sm-12 col-md-12">
                    <ul class="menu">
                       <!--<li><a href="#" class="btn btn-secondary">Reject</a></li>-->
<!--                        <li><a href="#" class="btn btn-secondary">Back</a></li>
                        <li><a href="#" class="btn btn-secondary">Comfirmed</a></li>-->
                    </ul>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="caring">
<!--                       <h3>Creates caring community</h3>-->
                    </div>
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

</body>

</html>
