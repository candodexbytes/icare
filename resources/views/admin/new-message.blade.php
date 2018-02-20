@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
     @section('title', 'Message')
    <?php  $type = Auth::user()->type; ?>
    @if($type == 0)
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-multiselect.css') }}" type="text/css">
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-multiselect.js') }}"></script>
     
        <div id="page-wrapper" style="min-height: 140px;">    
           <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">
            <div class="col-lg-12 no-pad">
                <h1 class="heading_text text-right"><span class="pull-left">New Message</span><a href="{{ url('admin/inbox') }}" class="btn btn-default my_btn back_btn">Back</a></h1>
            </div>
                <div class="align-window clearfix col-sm-12">
                   
                    @if (Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                    @endif
                   <form method="POST" action="{{action('MessageController@sendMessageToUser')}}" id="new-message-form" class="form-horizontal conatct-form  " enctype="multipart/form-data">
                        
                        <input type="hidden" name="sender_id" id="sender_id" value="{{$id}}">
                        
                        <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="from_email"> <strong> From </strong></label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="from" id="from" value="{{$name}}" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name"> <strong> To User </strong></label>
                            <div class="col-sm-9">
                                
                                <select class="form-control"  multiple  name="sent_to[]" id="sent_to" >
                                    <option value="multiselect-all">Select All</option>
                                    @if(isset($get_user))
                                        @foreach($get_user as $value)
                                            <option value="{{$value->id}}__{{$value->name}}__{{$value->mobile_number}}">{{$value->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="name"><strong>Subject</strong></label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text"  name="subject" id="subject" value=""  />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="cell_number"><strong>message</strong></label>
                            <div class="col-sm-9">
                                <textarea class="form-control"   name="message" id="message" ></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Send" class="btn btn-default my_btn">  
                            </div> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">
          $(document).ready(function() {
            $('#sent_to').multiselect({
              enableFiltering: true,
               includeSelectAllOption: true,
                maxHeight: 400,
             
            });
          });
        </script>
    @endif    
    @endsection
@endguest