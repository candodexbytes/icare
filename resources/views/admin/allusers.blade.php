@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

        <div class="container main-div full-height">
        
                <div class="main-div">
                    <table id="user_list" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr class="list_head">
                                <th>NRIC</th>
                                <th>Mobile Number</th>
                                <th>Type</th>
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
                                    </tr>
                                @endforeach
                            @else    
                                <tr><td colspan='2'>No records found</td></tr>
                            @endif
                        </tbody>
                    </table>    
                    
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