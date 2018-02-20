@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
       <div id="page-wrapper" style="min-height: 140px;">    
           
                
            <div class="col-sm-12 col-md-12 graphs clearfix">
            
                <div class="content">
                    <div class="m-b-md">
                        <!-- Condo Management Dashboard -->
                        <ul class="list-inline top_menu">
                            <li class="active"><a href="#">Add Taman/ Condo</a></li>
                            <li class=""><a href="#">Add Handyman</a></li>
                            <li class=""><a href="#">Add E-Flyer</a></li>
                            <li class=""><a href="#">Add E-Coupon</a></li>
                            <li class=""><a href="#">Send Message</a></li>
                        </ul>
                        <div class="add-new">
                            <h2>Add New Taman/ Condo</h2>
                        </div>
                    </div>

               
                </div>
            </div>
        </div>
    @endsection
@endguest