<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse side-bar-icon">
                    <ul class="nav" id="side-menu">
                        <?php 
					 	$type = Auth::user()->type; $genrate_ptd_id = str_replace(' ', '-', Auth::user()->ptd_id);

                                $set_status = 0;$genrate_set_id ='';

                                if(isset($setid)){  
                                    if(isset($township_name)){
                                        $set_status = 1;
                                        $genrate_set_id = str_replace(' ', '-', $setid);
                                    }    
                                }else{
                                    if(isset($ptd_id_genrate)){
                                        if(isset($township_name)){
                                            $set_status = 1;
                                            $genrate_set_id = str_replace(' ', '-', $ptd_id_genrate);
                                        }
                                          
                                    }
                                }
                       
                         ?>

                            @guest
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @else
                                
                                    
                                    @if($type == 5)
                                     <li>
                                        <a class="@if(Request::segment(2) == 'unit' || Request::segment(2) == 'add-unit') menu-active @endif" href="{{ url('admin/unit') }}">Units 
                                        </a>
                                         <a class="@if(Request::segment(2) == 'unit' || Request::segment(2) == 'add-unit') menu-active @endif add_icon_eye side_icon" href="{{ url('admin/add-unit') }}"><i class="fa fa-plus"></i></a>
                                      </li>
                                  
                                        <li class="panel-group admin-menu-margin-bottom three_user_list">
                                          <div class="panel panel-default">
                                            <div class="panel-heading">
                                              <h4 class="panel-title">
                                                <a data-toggle="collapse" class=" @if(Request::segment(2) == 'all-user' || Request::segment(1) == 'resident-user' || Request::segment(1) == 'tenant-user' || Request::segment(2) == 'new-user' || Request::segment(2) == 'new-resident-user' || Request::segment(2) == 'new-tenant-user' || Request::segment(2) == 'my-family') menu-active @else collapsed   @endif" href="#collapse1">Resident/Tenant <span class="fa fa-angle-down pull-right"></span><span class="fa arrow rotet" style="display:none;"></span></a>
                                              </h4>
                                            </div>
                                            <div id="collapse1" class="panel-collapse collapse @if(Request::segment(2) == 'all-user' || Request::segment(1) == 'resident-user' || Request::segment(1) == 'tenant-user' || Request::segment(2) == 'new-user' || Request::segment(2) == 'new-resident-user' || Request::segment(2) == 'new-tenant-user' || Request::segment(2) == 'my-family') in   @endif">
                                              <ul class="nav nav-second-level "> 
                                                <li style="padding-left: 25px !important;">
                                                    <a class="@if(Request::segment(2) == 'all-user' || Request::segment(2) == 'new-user' || Request::segment(2) == 'my-family' || Request::segment(2) == 'my-family') menu-active @endif" href="{{ url('/admin/all-user') }}">All </a>
                                                    <span class="add_icon">
                                                      <!--<a title="Add new" class="@if(Request::segment(2) == 'all-user' || Request::segment(2) == 'new-user') menu-active @endif"  href="{{ url('/admin/new-user') }}"><i class="fa fa-plus"></i></a></span>-->
                                                </li>                               
                                                <li style="padding-left: 25px !important;">
                                                    <a class="@if(Request::segment(1) == 'resident-user' || Request::segment(2) == 'new-resident-user' || Request::segment(2) == 'my-family' || Request::segment(2) == 'my-family') menu-active @endif" href="{{url('/resident-user')}}">Resident</a>
                                                    <!--<span class="add_icon"><a title="Add new" class="@if(Request::segment(1) == 'resident-user' || Request::segment(2) == 'new-resident-user') menu-active @endif" href="{{ url('/admin/new-resident-user') }}"><i class="fa fa-plus"></i></a></span>-->
                                                </li>
                                                <li style="padding-left: 25px !important;">
                                                    <a class="@if(Request::segment(1) == 'tenant-user' || Request::segment(2) == 'new-tenant-user' || Request::segment(2) == 'my-family' || Request::segment(2) == 'my-family') menu-active @endif" href="{{url('/tenant-user')}}">Tenant </a>
                                                    <span class="add_icon">
                                                        <!--<a title="Add new" class="@if(Request::segment(1) == 'tenant-user' || Request::segment(2) == 'new-tenant-user') menu-active @endif" href="{{ url('/admin/new-tenant-user') }}">-->
                                                           <!--  <i class="fa fa-pluss"></i> -->
                                                        <!--</a>-->
                                                    </span>
                                                </li>
                                                    
                                            </ul>
                                            </div>
                                          </div>
                                        </li>

                                        <li class="panel-group admin-menu-margin-bottom">
                                          <div class="panel panel-default">
                                            <div class="panel-heading">
                                              <h4 class="panel-title">
                                                <a data-toggle="collapse" class=" @if(Request::segment(2) == 'emergancy-contact' ||  Request::segment(2) == 'add-contact') menu-active @else collapsed   @endif" href="#emergency1">Emergency <span class="fa fa-angle-down pull-right"></span><span class="fa arrow rotet" style="display:none;"></span></a>
                                              </h4>
                                            </div>
                                            <div id="emergency1" class="panel-collapse collapse @if(Request::segment(2) == 'emergancy-contact' || Request::segment(2) == 'add-contact') in   @endif">
                                              <ul class="nav nav-second-level "> 
                                                 <li style="padding-left: 25px !important;">
                                                    <a class="@if(Request::segment(2) == 'emergancy-contact' ) menu-active @endif" href="{{ url('/admin/emergancy-contact') }}">View <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a>
                                                   
                                                 </li>                               
                                                 <li style="padding-left: 25px !important;">
                                                   
                                                    <a class="@if(Request::segment(2) == 'add-contact') menu-active @endif" href="{{ url('/admin/add-contact') }}">Add  <span class="add_icon_eye"><i class="fa fa-plus"></i></span></a>
                                                 </li> 
                                                
                                               
                                            </ul>
                                            </div>
                                          </div>
                                        </li>

                                        <!--  -->

                                        
                                        <li><a class="@if(Request::segment(2) == 'report-complaint') menu-active @endif" href="{{ url('admin/report-complaint') }}">Report / Complaint <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>

                                        <li class="panel-group admin-menu-margin-bottom">
                                          <div class="panel panel-default">
                                            <div class="panel-heading">
                                              <h4 class="panel-title">
                                                <a data-toggle="collapse" class=" @if(Request::segment(2) == 'ann-notice-board' ||  Request::segment(2) == 'add-notice') menu-active @else collapsed   @endif" href="#notice1">Annoucement / Notice Board <span class="fa fa-angle-down pull-right"></span><span class="fa arrow rotet" style="display:none;"></span></a>
                                              </h4>
                                            </div>
                                            <div id="notice1" class="panel-collapse collapse @if(Request::segment(2) == 'ann-notice-board' || Request::segment(2) == 'add-notice') in   @endif">
                                              <ul class="nav nav-second-level "> 
                                                 <li style="padding-left: 25px !important;">
                                                    <a class="@if(Request::segment(2) == 'ann-notice-board' ) menu-active @endif" href="{{ url('/admin/ann-notice-board') }}">View <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a>
                                                   
                                                 </li>                               
                                                 <li style="padding-left: 25px !important;">
                                                   
                                                    <a class="@if(Request::segment(2) == 'add-notice') menu-active @endif" href="{{ url('/admin/add-notice') }}">Add  <span class="add_icon_eye"><i class="fa fa-plus"></i></span></a>
                                                 </li> 
                                                
                                               
                                            </ul>
                                            </div>
                                          </div>
                                        </li>
                                        <li>
                                          <a class="@if(Request::segment(2) == 'security-link') menu-active @endif" href="{{ url('admin/security-link') }}">Security <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>
                                        <li>
                                          <a  class="@if(Request::segment(2) == 'maintenance') menu-active @endif"  href="{{ url('admin/maintenance') }}">Maintenance <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>
                                        <li><a class="@if(Request::segment(2) == 'visitor') menu-active @endif" href="{{ url('/admin/visitor') }}">Visitor <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>
  
                                        @else
                                         @if($type == 0)
												                       <li>
                                                     <li><a class="@if(Request::segment(2) == 'rcmc-admin') menu-active @endif" href="{{ url('rcmc-admin') }}">Company & Committee  </a> </li>
                                               </li>
                                      
												                       <li><a class="@if(Request::segment(2) == 'unit') menu-active @endif" href="{{ url('admin/unit') }}">Units  </a> </li>
                                              <li class="panel-group admin-menu-margin-bottom">
                                                  <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                      <h4 class="panel-title">
                                                        <a data-toggle="collapse" class="collapsed @if(Request::segment(2) == 'all-user' || Request::segment(1) == 'resident-user' || Request::segment(1) == 'tenant-user' || Request::segment(2) == 'new-user' || Request::segment(2) == 'new-resident-user' || Request::segment(2) == 'new-tenant-user' || Request::segment(2) == 'my-family' || Request::segment(2) == 'maintenance-fee') menu-active   @endif" href="#collapse1">Resident/Tenant <span class="fa fa-angle-down pull-right"></span><span class="fa arrow rotet" style="display:none;"></span></a>
                                                      </h4>
                                                    </div>
                                                    <div id="collapse1" class="panel-collapse collapse @if(Request::segment(2) == 'all-user' || Request::segment(1) == 'resident-user' || Request::segment(1) == 'tenant-user' || Request::segment(2) == 'new-user' || Request::segment(2) == 'new-resident-user' || Request::segment(2) == 'new-tenant-user' || Request::segment(2) == 'my-family' || Request::segment(2) == 'maintenance-fee') in   @endif">
                                                      <ul class="nav nav-second-level "> 
                                                         <li style="padding-left: 25px !important;"><a class="@if(Request::segment(2) == 'all-user' || Request::segment(2) == 'new-user' || Request::segment(2) == 'my-family' || Request::segment(2) == 'maintenance-fee') menu-active @endif" href="{{ url('/admin/all-user') }}">All </a></li>                               
                                                        <li style="padding-left: 25px !important;">
                                                            <a class="@if(Request::segment(1) == 'resident-user' || Request::segment(2) == 'new-resident-user' || Request::segment(2) == 'my-family' || Request::segment(2) == 'maintenance-fee') menu-active @endif" href="{{url('/resident-user')}}">Resident </a>
                                                        </li>
                                                        <li style="padding-left: 25px !important;">
                                                            <a class="@if(Request::segment(1) == 'tenant-user' || Request::segment(2) == 'new-tenant-user' || Request::segment(2) == 'my-family' || Request::segment(2) == 'maintenance-fee') menu-active @endif" href="{{url('/tenant-user')}}">Tenant </a>                                            </li>
                                                       
                                                    </ul>
                                                    </div>
                                                  </div>
                                                </li>

                                                <li><a class="@if(Request::segment(2) == 'emergancy-contact') menu-active @endif" href="{{ url('admin/emergancy-contact') }}">Emergency <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>
                                                <li><a class="@if(Request::segment(2) == 'report-complaint') menu-active @endif" href="{{ url('admin/report-complaint') }}">Report / Complaint <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>
                                                <li><a class="@if(Request::segment(2) == 'ann-notice-board') menu-active @endif" href="{{ url('admin/ann-notice-board') }}">Annoucement / Notice Board <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>
                                                <li><a class="@if(Request::segment(2) == 'insurance') menu-active @endif" href="{{ url('admin/insurance') }}">Insurance <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>
                                                <li class="panel-group admin-menu-margin-bottom">
                                                  <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                      <h4 class="panel-title">
                                                        <a data-toggle="collapse" class=" @if(Request::segment(2) == 'handyman' ||  Request::segment(2) == 'add-handyman-contact') menu-active @else collapsed   @endif" href="#handyman1">Handyman <span class="fa fa-angle-down pull-right"></span><span class="fa arrow rotet" style="display:none;"></span></a>
                                                      </h4>
                                                    </div>
                                                    <div id="handyman1" class="panel-collapse collapse @if(Request::segment(2) == 'handyman' || Request::segment(2) == 'add-handyman-contact') in   @endif">
                                                      <ul class="nav nav-second-level "> 
                                                         <li style="padding-left: 25px !important;">
                                                            <a class="@if(Request::segment(2) == 'handyman' ) menu-active @endif" href="{{ url('/admin/handyman') }}">View <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a>
                                                           
                                                         </li>                               
                                                         <li style="padding-left: 25px !important;">
                                                           
                                                            <a class="@if(Request::segment(2) == 'add-handyman-contact') menu-active @endif" href="{{ url('/admin/add-handyman-contact') }}">Add  <span class="add_icon_eye"><i class="fa fa-plus"></i></span></a>
                                                         </li> 
                                                        
                                                       
                                                    </ul>
                                                    </div>
                                                  </div>
                                                </li>

                                                <li class="panel-group admin-menu-margin-bottom">
                                                  <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                      <h4 class="panel-title">
                                                        <a data-toggle="collapse" class=" @if(Request::segment(2) == 'e-flyer-coupon' ||  Request::segment(2) == 'add-coupon') menu-active @else collapsed   @endif" href="#coupon1">E-Flyer & E-Coupon<span class="fa fa-angle-down pull-right"></span><span class="fa arrow rotet" style="display:none;"></span></a>
                                                      </h4>
                                                    </div>
                                                    <div id="coupon1" class="panel-collapse collapse @if(Request::segment(2) == 'e-flyer-coupon' || Request::segment(2) == 'add-coupon') in   @endif">
                                                      <ul class="nav nav-second-level "> 
                                                         <li style="padding-left: 25px !important;">
                                                            <a class="@if(Request::segment(2) == 'e-flyer-coupon' ) menu-active @endif" href="{{ url('/admin/e-flyer-coupon') }}">View <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a>
                                                           
                                                         </li>                               
                                                         <li style="padding-left: 25px !important;">
                                                           
                                                            <a class="@if(Request::segment(2) == 'add-coupon') menu-active @endif" href="{{ url('/admin/add-coupon') }}">Add  <span class="add_icon_eye"><i class="fa fa-plus"></i></span></a>
                                                         </li> 
                                                        
                                                       
                                                    </ul>
                                                    </div>
                                                  </div>
                                                </li>

                                                 <li class="panel-group admin-menu-margin-bottom">
                                                  <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                      <h4 class="panel-title">
                                                        <a data-toggle="collapse" class=" @if(Request::segment(2) == 'inbox' ||  Request::segment(2) == 'sent' ||  Request::segment(2) == 'new-message') menu-active @else collapsed   @endif" href="#message1">Message<span class="fa fa-angle-down pull-right"></span><span class="fa arrow rotet" style="display:none;"></span></a>
                                                      </h4>
                                                    </div>
                                                    <div id="message1" class="panel-collapse collapse @if(Request::segment(2) == 'inbox' ||  Request::segment(2) == 'sent' ||  Request::segment(2) == 'new-message') in   @endif">
                                                      <ul class="nav nav-second-level "> 
                                                         <li style="padding-left: 25px !important;">
                                                            <a class="@if(Request::segment(2) == 'inbox' ) menu-active @endif" href="{{ url('/admin/inbox') }}">Inbox <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a>
                                                           
                                                         </li>  
                                                         <li style="padding-left: 25px !important;">
                                                            <a class="@if(Request::segment(2) == 'sent' ) menu-active @endif" href="{{ url('/admin/sent') }}">Sent Messages <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a>
                                                           
                                                         </li>                             
                                                         <li style="padding-left: 25px !important;">
                                                           
                                                            <a class="@if(Request::segment(2) == 'new-message') menu-active @endif" href="{{ url('/admin/new-message') }}">Compose <span class="add_icon_eye"><i class="fa fa-plus"></i></span></a>
                                                         </li> 
                                                     </ul>
                                                    </div>
                                                  </div>
                                                </li>
                                                <li><a class="@if(Request::segment(2) == 'visitor') menu-active @endif" href="{{ url('/admin/visitor') }}">Visitors<span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>
                                                <li><a class="@if(Request::segment(2) == 'account_transaction') menu-active @endif" href="{{ url('/admin/account') }}">Account And Transaction<span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>
                                                <li><a class="@if(Request::segment(2) == 'setting') menu-active @endif" href="{{ url('/admin/setting') }}">Setting<span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>
                                            @endif
                                    @endif 

                                    @if($type === 6)
                                     <li>
                                        <a class="@if(Request::segment(2) == 'unit') menu-active @endif" href="{{ url('admin/unit') }}">Units </a>                                       
                                      </li>
                                        <li class="panel-group admin-menu-margin-bottom">
                                          <div class="panel panel-default">
                                            <div class="panel-heading">
                                              <h4 class="panel-title">
                                                <a data-toggle="collapse" class="collapsed @if(Request::segment(2) == 'all-user' || Request::segment(1) == 'resident-user' || Request::segment(1) == 'tenant-user' || Request::segment(2) == 'new-user' || Request::segment(2) == 'new-resident-user' || Request::segment(2) == 'new-tenant-user' || Request::segment(2) == 'my-family' || Request::segment(2) == 'maintenance-fee') menu-active   @endif" href="#collapse1">All User <span class="fa fa-angle-down pull-right"></span><span class="fa arrow rotet" style="display:none;"></span></a>
                                              </h4>
                                            </div>
                                            <div id="collapse1" class="panel-collapse collapse @if(Request::segment(2) == 'all-user' || Request::segment(1) == 'resident-user' || Request::segment(1) == 'tenant-user' || Request::segment(2) == 'new-user' || Request::segment(2) == 'new-resident-user' || Request::segment(2) == 'new-tenant-user' || Request::segment(2) == 'my-family' || Request::segment(2) == 'maintenance-fee') in   @endif">
                                              <ul class="nav nav-second-level "> 
                                                 <li style="padding-left: 25px !important;"><a class="@if(Request::segment(2) == 'all-user' || Request::segment(2) == 'new-user' || Request::segment(2) == 'my-family' || Request::segment(2) == 'maintenance-fee') menu-active @endif" href="{{ url('/admin/all-user') }}">All User</a></li>                               
                                                <li style="padding-left: 25px !important;">
                                                    <a class="@if(Request::segment(1) == 'resident-user' || Request::segment(2) == 'new-resident-user' || Request::segment(2) == 'my-family' || Request::segment(2) == 'maintenance-fee') menu-active @endif" href="{{url('/resident-user')}}">Resident </a>
                                                </li>
                                                <li style="padding-left: 25px !important;">
                                                    <a class="@if(Request::segment(1) == 'tenant-user' || Request::segment(2) == 'new-tenant-user' || Request::segment(2) == 'my-family' || Request::segment(2) == 'maintenance-fee') menu-active @endif" href="{{url('/tenant-user')}}">Tenant </a>
                                                  </li>
                                               
                                            </ul>
                                            </div>
                                          </div>
                                        </li>

                                        <li class="panel-group admin-menu-margin-bottom">
                                          <div class="panel panel-default">
                                            <div class="panel-heading">
                                              <h4 class="panel-title">
                                                <a data-toggle="collapse" class=" @if(Request::segment(2) == 'emergancy-contact' ||  Request::segment(2) == 'add-contact') menu-active @else collapsed   @endif" href="#emergency1">Emergency <span class="fa fa-angle-down pull-right"></span><span class="fa arrow rotet" style="display:none;"></span></a>
                                              </h4>
                                            </div>
                                            <div id="emergency1" class="panel-collapse collapse @if(Request::segment(2) == 'emergancy-contact' || Request::segment(2) == 'add-contact') in   @endif">
                                              <ul class="nav nav-second-level "> 
                                                 <li style="padding-left: 25px !important;">
                                                    <a class="@if(Request::segment(2) == 'emergancy-contact' ) menu-active @endif" href="{{ url('/admin/emergancy-contact') }}">View <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a>                                                   
                                                 </li>                              
                                                 <li style="padding-left: 25px !important;">
                                                   
                                                    <a class="@if(Request::segment(2) == 'add-contact') menu-active @endif" href="{{ url('/admin/add-contact') }}">Add  <span class="add_icon_eye"><i class="fa fa-plus"></i></span></a>
                                                 </li>                                                 
                                               
                                            </ul>
                                            </div>
                                          </div>
                                        </li>
                                        <li><a class="@if(Request::segment(2) == 'report-complaint') menu-active @endif" href="{{ url('admin/report-complaint') }}">Report / Complaint <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>
                                        <li><a class="@if(Request::segment(2) == 'ann-notice-board') menu-active @endif" href="{{ url('admin/ann-notice-board') }}">Annoucement / Notice Board <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>
                                        
                                        <li><a class="@if(Request::segment(2) == 'visitor') menu-active @endif" href="{{ url('/admin/visitor') }}">Visitors <span class="add_icon_eye"><i class="fa fa-eye"></i></span></a></li>
                                      @endif
                            @endguest
                       </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>

