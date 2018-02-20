@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <?php  $type = Auth::user()->type; ?>
    @if( $type == 0)
        <div id="page-wrapper" class="add-unit1" style="min-height: 140px;">    
          	<div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
          		
          	</div>
      </div>
      @endif    
    @endsection
@endguest