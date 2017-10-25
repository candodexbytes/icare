<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Error 404</title>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.js"></script>
        <link href="{{ url() }}/assets/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ url() }}/assets/css/style.css" />
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,700,300,300italic' rel='stylesheet' type='text/css'>
        <script src="{{ url() }}/assets/js/jquery.min.js"></script> 
        <script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
        <!-- editable table-->
        <script src="{{ url() }}/assets/js/mindmup-editabletable.js"></script>
        <script src="{{ url() }}/assets/js/numeric-input-example.js"></script>
        <!-- Morris Chart Styles-->
        <link href="{{ url() }}/assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
       
    </head>
<body>
<header>
	<div class="container">
       

        <div class="row">
            
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-8 logo"> 
                <div class="company-logo"> 
                      <?php  if(Auth::user()) {  ?>
                       <a href="{{ url() }}/dashboard"> <img src="{{ url() }}/assets/images/logo.png" align="praxis" border="0" /></a>
                        <?php }  else { ?>
                        <a href="{{ url() }}"> <img src="{{ url() }}/assets/images/logo.png" align="praxis" border="0" /></a>
                        <?php } ?>
                </div> 
            </div>
            
        </div>
    </div>
</header>


<section id="inner-banner">
	<div class="container">
		<h2>Page Not Found</h2>
	</div>
</section>
<section id="container-main">
<div class="container">
	<div class="wrap">
	<div class="logo">
			
			<img src="{{ url() }}/assets/images/404.png">
			
	<!---728x90--->
	<div style="text-align: center;"><script async="" src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

	</div>
			<div class="txt">
			<p>Something went wrong or that page doesn’t exist yet.</p>
			  <p><a href="{{ url() }}">Back to Home </a></p>
			</div>
	</div>
	</div>
	</div>
</section>
<div class="push"></div>
<footer id="footer">
	<div class="container">
		<div class="col-lg-9 col-md-7 col-sm-7 col-xs-12" ><p>© 2015 OAK Business Advisors.<span> All rights reserved</span></p></div>
		<div class="col-lg-3 col-md-5 col-sm-5 col-xs-12" >
			<ul>
				<li> <a href="{{ url() }}/terms-and-conditions">TERMS</a></li>
				<li> <a href="{{ url() }}/privacy-policy">PRIVACY</a></li>
			</ul>
		</div>
	</div>
</footer>
</body>
</html>
