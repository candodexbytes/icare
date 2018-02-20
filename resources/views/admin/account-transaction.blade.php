@extends('admin-layouts.app')
@guest
   @include('admin-layouts.error')                         
@else
    @section('content')
    <?php  $type = Auth::user()->type; ?>
    @if( $type == 0)
        <div id="page-wrapper" class="add-unit1" style="min-height: 140px;">    
          <div class="col-sm-12 col-md-12 graphs mrg-top clearfix">

            <!-- <div class="col-lg-12 no-pad">
              <h1 class="heading_text text-right"><span class="pull-left">Transaction</span><a href="{{ url('admin/manage-property') }}" class="btn btn-default  my_btn">Back</a></h1>
            </div> -->
            <div class="col-lg-12 no-pad text-right">
                <h3>Your Wallet: {{ $withdrawalAmount }} </h3>

                <div>
                    <p class=""><a href="{{ url('admin/withdrawal-amount') }}/{{$withdrawalAmount}}" class="">Withdraw Amount</a></p>
                </div>
            </div>
           

                
            <div class="main-div">
                <div class="success_msg" style="color:green;height: 30px;clear: both;"></div>
                <table id="contact_list"  class="display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr class="list_head">
                            <th>UNIT ID</th>
                            <th>Address</th>    
                            <th>Amount</th> 
                            <th>Invoice Month</th>
                            <th>Status</th>    
                            <th>Bill ID</th>    
                            <th>Transaction ID</th>  
                            <th>Transaction Date</th>  
                        </tr>
                    </thead>     
                    <tbody id="the_list"> 
                      @if(isset($account) & !empty($account)) 
                        @foreach ($account as $value)
                        <tr class="unit_row">
                            <td>{{strtoupper( str_replace('_',' ',$value->unit_ptd))}}</td>
                            <td>{{$value->block_number}}, {{$value->unit_number}}, {{$value->address}}</td>
                            <td>{{$value->amount}}</td>                      
                            <td>{{$value->invoice_month}}</td>
                            <td>
                                @if($value->payment_status == 1)
                                Paid 
                                @else
                                Failed 
                              @endif
                            </td>
                            <td>{{$value->bill_id}}</td>
                            <td>{{$value->slug}}</td>
                            <td>{{$value->transaction_date}}</td>
                        </tr>
                      @endforeach
                      @else    
                    <tr><td colspan='5'>No records found</td></tr>
                    @endif
                    </tbody>
                </table>    
            </div>

          </div>
        </div>
    @endif    
    @endsection
@endguest
