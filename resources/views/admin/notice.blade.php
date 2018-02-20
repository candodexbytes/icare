@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
   @section('content')
   @section('title', 'Notice')
    <?php  $type = Auth::user()->type; ?>
    
 
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.dataTables.min.css') }}">

    <div id="page-wrapper" class="notice" style="min-height: 140px;">    
        <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">    
        
            <div class="col-lg-12 no-pad">
              <h1 class="heading_text text-right"><span class="pull-left">Annoucement / Notice Board</span>
                       @if($type==5)
                    <a href="{{ url('admin/add-notice') }}" class="btn btn-default back_btn my_btn"><i class="fa fa-plus"></i></a> 
                    @else
                    <a href="{{ url('admin/manage-property') }}" class="btn btn-default my_btn back_btn">Back</a>
                    @endif
                </h1>
            </div>
            <!-- /.col-lg-12 -->
         <div class="clearfix">
         @if(Session::has('success'))
                       <div class="alert alert-info">{{ Session::get('success') }}</div>
                    @endif
            <div class="main-div">
                <div class="success_msg" style="color:green;height: 30px;clear: both;"></div>
                <table id="notice_list" class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr class="list_head">
                            <th>Image</th>
                            <th>Subject</th>                          
                            <th>Post Date</th>
                            <th>End Date</th>
                           <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="the_list">
					@if(isset($get_record))
					        @foreach ($get_record as $value)
						        <tr id="notice_{{$value->id}}">
                                    <td><img src="{{$value->image}}" style="width: 40px;height: 40px;"> </td>
                                    <td >{{$value->subject}}</td>                         
									 <td ><span class="hidden">{{$value->create_date}}</span>{{date('d M Y g:i A', strtotime($value->create_date))}}</td>
                                    <td>{{date('d M Y g:i:A', strtotime($value->end_date))}}</td>
                                   <td>
                                    @if($type == 5)                                    
                                        <span data-enddate="{{$value->end_date}}" data-subject="{{$value->subject}}" data-description="{{$value->description}}" data-image="{{$value->image}}" data-ptdid="{{$value->ptd_id}}" data-id="{{$value->id}}"  class="edit_btn"><i  class="fa fa-pencil" aria-hidden="true"></i></span>
                                       | <span data-id="{{$value->id}}" class="delete_btn"><i class="fa fa-trash-o" aria-hidden="true"></i></span> |
                                        <span data-id="{{$value->id}}"  data-subject="{{$value->subject}}" data-description="{{$value->description}}" data-image="{{$value->image}}" data-postdate="{{''.date('d M Y g:i:A', strtotime($value->create_date)).''}}" class="detail_btn" ><i class="fa fa-eye"></i></span>
                                        @else
                                      <span data-id="{{$value->id}}"  data-subject="{{$value->subject}}" data-description="{{$value->description}}" data-image="{{$value->image}}" data-postdate="{{''.date('d M Y g:i:A', strtotime($value->create_date)).''}}" class="detail_btn" ><i class="fa fa-eye"></i></span>
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
            <!-- Modal -->
            <div id="editmodal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header middle">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit <span id="title_set">Notice</span> </h4>
                        </div>
                         <form method="post" class="conatct-form form-horizontal" action="{{action('AdminController@UpdateNotice')}}" id="update_notice_form" enctype="multipart/form-data">
                        <div class="modal-body pad">                           
                                <input type="hidden" name="_token" id="token" value="<?= csrf_token();?>">
                                <input type="hidden" name="id" id="id" value="">
                                <input type="hidden" name="ptd_id" id="ptd_id" value="">
                                <div class="form-group">
                                        <label class="col-sm-2 control-label" for="name"><strong>Subject</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"  name="subject" id="subject" value=""/>
                                        </div>
                                </div>                                
                                <div class="form-group">
                                  <label class="col-sm-2 control-label"><strong>Description</strong></label>
                                  <div class="col-sm-9">
                                      <textarea class="form-control"  name="description" id="description" ></textarea>
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-3 control-label"> <strong>Icon</strong> </label>
                                  <div class="col-sm-9">
                                    <img src="" id="set_image" width="100" height="100">
                                    <input class="form-control" onchange="readURL(this);" id="image_file"  style="width: 200px;" name="image_file" type="file">
                                  </div>  
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="datepicker"><strong>End Date</strong></label>
                                    <div class="col-sm-9">
                                        <input class="form-control form_datetime" type="text" value=""  name="end_date" id="datepicker"  />
                                    </div>
                                </div>
                           </div>  
                           <div class="modal-footer">
                               <input type="submit" class="btn btn-default my_btn" value="Update">
                          </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal -->
        <div class="modal fade" id="noticeDetailModal" role="dialog">
            <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header middle">
                <h4 class="modal-title">Annoucement/Notice Board Details</h4>
            </div>
            <div class="modal-body pad clearfix">
                <div class="col-sm-4 col-xs-6 payment_text">
                    <p><strong>Subject</strong></p></div>
                <div class="col-sm-8 col-xs-6 payment_text"><b>
                        <p id="subject_txt"></p>
                    </b></div>

                <div class="col-sm-4 col-xs-6 payment_text">
                    <p><strong> Description </strong></p></div>
                <div class="col-sm-8 col-xs-6 payment_text"><b>
                        <p id="description_txt">Sam</p>
                    </b></div>
                <div class="col-sm-4 col-xs-6 payment_text">
                    <p><strong> Post date</strong></p></div>
                <div class="col-sm-8 col-xs-6 payment_text"><b>
                        <p id="postdate_txt"></p>
                    </b></div>
                 <div class="col-sm-8 col-xs-6 payment_text"><b>
                        <img id="post_image" style="max-height: 200px;"> 
                    </b></div>           
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

    </div>
</div>
   <script type="text/javascript" src="{{ asset('assets/js/jquery.dataTables.min.js') }}"> </script>
            <script type="text/javascript" src="{{ asset('assets/js/dataTables.responsive.min.js') }}"></script>
            <script type="text/javascript">
                $(document).ready(function() {
     
                     $(".form_datetime").datepicker({format: 'mm-dd-yyyy',
                        autoclose: true,
                        todayBtn: true,
                        startDate: '+1d'
                     });       

                   $('#notice_list').DataTable( {
                        responsive:true,
                        "order": [[ 2, "desc" ]]
                    } );
                } );
            </script>
            <script type="text/javascript">
                $('.delete_btn').click(function(){
                    var id = $(this).data('id');
                    var url = '{{url('admin/deletenotice')}}/'+id;
                    
                    var r = confirm("Confirm delete this package!");
                    if (r == true) {
                       $.ajax({
                            type: "GET",
                            url : url,
                            success : function(data){
                                if(data.response == 1){

                                    $( '#notice_'+id ).remove();

                                    $('.success_msg').html('notice remove successfully');
                                    setTimeout(function() {
                                        $('.success_msg').fadeOut('slow');
                                    }, 2000);
                                }
                              
                            }

                        });     
                    } else {
                      
                    }
                });
                $('.edit_btn').click(function(){
                    var id = $(this).data('id');
                    var subject = $(this).data('subject');
                    var description = $(this).data('description');                    
                    var ptd_id = $(this).data('ptdid');
                    var enddate = $(this).data('enddate');                    
                    $('#id').val(id);                   
                    $('#set_image').attr('src', $(this).data('image'));
                    $('#subject').val(subject);
                    $('#description').val(description);
                    $('#datepicker').val(enddate);
                    $('#ptd_id').val(ptd_id);                    
                    $('#editmodal').modal('show');
                          
                    
                });
                $('.detail_btn').click(function () {
                        var subject = $(this).data('subject');
                        var description = $(this).data('description');
                        var postdate = $(this).data('postdate');
                        $('#subject_txt').text(subject);
                        $('#description_txt').html(description);
                        $('#postdate_txt').text(postdate);
                         $('#post_image').attr('src', $(this).data('image'));
                        $('#noticeDetailModal').modal('show');
                });


           function readURL(input) {

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#set_image')
                                .attr('src', e.target.result)
                                .width(150)
                                .height(200);
                        };

                        reader.readAsDataURL(input.files[0]);

                    }
                }
                
            </script>
        </div>
    </div>
    @endsection
@endguest
