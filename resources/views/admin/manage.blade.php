@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
 @section('content')
 @section('title', 'Home | Menu')
  <?php  $type = Auth::user()->type; ?>
       <div id="page-wrapper" class="manage_new" style="min-height: 140px;">    

                
            <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            
                <div class="content">
                    <div class="col-sm-12 col-md-12 clearfix contact-margin-top">

                        <div class="col-sm-4 col-md-4 clearfix">
                            <div class="square_1">
                            <a href="{{url('admin/all-user')}}">
                                <div class="image_div"><img src="{{ asset('assets/icon/first.png') }}"  /></div>
                                <div class="text_div">Resident / Tenant</div>
                            </a>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 clearfix">
                             <div class="square_1">
                            <a href="{{url('admin/emergancy-contact')}}">
                                <div class="image_div"><img src="{{ asset('assets/icon/third.png') }}"  /></div>
                                <div class="text_div">Emergency</div>
                            </a>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 clearfix">
                             <div class="square_1">
                            <a href="{{url('admin/report-complaint')}}">
                                <div class="image_div"><img src="{{ asset('assets/icon/fourth.png') }}"  /></div>
                                <div class="text_div">Report / Complaint</div>
                            </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 clearfix contact-margin-top">

                        
                        <div class="col-sm-4 col-md-4 clearfix">
                             <div class="square_1">
                            <a href="{{url('admin/ann-notice-board')}}">
                                <div class="image_div"><img src="{{ asset('assets/icon/fifth.png') }}"  /></div>
                                <div class="text_div">Annoucement / Notice Board</div>
                            </a>
                            </div>
                        </div>
                        @if($type == 0)<div class="col-sm-4 col-md-4 learfix">
                             <div class="square_1">
                            <a href="{{url('admin/insurance')}}">
                                <div class="image_div"><img src="{{ asset('assets/icon/seven.png') }}"  /></div>
                                <div class="text_div">Insurance</div>
                            </a>
                            </div>
                        </div>@endif
                        
                          <div class="col-sm-4 col-md-4 clearfix">
                             <div class="square_1">
                            <a href="{{url('admin/visitor')}}">
                                <div class="image_div"><img src="{{ asset('assets/icon/six.png') }}"  /></div>
                                <div class="text_div">Visitor</div>
                            </a>
                            </div>
                        </div>
                       
                        
                      
                    </div>

                    <div class="col-sm-12 col-md-12 clearfix contact-margin-top">
                        @if($type == 0)
                        <div class="col-sm-4 col-md-4 learfix">
                             <div class="square_1">
                            <a href="{{url('admin/handyman')}}">
                                <div class="image_div"><img src="{{ asset('assets/icon/eight.png') }}"  /></div>
                                <div class="text_div">Handyman</div>
                            </a>
                            </div>
                        </div> 
                        
                        <div class="col-sm-4 col-md-4 learfix">
                             <div class="square_1">
                            <a href="{{url('admin/e-flyer-coupon')}}">
                                <div class="image_div"><img src="{{ asset('assets/icon/nine.png') }}"  /></div>
                                <div class="text_div">E-Flyer & E-Coupon</div>
                            </a>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 learfix">
                         <div class="square_1">
                            <a href="{{url('admin/inbox')}}">
                                <div class="image_div"><img src="{{ asset('assets/icon/third.png') }}"  /></div>
                                <div class="text_div">Messages</div>
                            </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endguest
