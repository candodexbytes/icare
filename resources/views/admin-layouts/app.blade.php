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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.validate.js') }}"></script>
    
    <script src="{{ asset('assets/js/form_validate.js') }}"></script>
    
</head>
<?php  $type = Auth::user()->type;
$set_status = 0;

if(Request::segment(1)=="taman-condo"){

}else{
 if(isset(Session::get('Property')->id)){  
    if(isset(Session::get('Property')->township_name)){
        $set_status = 1;
        
    }  
 
}   
} ?>
<body class="@if($type == 0 && $set_status != 1) icares-window @else  @endif">
    
    @if($type == 0)
        @include('admin-include.admin_nav_bar')
        @include('admin-include.admin_side_bar')
    @else  
        @include('admin-include.admin_nav_bar')

        @include('admin-include.admin_side_bar')
    @endif
        
        <div id="app" class="@if($type == 0) align-admin-account  @else align-admin-account @endif">
            @yield('content')
        </div>

    <!-- Scripts -->
    <script>
        $('textarea').ckeditor();
        // $('.textarea').ckeditor(); // if class is prefered.
    </script>
</body>
</html>
