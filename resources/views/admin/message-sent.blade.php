@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
      @section('title', 'Message')
    <?php  $type = Auth::user()->type; ?>
    @if($type == 0)
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

        <div id="page-wrapper" style="min-height: 140px;">    
            <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">    
                <div class="col-lg-12 no-pad">
                    <h1 class="heading_text text-right">
                      
                           <span class="pull-left">Sent Message</span>
                           <a href="{{ url('admin/new-message') }}" class="btn btn-default my_btn back_btn"><i class="fa fa-plus"></i></a>
                    </h1>
                </div>
                <div class="clearfix"></div>
                <div class="main-div">
                    <div class="success_msg" style="height: 30px;clear: both;"></div>
                    <table id="user_list" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr class="list_head">
                                <th>Send From</th>
                                <th>Send To</th>
                               
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="the_list">
                            @if(isset($data))
                                @foreach($data as $value)
                                    <tr id="email_{{$value->id}}">
                                        <td >{{$value->sent_from}}</td>
                                        <td >{{$value->sent_to}}</td>
                                        
                                        <td >{{$value->subject}}</td>
                                        <td >{!!$value->message!!}</td>
                                        <td ><span data-id="{{$value->id}}" class="delete_btn">Delete</span></td>
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
              function escap_space(string){
                return string.replace(/\s/g,'');
            }
            $(document).ready(function() {
                $('#user_list').DataTable( {
                    responsive: true
                } );
            } );
            $('.delete_btn').click(function(){
                    var id = $(this).data('id');
                    var url = '{{url('admin/deleteemail')}}/'+id;
                    
                    var r = confirm("Confirm delete this email!");
                    if (r == true) {
                       $.ajax({
                            type: "GET",
                            url : escap_space(url),
                            success : function(data){
                                if(data.response == 1){

                                    $( '#email_'+id ).remove();

                                    $('.success_msg').html('email remove successfully');
                                    setTimeout(function() {
                                        $('.success_msg').fadeOut('slow');
                                    }, 2000);
                                }
                              
                            }

                        });     
                    } else {
                      
                    }
                });
        </script>
        @endif
    @endsection
@endguest