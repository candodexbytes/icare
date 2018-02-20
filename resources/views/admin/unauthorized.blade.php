<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">
    <!-- Styles -->
	  <script>
        basePath = '<?php echo url(''); ?>';
    </script>
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.validate.js') }}"></script>
    
    <script src="{{ asset('assets/js/form_validate.js') }}"></script>
    
</head>
<body>
       <div>    
           
                
            <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            
                <div class="content">
                    <h1>Access Is Denied</h1> 
                  

                    <p>
                    <h4>You do not have the permission to manage property on 
                        behalf of the specified users.Please contact to administrator and try again..
                    </h4>
                </p>
        <a href="{{url('admin/user-login')}}" class="btn btn-info" role="button">Login</a>
 
                        


           
               
                </div>
            </div>
        </div>
</body>
</html>

