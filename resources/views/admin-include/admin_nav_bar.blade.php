<nav class="navbar navbar-default navbar-static-top admin-header navbar-fixed-top" role="navigation" style="margin-bottom: 0">
<?php  $type = Auth::user()->type;
//$ptd_id_user = str_replace(' ', '-', Auth::user()->ptd_id); ?>
    <div class="navbar-header">

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">

            <span class="sr-only">Toggle navigation</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

        </button>
        @if($type == 0)
            <a class="navbar-brand" href="/condo-management/taman-condo">
                <img src="{{url('')}}/assets/images/logo.png">
            </a>
        @else  
            <a class="navbar-brand" href="/condo-management/taman-condo">
                <img src="{{url('')}}/assets/images/logo.png">
            </a>
        @endif
    </div>
    <div class="pull-left title_text_pro"> 
   {{isset(Session::get('Property')->township_name) ? Session::get('Property')->township_name:''}}
            </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-nav navbar-right">
		    	
       
          
          
            @if($type === 0)
               <li> <a class="btn btn-default dashboard_btn" href="/condo-management/taman-condo">
                    Dashboard
                </a></li> <li class="hidden-xs line_bar">|</li>
            @else  
                
            @endif
                
        <li class="dropdown">
             
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            @if($type === 0)
               
            @else  
                Welcome
            @endif {{ Auth::user()->name }} :  @if($type == 0)
                                             Icares
                                            @elseif($type == 5)
                                               Company Management 
                                            @elseif($type == 6)
                                               Resident Committee
                                            @else  

                                            @endif
                <span class="caret"></span>
            </a>

            <ul class="dropdown-menu" role="menu">
                
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>

    	

	</ul>

    

    <!-- /.navbar-static-side -->

</nav>
<script src="/condo-management/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="/condo-management/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
