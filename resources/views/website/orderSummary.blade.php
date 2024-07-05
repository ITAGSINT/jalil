@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/add.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/no.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/addone.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/changetwo.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/addresses.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/carwash.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
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
    <p class="toptext"></p>
</div>


@if(session()->has('product_id') && session()->has('address_id') && session()->has('car_id') && session()->has('time') && session()->has('date') && session()->has('time2') && session()->has('date2'))

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
            <div class="col-lg-6 col-md-12 row mx-0" style="border-radius: 10px;border:1px solid #F8F9FA; ">
                <div class="col-12 ">

                    <div class="row w-100 p-2 pt-4">
                        <div class="col-12 ">
                            <p class="emirate">Offer Promo Codes</p>
                        </div>

                    </div>

                    <div class="row w-100  pt-1   address ">
                        <div class="col-10">
                            <div class="input-group  mx-0">
                                <input id="apply_input" type="text" class="form-control   Current-Location" placeholder="Enter code here" aria-label="Username" aria-describedby="basic-addon1">
                                
                            </div>
                            <smal class="apply_msg"></smal>
                        </div>
                        <div class="col-2">
                            <a class="btn apply">Apply</a>
                        </div>




                    </div>
                    <div class="row w-100 w-100 ">
                        <div class="col-12 ">
                            <p class="emirate">Offer Promo Codes</p>
                        </div>
                        <div class="col-12">
                            <div class="container country" style="background-color: #F8F9FA;border-radius: 12px;">

                                <p class="chinese pt-3"> {{$product->name}}</p>


                                <p class="launch">{{$product->promotional_text}}</p>
                                <div>
                                    <p class="available">{{$product->description}}</p>
                                </div>
                                <div class="d-flex align-content-end justify-content-end">
                                    <p class="available"> {{$product->products_price}} AED</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row w-100 w-100 pt-4 pb-2">
                        <div class="col-12 ">
                            <p class="emirate">Offer Promo Codes</p>
                        </div>
                        <div class="col-6 px-0 mx-0">
                            <input readonly type="text" id="myInputone" placeholder="Sat, Mar 16th" class="myInputfour" value="{{$date2}}" />
                        </div>
                        <div class="col-6">
                            <input readonly type="text" id="myInputfour" placeholder="4 pm - 5 pm" class="myInputfour" value="{{$time2}}"/>
                        </div>
                    </div>

                </div>
            </div>







            <div class="col-lg-6 col-md-12 row mx-0" style="border-radius: 10px;border:1px solid #f8f9fa; ">
                <div class="col-12  ">
                    <div class="row w-100 pt-4 ">
                        <div class="col-12 ">
                            <p class="emirate">Address</p>
                            <div id="map"  class='rounded my-2 img-fluid' style='height:100px; width:100%;'></div>


                        </div>
                        <div class="col-12 mb-4" style="background-color: #16330014;border-radius: 16px;">
                            <div class="row">
                                <div class="col-2 pt-3">
                                    <i class="bi bi-geo-alt location-icon"></i>
                                </div>
                                <div class="col-10">
                                    <p class="location-name">{{$address->name}}</p>
                                    <p class="location-name-details">{{$address->state}}. {{$address->city}}, {{$address->street}}</p>
                                </div>
                            </div>
                        </div>

@foreach($car as $car)
                        <div class="col-12 carmarkone position-relative align-items-center justify-content-center" style="background-color: #16330014;border-radius: 16px;">
                            <div class="col-12 align-items-center justify-content-center pt-2">
                                <img src="{{$car->model_image}}" class="w-100">
                            </div>
                            <p class="cartype p-0 m-0">{{$car->model->manufacture->name}} {{$car->model->name}}</p>
                            <p class="carstyle p-0 m-0">{{$car->plate_num}} <br>{{$car->color_name}}</p>

                        </div>
                        @endforeach
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row w-100 d-flex align-items-center justify-content-center pt-5">
        <div class="col-6">
        <form method="POST" action="{{route('website.storeCouponInSession')}}">
        @csrf
        <input type="text" id="code"  name="code"  value="" hidden>
        <input type="text" id="discount"  name="discount"  value="0" hidden>
        <input type="text" id="old_total"  name="old_total"  value="{{$product->products_price*Session::get('qty')}}" hidden>
        <input type="text" id="new_total"  name="new_total"  value="{{$product->products_price*Session::get('qty')}}"hidden >
        
        <button type="submit" class="btn next w-100 mx-0" style="">Add payment method</button>
        
     
      </form>
          {{-- <a class="btn next w-100 mx-0" href="{{route('website.how')}}" role="button">Add payment method</a>--}}
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
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>


<script src="{{URL::asset('js/changetwo.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCSt4ABayMg8O3n9Hvxb_vrs_1oUfWXuA&callback=initMap" async defer></script>
<script>
        let map;
        function initMap() {
            // Default location (center of the map)
            const defaultLocation = { lat: -34.397, lng: 150.644 };

            // Create a map object and specify the DOM element for display.
            map = new google.maps.Map(document.getElementById('map'), {
                center: defaultLocation,
                zoom: 8,
            });

            // Set the location from the server
            const location = {
                lat: {{ session()->has('address_id') ? $address->loc_lat : -34.397}},
                lng: {{session()->has('address_id') ? $address->loc_long : 150.644}}
            };

            // Center map on the location
            map.setCenter(location);

            // Place a marker on the location
            new google.maps.Marker({
                position: location,
                map: map,
            });
        }
$(document).on('click','.apply',function(event) {
    var product_id={{session()->has('product_id') ? $product->id : ''}};
    var product_price={{session()->has('product_id') ?  $product->products_price : ''}}
    var code=$('#apply_input').val();
    var qty={{Session::get('qty')}}
    var total=qty*product_price
    $.ajax({
        url:'{{ route('website.checkCopon') }}',
        type: "get",
   
        data:{product_id:product_id,code:code,quantity:qty},
        // processData: false,
        // contentType: false,
        success: function (data) {
         if(data.success==true){
          $('.apply_msg').text('valid code')
          $('.apply_msg').css({"color": "#9FE870", })
          $('#discount').val(data.data.discount)
          $('#old_total').val(data.data.old_total)
          $('#new_total').val(data.data.new_total)
          $('#code').val(code)
         }
         else {
            $('.apply_msg').text('some thing wrong ,code invalid or expired')
            $('.apply_msg').css({"color": "red", })
            $('#discount').val(0)
          $('#old_total').val(total)
          $('#new_total').val(total)
          $('#code').val("")
           /* $('#apply_input').css({"border": "1px solid red", "outline": "1px solid red"})*/
         }
     
        
      },
    });
});
    </script>
@endsection