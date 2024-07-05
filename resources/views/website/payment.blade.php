@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/add.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/no.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/addone.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/changetwo.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/addresses.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/carwash.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/payment.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
 window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Reload the page if it was restored from the cache
                window.location.reload();
            }
        });
       
       
       
   
        </script>

@endsection
@section('content')
<div class="container">
    <p class="toptext">Payment</p>
  </div>


@if(session()->has('product_id')&&session()->has('address_id')&&session()->has('car_id')&&session()->has('date')&&session()->has('time'))
  <div class="container">
    <div class="row w-100 ">
      <div class="col-4 ">
        <hr class="hrone">
      </div>
      <div class="col-4 ">
        <hr class="hrone">
      </div>
      <div class="col-4 ">
        <hr class="hrone">
      </div>
    </div>
  </div>

  <div class="container ">
    <div class="row w-100 mx-auto">


      <div class="col-12 row w-100 choose mx-auto">
        <div class="col-lg-6 col-md-12 row mx-0">
          <div class="col-12 ">

            <div class="row w-100 p-2 p-4 mb-5" style="border-radius: 10px;border:1px solid #f8f9fa;">
              <div class="col-12 ">
                <p class="emirate">Any additional instruction for delivery?</p>
              </div>
              <div class="col-12">
                <div class="input-group  mx-0">
                  <input type="text" class="form-control Current-Location Current-Location-one note"
                    placeholder="Enter instructions here" aria-label="Username" aria-describedby="basic-addon1">
                </div>
              </div>
            </div>


            <div class="row w-100 w-100 p-4" style="border-radius: 10px;border:1px solid #f8f9fa;">
              <div class="col-12 ">
                <p class="emirate">Payment Summary</p>
              </div>
              <div class="col-12">
                <div class="container country d-grid"
                  style="background-color: #F8F9FA;border-radius: 10px;border:1px solid #f8f9fa;">
                  <div class="container ">
                    <p class="float-start ecoleft">{{$product->name}}</p>
                    <p class="float-end ecoright">{{$qty}} X {{$product->products_price}} </p>
                  </div>
                  <div class="container ">
                    <p class="float-start ecoleft">Discount</p>
                    <p class="float-end ecoright">{{Session::get('discount')}}</p>
                  </div>
                  <!--<div class="container ">
                    <p class="float-start ecoleft">Eco Popular</p>
                    <p class="float-end ecoright">45AED</p>
                  </div>-->
                  <hr>
                  <div class="container ">
                    <p class="float-start ecoleft">Total Amount</p>
                    <p class="float-end ecoright">{{Session::get('new_total')}}AED</p>
                  </div>
                </div>
              </div>
            </div>




          </div>
        </div>







        <div class="col-lg-6 col-md-12 row mx-0" ">
                <div class=" col-12 " >
                  <div class=" row w-100 pt-4 ">
                    
        

        <div class="col-12 py-3">
          <a class="btn w-100 btn-payment pay_button_credit" href="" role="button" data-pay="1">Pay with credit card</a>
        </div>
        <div class="col-12 py-3 text-center">
          <p class="or ">OR</p>
        </div>
        <div class="col-12 py-3">
          <a class="btn w-100 btn-payment-two pay_button_chash" href="" role="button" data-pay="2">Cash on delivery</a>
        </div>
        <div class="col-12 py-3">
          <p class="payment-text">NO money will be deducted on this option, only cash will be hold until other ways of
            payment are achieved</p>
        </div>
      </div>



    </div>
  </div>
  </div>
  </div>
  </div>
  @else 
  <div class="container">
    <div class="row w-100 mx-auto">
      <div class="col-12  w-100 choose mx-auto">
        <p class="text-center">Page Expired !!!</p>
      </div>
    </div>
  </div>
  @endif
@endsection
@section('additional_scripts')
<script src="{{URL::asset('js/changetwo.js') }}"></script>
<script>
  $(document).on('click','.pay_button_chash',function(event) {
    event.preventDefault();
    pay=$(this).data("pay")
    var product_id="{{Session::get('product_id')}}"
  var address_id="{{Session::get('address_id')}}"
  var car_id="{{Session::get('car_id')}}"
  var date="{{Session::get('date')}}"
  var time="{{Session::get('time')}}"
  var payment_method=pay
  var note=$('.note').val()
  var code="{{Session::get('code')}}"
  var quantity="{{Session::get('qty')}}"
  var user_id={{Auth::user()->id}}
  $.ajax({
        url:'{{route('website.orders.add')}}',
        type: "post",
   
        data:{
          "_token": "{{ csrf_token() }}",
          product_id:product_id,
          address_id:address_id,
          car_id:car_id,
          date:date,
          time:time,
          payment_method:2,
          note:note,
          code:code,
          quantity:quantity,
          user_id:user_id
        },
        // processData: false,
        // contentType: false,
        success: function (data) {
          if(data.success ==true) {
            Swal.fire({
          text: "Order Placed Successfully",
          icon: "success"
           });
           setTimeout(function() {
            window.location.href = "{{route('website.orders.index')}}";
           },1500)
          
          }
          else {
            Swal.fire({
          text: "Order Not Placed Successfully",
          icon: "error"
           });
          }
           
      },
    });
  });

  $(document).on('click','.pay_button_credit',function(event) {
    event.preventDefault();
    pay=$(this).data("pay")
    var product_id="{{Session::get('product_id')}}"
  var address_id="{{Session::get('address_id')}}"
  var car_id="{{Session::get('car_id')}}"
  var date="{{Session::get('date')}}"
  var time="{{Session::get('time')}}"
  var payment_method=pay
  var note=$('.note').val()
  var code="{{Session::get('code')}}"
  var quantity="{{Session::get('qty')}}"
  var user_id={{Auth::user()->id}}
  $.ajax({
        url:'{{route('website.orders.addOrderWithcredit')}}',
        type: "post",
   
        data:{
          "_token": "{{ csrf_token() }}",
          product_id:product_id,
          address_id:address_id,
          car_id:car_id,
          date:date,
          time:time,
          payment_method:1,
          note:note,
          code:code,
          quantity:quantity,
          user_id:user_id
        },
        // processData: false,
        // contentType: false,
        success: function (data) {
          if(data.success ==true) {
            if(data.hasUrl==true) {
              window.location.href = data.url;
            }
            else {

            }
        }
        else {
          Swal.fire({
          text: "Some Thing Wrong",
          icon: "error"
           });
        }
           
      },
    });
  });

</script>
<script>
/*  function DisableBackButton(){
 window.history.forward()
}
DisableBackButton();
window.onload = DisableBackButton;
window.onpageshow = function(evt) { if (evt.persisted) DisableBackButton() }
window.onload = function() {void(0)}*/
  </script>
@endsection