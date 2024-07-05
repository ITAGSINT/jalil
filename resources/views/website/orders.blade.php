@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/add.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/no.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/changetwo.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/addresses.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/statments.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">


@endsection
@section('content')
<div class="container">
  <div class="row w-100">
    <div class="col-12 d-flex">
      <!--<p class="add">Statements</p>-->
      <p class="add">Orders</p>
    </div>
  </div>
</div>

<div class="container">
  <div class="row w-100">
    <div class="col-lg-6 col-md-12 row ">
      <div class="col-12  choose choose-right">
        <div class="row w-100 ">
          <div class="col">
            <a href="" style="text-decoration: none;cursor: pointer;" class="type" data-id="1">
              <div class="d-flex carcontainer activetype align-items-center justify-content-center ">

                <p>Delivered</p>
              </div>
            </a>
          </div>
          <div class="col"><a href="" style="text-decoration: none;cursor: pointer;" class="type" data-id="2">
              <div class="d-flex bikecontainer align-items-center justify-content-center">

                <p>To Receive</p>
              </div>
            </a>
          </div>

        </div>

        <div style="overflow-y: scroll;height:29rem;" class="orders">
          {{-- @foreach($orders as $order)
            <div class="row w-100 py-2" style="border-radius: 10px;border:1px solid #f8f9fa;">
              <div class="col-12 d-flex justify-content-center">
  
                <p class="credit"><i class="bi bi-hourglass"></i>{{$order->date}}</p>
              </div>

        <div class="col-12 ">
          <div class=" d-flex align-items-center justify-content-between" style="background-color: #F8F9FA;border-radius: 12px;">
            <div class="mx-1">
              <img class="image-credit" src="{{asset('image/credit card.png')}}">
            </div>
            <div class="mx-1">
              <p class="credit">{{$order->products->name}} for {{$order->car->model->manufacture->name}}</p>
              <p class="credit">@if($order->payment_method==2) Cash On delivery @elseif($order->payment_method==1)Card Payment @endif</p>
              <p class="credit">@if($order->discount_price==NULL ||$order->discount_price==0) {{$order->order_price}} @else {{$order->discount_price}} @endif</p>
            </div>
            <div class="mx-1"> <a class="btn" href="order-details.html"><i class="bi bi-chevron-right"></i></a>
            </div>
          </div>

        </div>
      </div>
      @endforeach--}}



    </div>

  </div>
</div>



<div class="col-lg-6 col-md-12 row ">
  <div class="col-12  choose choose-left">
    <div class="row w-100 ">
      <div class="col-12 ">
        <p class="right">Info About the payment</p>
      </div>

    </div>
    <div class="d-grid align-content-center justify-content-center" style="border-radius: 10px;border:1px solid #f8f9fa;">

      <p class="trans m-0">Transaction No :</p>
      <input class="num mb-3" id="transaction_no" style="border: none ;border-bottom:1px solid #eee">
     



      <p class="trans m-0">Service Name</p>
      <input class="num mb-3" id="service_name" style="border: none ;border-bottom:1px solid #eee">
      





      <p class="trans m-0">Date & Time of transaction :</p>
      <input class="num mb-3" id="transaction_datetime" style="border: none ;border-bottom:1px solid #eee">
     



      <p class="trans m-0">Date completed :</p>
      <input class="num mb-3" id="complete_datetime" style="border: none ;border-bottom:1px solid #eee">
     



      <p class="trans m-0">Transaction Status :</p>
      <input class="num mb-3" id="status" style="border: none ;border-bottom:1px solid #eee">
      








      <p class="trans m-0">Amount :</p>
      <input class="num mb-3" id="amount" style="border: none ;border-bottom:1px solid #eee">
      




      <p class="trans m-0">Payment method :</p>
      <input class="num mb-3" id="paymethod" style="border: none ;border-bottom:1px solid #eee">
      



      <p class="trans m-0">Senders name :</p>
      <input class="num mb-3" id="sender" style="border: none ;border-bottom:1px solid #eee">
      

    </div>
  </div>
</div>
</div>
@endsection
@section('additional_scripts')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<!-- Template Javascript -->
<script src="{{ URL::asset('js/changetwo.js') }}"></script>
<script>
  $(document).ready(function() {
    $.ajax({
      url: '{{ route('website.orders.all') }}',
      type: "get",
      data: {
        status: 5
      },
      // processData: false,
      // contentType: false,
      success: function(data) {
        
          $('.orders').empty();
          var element=``;
          for(var i=0;i<data.data.length;i++) {
            let img=``;
            let model=``;
            let price=0;
            let url=``;
            let myclass="";
            let order_id=data.data[i].order_id
            if(data.data[i].order_status!=5) {
              url = '{{ route("website.orders.details", ":slug") }}';
              url = url.replace(':slug', order_id);
             
            }
            else {
              myclass="details";
            }
            if(data.data[i].discount_price != null && data.data[i].discount_price != 0) {
              price=data.data[i].discount_price

            }
            else {
              price=data.data[i].order_price
            }
            
            if(data.data[i].car.id==1) {
              img=data.data[i].product.main_image

            }
            else {
              img=data.data[i].car.model_image
              model=` for `+data.data[i].car.model
            }
            element += `<div class="row w-100 py-2" style="border-radius: 10px;border:1px solid #f8f9fa;">
              <div class="col-12 d-flex justify-content-center">
  
                <p class="credit"><i class="bi bi-hourglass"></i>`+data.data[i].date+`</p>
              </div>

              <div class="col-12 ">
                <div class=" d-flex align-items-center justify-content-between" style="background-color: #F8F9FA;border-radius: 12px;">
                  <div class="mx-1">
                    <img class="image-credit" src="`+img+`">
                  </div>
                  <div class="mx-1">
                    <p class="credit">`+data.data[i].product.name+``+ model+`</p>
                    <p class="credit">`+data.data[i].paymethod+`</p>
                    <p class="credit">`+price+`</p>
                  </div>
                  <div class="mx-1"> <a class="btn `+myclass+`" href="`+url+`" data-transaction="`+data.data[i].transaction_id+`"><i class="bi bi-chevron-right"></i></a>
                  </div>
                </div>

              </div>
            </div>`
          }
          $('.orders').append(element)
        
      },
    });
  } )
  $(document).on('click', '.type', function(event) {
    event.preventDefault();
    let id = $(this).data("id");
    let status = 1;
    if (id == 2) {
      $(".carcontainer").removeClass("activetype");
      $(".bikecontainer").addClass("activetype");
      $('#transaction_no').val('')
    $('#service_name').val('')
    $('#transaction_datetime').val('')
    $('#complete_datetime').val('')
    $('#status').val('')
    $('#amount').val('')
    $('#paymethod').val('')
    $('#sender').val('')

    } else if (id == 1) {
      $(".bikecontainer").removeClass("activetype");
      $(".carcontainer").addClass("activetype");
      status = 5
    }
    $.ajax({
      url: '{{ route('website.orders.all') }}',
      type: "get",
      data: {
        status: status
      },
      // processData: false,
      // contentType: false,
      success: function(data) {
        
          $('.orders').empty();
          var element=``;
          for(var i=0;i<data.data.length;i++) {
            let img=``;
            let model=``;
            let price=0;
            let url=``;
            let myclass="";
            let order_id=data.data[i].order_id
            if(data.data[i].order_status!=5) {
              url = '{{ route("website.orders.details", ":slug") }}';
              url = url.replace(':slug', order_id);
            }
            else {
              myclass="details";
            }
            if(data.data[i].discount_price != null && data.data[i].discount_price != 0) {
              price=data.data[i].discount_price

            }
            else {
              price=data.data[i].order_price
            }
            
            if(data.data[i].car.id==1) {
              img=data.data[i].product.main_image

            }
            else {
              img=data.data[i].car.model_image
              model=` for `+data.data[i].car.model
            }
            
            element += `<div class="row w-100 py-2" style="border-radius: 10px;border:1px solid #f8f9fa;">
              <div class="col-12 d-flex justify-content-center">
  
                <p class="credit"><i class="bi bi-hourglass"></i>`+data.data[i].date+`</p>
              </div>

              <div class="col-12 ">
                <div class=" d-flex align-items-center justify-content-between" style="background-color: #F8F9FA;border-radius: 12px;">
                  <div class="mx-1">
                    <img class="image-credit" src="`+img+`">
                  </div>
                  <div class="mx-1">
                    <p class="credit">`+data.data[i].product.name+``+ model+`</p>
                    <p class="credit">`+data.data[i].paymethod+`</p>
                    <p class="credit">`+price+`</p>
                  </div>
                  <div class="mx-1"> <a class="btn `+myclass+`" href="`+url+`" data-transaction="`+data.data[i].transaction_id+`"><i class="bi bi-chevron-right"></i></a>
                  </div>
                </div>

              </div>
            </div>`
          }
          $('.orders').append(element)
        
      },
    });
  });
  $(document).on('click','.details',function(event) {
    $('#transaction_no').val('')
    $('#service_name').val('')
    $('#transaction_datetime').val('')
    $('#complete_datetime').val('')
    $('#status').val('')
    $('#amount').val('')
    $('#paymethod').val('')
    $('#sender').val('')
    event.preventDefault()
    transaction=$(this).data('transaction')
    $.ajax({
      url: '{{ route('website.orders.payment.history') }}',
      type: "get",
      data: {
        id: transaction
      },
      // processData: false,
      // contentType: false,
      success: function(data) {
        
        $('#transaction_no').val('#'+data.data.id)
        $('#service_name').val(data.data.service_name)
        if(data.data.trans_date!=null && data.data.trans_time !=null)
          $('#transaction_datetime').val(data.data.trans_date+'/'+data.data.trans_time)
        if(data.data.complete_date ==null && data.data.complete_time==null)
          $('#complete_datetime').val('')
        else
          $('#complete_datetime').val(data.data.complete_date+'/'+data.data.complete_time +'<<completed>>')
        $('#status').val(data.data.status.name)
        $('#amount').val(data.data.amount)
        $('#paymethod').val(data.data.method.name)
        $('#sender').val(data.data.sender_name)
      }
    });
    
  })
</script>

@endsection