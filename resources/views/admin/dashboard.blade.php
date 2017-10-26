@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
        <div class="flex-center position-ref full-height">
            
            <div class="content">
                <div class="title m-b-md">
                    Condo Management Daashboard
                </div>

               
            </div>
        </div>
    @endsection
@endguest