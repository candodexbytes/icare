<?php $type = Auth::user()->type; ?>
<?php $item_list = json_decode($unit_property->item_list); ?>
<?php $billDate = date("d M Y", strtotime($unit_property->created_date)); ?>
<div class="col-sm-12 col-md-12 graphs  clearfix property-data">
  <div class="row"> 
    <div class="col-sm-5">
       <strong>Invoice Month:</strong> 
    </div>
    <div class="col-sm-7">
      {{$unit_property->invoice_date}}
    </div>
  </div>
  <div class="row"> 
    <div class="col-sm-5">
       <strong>Due Month:</strong> 
    </div>
    <div class="col-sm-7">
      {{$unit_property->due_due}}
    </div>
  </div>
   <div class="row"> 
    <div class="col-sm-5">
       <strong>Total Amount:</strong>
    </div>
    <div class="col-sm-7">
      RM {{$unit_property->total_amount}}
    </div>
</div>
    <div class="row">
    <div class="col-sm-5">
       <strong>Tax Percentage:</strong> 
    </div>
    <div class="col-sm-7">
      {{$unit_property->tax_percentage}} %
    </div>
  </div>
  <div class="row">
    <div class="col-sm-5 bm_spc">
      Items:
    </div>
   
    <div class="property_div">
        <table id="user_list2" class="table table-bordered" cellspacing="0" width="100%" style="width: 100%;">
            <thead>
              <tr class="" role="row">
                  <th tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" style="width: 72px;">Title</th>
                  <th tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" style="width: 72px;">Description</th>
                  <th tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" style="width: 72px;">Quantity</th>
                  <th tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" style="width: 72px;">Amount</th>
                  <th tabindex="0" aria-controls="user_list1" rowspan="1" colspan="1" style="width: 72px;">Subtotal</th>
              </tr>
          </thead>
            @foreach ($item_list as $value)
            <tr>
                <td>{{$value->title}}</td>
                <td>{{$value->description}}</td>
                <td>{{$value->quantity}}</td>
                <td>{{$value->amount}}</td>
                <td>{{$value->subtotal}}</td>
            </tr>
            @endforeach
        </table>
    </div>

  </div>

  <div class="row">
    <div class="col-sm-5">
         <strong>Status:</strong>
    </div>
    <div class="col-sm-7">
       @if($unit_property->status == 0)
                    <span class="label label-default">Pending</span>
                    @elseif($unit_property->status == 1)
                    <span class="label label-success">Paid</span> 
                    @else
                    <span class="label label-warning">Failed</span> 
              @endif
    </div>
  </div>
  <div class="row">
   <div class="col-sm-5">
       <strong>Bill ID:</strong> 
    </div>
    <div class="col-sm-7">
      @if($unit_property->bill_id)
                          {{$unit_property->bill_id}}
                          @else
                          --
                      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-sm-5">
        <strong>Transaction ID:</strong>
    </div>
    <div class="col-sm-7">
       @if($unit_property->slug)
                          {{$unit_property->slug}}
                          @else
                          --
                      @endif
    </div>
  </div>
</div>
 