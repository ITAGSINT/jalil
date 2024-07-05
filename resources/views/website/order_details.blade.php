@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/no.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/add.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/tyre.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/order-details.css') }}" rel="stylesheet">






<style>

</style>
@endsection
@section('content')
<div class="container">
    <div class="row w-100">
      <div class="col-12 d-flex">
        <a class="btn" href="">
          <i class="fa-solid fa-chevron-left left"></i></a>
        <p class="add">Order Details</p>
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
              @php
                // Assuming $time is in a format that DateTime can parse, e.g., '2023-06-23 14:00:00'
                $dateTime = new DateTime($order->time);
                $dateTime2 = new DateTime($order->time);
                $dateTime->modify('+1 hour');
                $newTime = $dateTime->format('H:i');
                $oldTime=$dateTime2->format('H:i');
              @endphp

                <p class="arrive">Your order is estimated to arrive <br>
                  between {{$oldTime}} - {{$newTime}}</p>
              </div>

            </div>


            <div class="row w-100 w-100 p-4" style="border-radius: 10px;border:1px solid #f8f9fa;">

              <div class="col-12">


                <div class="container  " >
                  @php
                  $customer=$order->address->loc_lat . ',' . $order->address->loc_long;
                  if(!is_null($order->driverName)) {$driver=$order->driverName->address->loc_lat . ',' . $order->driverName->address->loc_long;}
                  @endphp
                  
                <div id="app">
                  @if(!is_null($order->driverName))
                 <example-component :order="{{$order->id}}" :customer="'{{$customer}}'" :driver="'{{$driver}}'"></example-component> 
                @else 
                <example-component :order="{{$order->id}}" :customer="'{{$customer}}'" :driver="'{{$customer}}'"></example-component> 

                @endif
             

                </div>
                <link rel="stylesheet" href="{{ asset('css/app.css') }}">



    <script 
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCSt4ABayMg8O3n9Hvxb_vrs_1oUfWXuA&loading=async&callback=initMap">
    </script>
    <script src="{{ asset('js/app.js') }}"></script>


                </div>

        


              </div>
            </div>




          </div>
        </div>







        <div class="col-lg-6 col-md-12 row mx-0">
          <div class="col-12  ">
            <div class="row w-100 pt-4 " style="border-radius: 10px;border:1px solid #f8f9fa;">
<input type="text" id="order_id" name="order_id" value="{{$order->id}}" hidden>
              <div class="col-12">
                <div class="d-flex">
                  <p>{{$order->order_price}} AED</p>
                  <p class="launch" style="margin-inline-start: auto;">Launch Offer! 100%OFF!</p>
                </div>
                <hr style="width: 50%;opacity: 0.10;">

                <div class="row w-100">
                  <div class="col-2">
                    <i class="bi bi-crosshair"></i>
                  </div>
                  <div class="col-10">
                    <p class="major mx-3 my-auto location">{{$order->address->address}}</p>

                    <p class="location-det">{{$order->address->street}}</p>
                  </div>
                </div>
                <div class="row w-100">
                  <div class="col-2">
                    <i class="bi bi-geo-alt"></i>
                  </div>
                  <div class="col-10">
                    @if(!is_null($order->driverName))
                    <p class="major mx-3 my-auto location">{{$order->driverName->address->address}}</p>

                    <p class="location-det">{{$order->driverName->address->street}}</p>
                      @else
                      <p class="major mx-3 my-auto location">-</p>
                      @endif
                  </div>
                </div>





                <div class="d-flex  align-items-center pb-3">
                @if(!is_null($order->driverName))
                    <img src="{{asset('image/per.png')}}" alt="Avatar" class="person">
                    <p class="major mx-3 my-auto">{{$order->driverName->name}}</p>
                    <a class="tela"><i class="bi bi-telephone-fill teli"></i></a>
                @else
                
                <p class="major mx-0 my-auto location">Driver Not Assigned </p>
                @endif
                 
                </div>
                <div class="col-12 pt-2 for-lap">
                  <p class="order-tyre">@if($order->products->category->id == 3 || $order->products->category->parent_id == 3) Tyre @elseif( $order->products->category->id == 2 || $order->products->category->parent_id == 2) Car Wash @elseif($order->products->category->id == 1 || $order->products->category->parent_id == 1) Battery @endif</p>
                  <li style="list-style: none;"><a class="myli" style="text-decoration: none;">
                      <div class="card mb-3 containtyre">
                        <div class="row g-0 w-100">
                          <div class="col-md-3  g-4">
                            <img src="{{$order->products->main_image}}" class="rounded-start" alt="...">
                          </div>
                          <div class="col-md-9  g-2">
                            <div class="card-body">
                              <h5 class="card-title maxxis">{{$order->products->name}}</h5>
                              <p class="card-text double">{{$order->products->size}}<br>{{$order->products->description}}</p>
                              <p class="card-text small"><small class="text-body-secondary">{{$order->products->products_price}} AED</small></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a></li>
                </div>
                <div class="col-12 for-mobile">
                  <li style="list-style: none;"><a class="myli" style="text-decoration: none;">
                      <div class="card containtyremobile">
                        <img src="image/tyre.png" class="card-img-top mx-auto" alt="...">
                        <div class="card-body">
                          <h5 class="card-title maxxis">{{$order->products->name}}</h5>
                          <p class="card-text double">{{$order->products->size}}<br>{{$order->products->description}}</p>
                          <p class="card-text small"><small class="text-body-secondary">{{$order->products->products_price}} AED</small></p>
                        </div>
                      </div>
                    </a></li>
                </div>














              </div>


            </div>



          </div>
        </div>


        <div class="row w-100  pt-5 ">
          <div class="col-12 d-flex  justify-content-end">
            <a class="btn cancel "  href="javascript:status_cancel()" role="button">Cancel order</a>
            <a class="btn reschedule" href="" role="button">Reschedule order</a>
          </div>
        </div>
      </div>
    </div>



  </div>
@endsection
@section('additional_scripts')

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{ URL::asset('js/changetwo.js')}}"></script>
<script>
    function initMap() {
      // This function is just a placeholder to let Google Maps API load
    }


    function status_cancel(){
      var order_id=  document.getElementById('order_id').value;

      $.ajax({
  url: "{{route('cancel.order')}}",
  type: "get",
  data: {
    order_id: order_id,
  },
  // processData: false,
  // contentType: false,
  success: function(data) {


  },
});



    }
  </script>
@endsection