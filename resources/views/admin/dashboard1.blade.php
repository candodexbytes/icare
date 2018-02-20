@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
       <div id="page-wrapper" style="min-height: 140px;">    
           
                
            <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            
                <div class="content">
                    <div class="title m-b-md">
                        Condo Management Dashboard
                    </div>

               
                </div>
            </div>
        </div>
    @endsection
@endguest