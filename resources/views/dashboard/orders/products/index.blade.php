<style>
    .main-panel {
        background-color: #ebebeb;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@extends('layouts.Dashboard.main')

@section('content')



    <div class="container mt-4">
        <div class="row" style="">

            <div class="col-12 grid-margin">
                <div class="card" style="background-color: white;">
                    <div class="card-body">
                        <h2 style="font-weight:bold;"> {{ __('dashboard/orders.client_details') }} </h2>

                        <ul>

                            <li style="padding:3px 0;">{{ __('dashboard/orders.client_name') }}
                                :{{ $order->customers_name }}
                            </li>



                            <li style="padding:3px 0;">
                                {{ __('dashboard/orders.phone') }} :
                                <span style="color:#99c7e3">{{ $order->customers_phone }}</span>

                            </li>


                            {{-- <li style="padding:3px 0;">
                                {{ __('dashboard/orders.email') }} :
                                <span>{{ $order->email }}</span>

                            </li> --}}

                        </ul>




                    </div>
                </div>
            </div>





        </div>

        <div class="row">

            <div class="col-12 grid-margin">
                <div class="card" style="background-color: white;box-shadow: 0px 0px 0px 2px #e9c9b3;">
                    <div class="card-body">
                        <h2 style="color:#e9c9b3;font-weight:bold;">{{ __('dashboard/driver.ship-det') }} : </h2>

                        <ul>

                            {{-- <li>{{ __('dashboard/driver.name') }} :{{ $order->delivery_name }}</li>
                            <li>{{ __('dashboard/driver.phone') }} :

                                <a style="color:#0090E7"
                                    href="tel:{{ $order->billing_phone }}">{{ $order->delivery_phone }}</a>
                            </li> --}}

                            <li style="padding:3px 0;"> {{ __('dashboard/orders.address') }} :<br>

                                <ul>
                                    <li>Name : {{ $order->address->name }} </li>
                                    <li>Address : {{ $order->address->address }}</li>
                                    <li>City : {{ $order->address->city }}</li>
                                    <li>Street : {{ $order->address->street }}</li>
                                    <li>State : {{ $order->address->state }}</li>
                                </ul>


                            </li>


                            @if ($order->driver_id)
                                <li>{{ __('dashboard/driver.driv-name') }}:
                                    <span style="color:#99c7e3">{{ $order->driverName->name }} </span>
                                </li>
                                <li>{{ __('dashboard/driver.driv-phone') }}:
                                    <span style="color:#99c7e3">{{ $order->driverName->phone }} </span>
                                </li>
                                {{-- @if ($order->driver_location) --}}
                                <li> {{ __('dashboard/driver.ship-stat') }}</li>
                                <div id='map' class=' border border-secondary rounded'
                                    style='height:400px; width:100%;'></div>
                                {{-- @else
                                    <li>
                                        {{ __('dashboard/driver.driv-stat') }}

                                    </li>
                                @endif --}}
                            @else
                                <li>
                                    {{ __('dashboard/driver.ship-stat') }} :
                                    <span>
                                        {{ __('dashboard/driver.ship-stat-2') }}

                                    </span>
                                </li>





                                <form
                                    style="  background: white;  border: 1px solid #e4e6fc;padding: 20px;margin-top: 20px;"
                                    action={{ route('dashboard.orders.driver') }} method=post>
                                    @csrf
                                    <input hidden name='order_id' value="{{ $order->orders_id }}">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label>
                                                {{ __('dashboard/driver.driv-select') }}


                                            </label>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <select class="form-control" name='driver_id'
                                                        style='background-color:white;color:grey'>
                                                        @foreach ($drivers as $driver)
                                                            <option value={{ $driver->id }}
                                                                @once
{{ 'selected' }} @endonce>
                                                                {{ $driver->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-sm-6">
                                                    <button type='submit' class='btn btn-outline-warning btn-icon-text'>
                                                        <i class='mdi mdi-pencil btn-icon-prepend'></i>
                                                        {{ __('dashboard/driver.driv-assign') }}

                                                    </button>
                                                </div>
                                            </div>

                                        </div>


                                    </div>





                                </form>
                            @endif





                        </ul>




                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card" style="background-color: white;">
                    <div class="card-body">
                        <h2 style="font-weight:bold;"> {{ __('dashboard/orders.demand_stats') }} :</h2>
                        <h6>{{ __('dashboard/orders.total_price') }} :{{ $total }} </h6>
                        <h6>{{ __('dashboard/orders.Price_after_discount') }} :{{ $total_after_discount }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ">

            <div class="col-12 grid-margin">
                <div class="card" style="background-color: white;">
                    <div class="card-body">
                        <div style="display: flex;justify-content: space-between;">
                            <h4 class="card-title " style="font-weight:bold;">
                                {{ __('dashboard/orders.Required_Products') }} :</h4>

                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>

                                        <th> {{ __('dashboard/orders.Product_ID') }} </th>
                                        <th>{{ __('dashboard/orders.product_name') }} </th>
                                        <th>{{ __('dashboard/orders.Required_quantity') }} </th>
                                        <th> {{ __('dashboard/orders.Product_price') }} </th>
                                        <th> {{ __('dashboard/orders.Price_after_discount') }} </th>

                                    </tr>
                                </thead>
                                <tbody>





                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            @if ($order->coupon_code)
                <div class="col-12 grid-margin">
                    <div class="card" style="background-color: white;">
                        <div class="card-body">
                            <div style="display: flex;justify-content: space-between;">
                                <h4 class="card-title " style="font-weight:bold;">
                                    {{ __('dashboard/orders.use-coupons') }}:</h4>

                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>

                                            <th> {{ __('dashboard/orders.coupon-id') }}
                                            </th>
                                            <th>{{ __('dashboard/orders.coupon-code') }}
                                            </th>
                                            <th>{{ __('dashboard/orders.coupon-amount') }}
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>




                                        <tr>
                                            <td> {{ $order->code['coupans_id'] }} </td>
                                            <td> {{ $order->code['code'] }} </td>
                                            <td> {{ $order->code['amount'] }} </td>
                                        </tr>



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="row" style="color: black;">

            <div class="col-12 grid-margin">
                <div class="card" style="background-color: white;">
                    <div class="card-body" style="padding-left:35px;">
                        <h2 style="font-weight:bold;">{{ __('dashboard/orders.Edit_order_status') }} :</h2>

                        <div style="color: black;">


                            <form action={{ route('dashboard.orders.updateStatus') }} method=post>
                                @csrf
                                <input hidden name='orders_id' value="{{ $order->id }}">

                                <div class="row">
                                    <div class="col-6">
                                        <label>{{ __('dashboard/orders.Status_selection') }} :</label>
                                    </div>
                                    <div class="col-6">
                                        <select name='orders_status' class="form-control"
                                            style='background-color:white;color:grey;width:70%'>
                                            <option value="" hidden>
                                                {{ __('dashboard/orders.pending') }}
                                            </option>
                                            @foreach ($orders_status as $status)
                                                <option value="{{ $status->id }}"
                                                    @if ($order->currents->orders_status_id == $status->id) selected @endif>
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <br>
                                <label>{{ __('dashboard/orders.Leave_a_comment') }} :</label><br>
                                <input type=text name='comments' class="form-control"><br>
                                <button type='submit' class='btn btn-outline-warning btn-icon-text'>
                                    <i class='mdi mdi-pencil btn-icon-prepend'></i>{{ __('dashboard/orders.Edit') }}
                                </button>
                            </form>



                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection

<script>
    (g => {
        var h, a, k, p = "The Google Maps JavaScript API",
            c = "google",
            l = "importLibrary",
            q = "__ib__",
            m = document,
            b = window;
        b = b[c] || (b[c] = {});
        var d = b.maps || (b.maps = {}),
            r = new Set,
            e = new URLSearchParams,
            u = () => h || (h = new Promise(async (f, n) => {
                await (a = m.createElement("script"));
                e.set("libraries", [...r] + "");
                for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                e.set("callback", c + ".maps." + q);
                a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                d[q] = f;
                a.onerror = () => h = n(Error(p + " could not load."));
                a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                m.head.append(a)
            }));
        d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() =>
            d[l](f, ...n))
    })
    ({
        key: "AIzaSyDCSt4ABayMg8O3n9Hvxb_vrs_1oUfWXuA",
        v: "weekly"
    });
</script>
@section('additional_scripts')
    <!--google map scripts-->
    <script>
        var marker;
        var marker2;
        var map;
        var pos;
        var pinBackground;
        var onChangeHandler
        var add = "{{ $order->address }}";
        var add_bool = (add == '') ? false : true;
        // console.log(add_bool);
        var loc = "{{ $order->driverName }}";

        var loc_bool = (loc == '') ? false : true;
        // console.log(loc_bool);
        @if ($order->driverName != '')
            if (loc_bool) {
                // var cor = "{{ $order->driver_location }}";

                var cor = "{{ $order->driverName->address->loc_lat }},{{ $order->driverName->address->loc_long }}";
                // console.log(cor);
                cor = cor.split(',')


                var clinic_lat = cor[0];
                var clinic_lng = cor[1];

                pos = {
                    lat: parseFloat(clinic_lat),
                    lng: parseFloat(clinic_lng)
                };
            }
        @endif
        var cor2 = "{{ $order->address->loc_lat }},{{ $order->address->loc_long }}";
        // console.log(cor,'hi');
        // console.log(cor2,'b');
        cor2 = cor2.split(',')
        var clinic_lat2 = cor2[0];
        var clinic_lng2 = cor2[1];




        const pos2 = {
            lat: parseFloat(clinic_lat2),
            lng: parseFloat(clinic_lng2)
        };

        // console.log(pos);
        // console.log(pos2);
        async function initMap() {
            // Request needed libraries.
            const {
                Map
            } = await google.maps.importLibrary("maps");
            const {
                AdvancedMarkerElement,
                PinElement
            } = await google.maps.importLibrary("marker");
            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer();








            //customize markers
            const icon2 = document.createElement("div");

            icon2.innerHTML = '<i class="fa-solid fa-truck-fast  fa-lg"></i>';

            pinBackground = new PinElement({
                glyph: icon2,
                glyphColor: "#000",
                background: "#fff",
                borderColor: "#000",
            });
            const icon = document.createElement("div");

            icon.innerHTML = '<i class="fa-solid fa-circle-user fa-lg"></i>';

            const faPin = new PinElement({
                glyph: icon,
                glyphColor: "#000",
                background: "#fff",
                borderColor: "#000",
            });
            //end customize marker


            map = new Map(document.getElementById("map"), {
                zoom: 18,
                center: pos,
                mapId: "driver_map",
                scrollwheel: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: true,
                zoomControl: true,
                fullscreenControl: true,
            });



            //direction  service
            directionsRenderer.setMap(map);
            if (loc_bool) {
                calculateAndDisplayRoute(directionsService, directionsRenderer, pos, pos2);



                onChangeHandler = function(pos) {
                    calculateAndDisplayRoute(directionsService, directionsRenderer, pos, pos2);
                };
            }

            //   document.getElementById("start").addEventListener("change", onChangeHandler);
            //  document.getElementById("end").addEventListener("change", onChangeHandler);




            const locationButton = document.createElement("button");

            locationButton.textContent = "Pan to Current Location";
            locationButton.classList.add("custom-map-control-button");
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);

            locationButton.addEventListener("click", () => {
                map.setCenter(pos);
            });





            //end direction  service


            //markers init
            if (loc_bool && add_bool) {

                // The marker, positioned at the clinic
                marker = new AdvancedMarkerElement({
                    map: map,
                    position: pos,
                    title: "driver",
                    content: pinBackground.element,
                });
            }
            marker2 = new AdvancedMarkerElement({
                map: map,
                position: pos2,
                title: "customer",
                content: faPin.element,
            });
            //end marker init

        }




        function calculateAndDisplayRoute(directionsService, directionsRenderer, pos, pos2) {


            directionsService
                .route({
                    origin: pos,
                    destination: pos2,
                    // Note that Javascript allows us to access the constant
                    // using square brackets and a string value as its
                    // "property."
                    travelMode: google.maps.TravelMode['TWO_WHEELER'],
                })
                .then((response) => {
                    directionsRenderer.setDirections(response);
                })
                .catch((e) => window.alert("Directions request failed due to " + status));
        }

        initMap();

        // marker2.setMap(map);
        // if (loc_bool) {
        //     get_cor();
        //     setInterval(function() {
        //         get_cor(); // this will run after every 5 seconds
        //     }, 5000);
        // }

        function get_cor() {
            $.ajax({
                type: 'get',
                url: "{{ route('dashboard.orders.driver.location.api', ['order_id' => $order->id]) }}",

                success: function(data) {

                    cor = data.split(',');
                    //   console.log(cor);
                    let latlng = new google.maps.LatLng(cor[0], cor[1]);
                    // let latlng = cor[0]+','+ cor[1]+'}';

                    //           pos = {
                    //     lat: parseFloat(clinic_lat),
                    //     lng: parseFloat(clinic_lng)
                    // };

                    if (!add_bool) {
                        onChangeHandler(latlng, pos2);
                    } else {
                        marker.position = latlng;
                    }
                },
                error: function(rejest) {
                    alert('fail');
                }

            });
        }
    </script>
@endsection
