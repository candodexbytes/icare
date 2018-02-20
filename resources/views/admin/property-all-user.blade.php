@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

        <div id="page-wrapper" style="min-height: 140px;">    
            <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">    
                <div class="col-lg-12 no-pad">
                    <h1 class="heading_text text-right"><span class="pull-left">All User</span><a href="{{ url('admin/manage-property') }}" class="btn btn-default my_btn">Back</a></h1>
                </div>
                <div class="clearfix"></div>
                <div class="main-div">
                    <table id="user_list" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr class="list_head">
                                <th>NRIC</th>
                                <th>Mobile Number</th>
                                <th>Type</th>
                                <th>Me & My Family</th>
                                <th>Maintenance Fees</th>
                            </tr>
                        </thead>
                        <tbody id="the_list">
                            @if(isset($data))
                                @foreach ($data as $value)
                                    <tr>
                                        <td >{{$value->nric}}</td>
                                       
                                        <td >{{$value->mobile_number}}</td>
                                        <td >@if($value->type == 1)
                                                Resident
                                            @elseif($value->type == 2)
                                                Tenant
                                            @else
                                                Visitor
                                            @endif
                                        </td>
                                        <td ><a href="{{url('/')}}/admin/my-family/{{$id}}/{{$value->id}}">View</a></td>
                                        <td ><a href="{{url('/')}}/admin/maintenance-fee/{{$id}}/{{$value->id}}">View</a></td>
                                    </tr>
                                @endforeach
                            @else    
                                <tr><td colspan='2'>No records found</td></tr>
                            @endif
                        </tbody>
                    </table>    
                    
                </div>
            </div>
        </div>
        <script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}">
        </script>
        <script type="text/javascript" src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#user_list').DataTable( {
                    responsive: true
                } );
            } );
        </script>
    @endsection
@endguest