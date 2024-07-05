@extends('layouts.website.main')
@section('additional_styles')
@endsection
@section('content')
    @php
        $o_p = '';
    @endphp
    @foreach ($order_products as $order_products)
        @php
            $o_p = $o_p . $order_products->products_id . ',';
        @endphp
    @endforeach
    @php
        $o_p_arr = explode(',', $o_p);
        
    @endphp
    @php
        if (Auth::id() != null) {
            $user_id_Cookie = Auth::id();
        } else {
            if (Cookie::get('user_id') == null) {
                $user_id_Cookie = 0;
            } else {
                $user_id_Cookie = Cookie::get('user_id');
            }
        }
        
    @endphp
    <style>
        span.mr-2.price-dc {
            text-decoration: line-through;
            color: #c2c2c2;
        }

        .table tbody tr td {
            text-align: center !important;
            vertical-align: middle;
            padding: 10px !important;
            border: 1px solid #dee2e6 !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
        }

        .table {
            min-width: 100% !important;
            width: 100%;
            text-align: center;
        }

        .beep {
            position: relative;
        }

        .beep:after {
            content: '';
            position: absolute;
            top: 3px;
            right: -23px;
            width: 15px;
            height: 15px;
            background-color: #c2b6ff;
            border-radius: 50%;
            -webkit-animation: pulsate 1s ease-out;
            animation: pulsate 1s ease-out;
            -webkit-animation-iteration-count: infinite;
            animation-iteration-count: infinite;
            opacity: 1;
        }

        .ftco-navbar-light .nav-item.cta>span {
            color: #fff !important;
            background: #c2b6ff;
            border: none !important;
        }

        .ftco-navbar-light .nav-item.cta>a {
            color: #fff !important;
            background: #c2b6ff;
            border: none !important;
        }

        .ftco-navbar-light .navbar-nav>.nav-item>.nav-link {
            color: white;
        }

        .ftco-navbar-light {
            background: #00000054 !important;
            z-index: 3;
            padding: 0;
        }

        .ftco-section {
            padding: 5em 0 4em !important;
            position: relative;
        }

        /* 4.5 Animation */
        .pulsate {
            -webkit-animation: pulsate 1s ease-out;
            animation: pulsate 1s ease-out;
            -webkit-animation-iteration-count: infinite;
            animation-iteration-count: infinite;
            opacity: 1;
        }

        @-webkit-keyframes pulsate {
            0% {
                -webkit-transform: scale(0.1, 0.1);
                opacity: 0.0;
            }

            50% {
                opacity: 1.0;
            }

            100% {
                -webkit-transform: scale(1.2, 1.2);
                opacity: 0.0;
            }
        }
    </style>
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 ftco-animate d-flex">
                    <a href="{{ URL::asset(!is_null($product->mainImage) ? $product->mainImage->path() : 'prod.png') }}"
                        class="image-popup"><img
                            src="{{ URL::asset(!is_null($product->mainImage) ? $product->mainImage->path() : 'prod.png') }}"
                            class="img-fluid" alt="Colorlib Template"></a>
                    <div>
                        @php
                            $h = 1;
                        @endphp
                        @foreach ($product->images as $images)
                            @if ($images->parent_id == 0)
                                <div class="lightbox" id="p{{ $h }}">
                                    @if ($images->path2())
                                    @endif
                                    <img src="{{ asset($images->path()) }}" style="width:100px"
                                        id="image_{{ $h }}" class="cursor">
                                </div>
                                @php $h++ ;@endphp
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                    <h3>{{ $product->description->products_name }}</h3>

                    <div class="rating d-flex">
                        @php
                            $r = 0;
                            $count = 0;
                        @endphp
                        @foreach ($product->reviews as $reviews)
                            @php
                                $r += $reviews->reviews_rating;
                                $count++;
                            @endphp
                        @endforeach
                        @php
                            if ($r == 0 || $count == 0) {
                                $rev = 0;
                            } else {
                                $rev = $r / $count;
                            }
                        @endphp

                        @if (!in_array($product->products_id, $o_p_arr))
                            <div class="stop_rating"></div>
                        @endif
                        <p class="text-right ">
                            <a onclick="rating_fun(1,{{ $product->products_id }})"><span
                                    class="rating @if ($rev >= 1) ion-ios-star @else ion-ios-star-outline @endif "></span></a>
                            <a onclick="rating_fun(2,{{ $product->products_id }})"><span
                                    class="rating @if ($rev >= 2) ion-ios-star @else ion-ios-star-outline @endif"></span></a>
                            <a onclick="rating_fun(3,{{ $product->products_id }})"><span
                                    class="rating @if ($rev >= 3) ion-ios-star @else ion-ios-star-outline @endif"></span></a>
                            <a onclick="rating_fun(4,{{ $product->products_id }})"><span
                                    class="rating @if ($rev >= 4) ion-ios-star @else ion-ios-star-outline @endif"></span></a>
                            <a onclick="rating_fun(5,{{ $product->products_id }})"><span
                                    class="rating @if ($rev >= 5) ion-ios-star @else ion-ios-star-outline @endif"></span></a>
                        </p>
                    </div>
                    <div class="pricing">
                        <p class="price">
                            @if ($product->discount_price == 0)
                                <p class="price"><span>${{ $product->products_price }}</span></p>
                            @else
                                <span class="mr-2 price-dc">${{ $product->products_price }}</span><span
                                    class="price-sale">${{ $product->discount_price }}</span>
                            @endif
                        </p>
                    </div>
                    <p>{!! $product->description->products_description !!} </p>
                    <form id="addtolike_form" action="{{ route('add.to.like') }}" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->products_id }}">
                    </form>
                    <form id="destroylike_form" action="{{ route('destroy.like') }}" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->products_id }}">
                    </form>
                    <form id="myform" class="">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="product_id" value="{{ $product->products_id }}">
                        <div class="row mt-4">
                            @foreach ($options as $id => $details)
                                <div class="col-md-6">
                                    {{ $details[0]['option_name'] }}
                                    <select class="  form-control " name="option[{{ $id }}]" id="option"
                                        onchange="changeQuantity({{ $product->products_id }})">

                                        @foreach ($details as $value)
                                            <option value="{{ $value['option_value']['value_id'] }}">
                                                {{ $value['option_value']['value_name'] }} </option>
                                        @endforeach

                                    </select>
                                </div>
                            @endforeach








                        </div>
                        <p class="mt-5"><button type="submit" class="btn btn-black py-3 px-5 mr-2">Add to Cart</button><a
                                onclick="open_avalable()" class="  btn  btn-white py-3 px-5 mr-2">See Available <span
                                    class="beep"></span></span></a></p>
                        <div id="show_div" style="display:none">
                            <a
                                style="float: right;font-size: 28px;padding: 0;margin-bottom: -11px;cursor: pointer;"onclick="close_var()">&times;</a>
                            <table class="table table-bordered" id="cat">

                                <thead>
                                    <tr>
                                        @foreach ($options_v as $option)
                                            <th>{{ $option->name() }} </th>
                                        @endforeach

                                        <th>Quantity</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($variation as $value)
                                        @if ($value->store_product->quantity <= 0)
                                        @else
                                            <tr>
                                                @foreach ($options_v as $option)
                                                    <td>
                                                        @foreach ($value->product_variations_group as $p_variations_g)
                                                            @if ($option->products_options_id == $p_variations_g->options_id)
                                                                {{ $p_variations_g->option_value_name[0]->options_values_name }}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                @endforeach

                                                <td>{{ $value->store_product->quantity }} </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <h2 class="mb-4">Ralated Products</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">

                @foreach ($product_related as $products)
                    <div class="col-sm-6 col-md-6 col-lg-3 ftco-animate">
                        <div class="product pro_{{ $products->products_id }}">
                            <a href="{{ route('website.product', ['id' => $products->products_id]) }}" class="img-prod"><img
                                    class="img-fluid"
                                    src="{{ URL::asset(!is_null($products->mainImage) ? $products->mainImage->path() : 'prod.png') }}"
                                    alt="Colorlib Template">
                                @if ($products->discount_price != 0)
                                    <span class="status">Sale</span>
                                @endif
                                <div class="overlay"></div>
                            </a>
                            <div class="text py-3 px-3">
                                <h3><a
                                        href="{{ route('website.product', ['id' => $products->products_id]) }}">{{ $products->description->products_name }}</a>
                                </h3>
                                <div class="d-flex">
                                    <div class="pricing">
                                        <p class="price">
                                            @if ($products->discount_price == 0)
                                                <p class="price"><span>${{ $products->products_price }}</span></p>
                                            @else
                                                <span class="mr-2 price-dc">${{ $products->products_price }}</span><span
                                                    class="price-sale">${{ $products->discount_price }}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="rating">
                                        @php
                                            $r = 0;
                                            $count = 0;
                                        @endphp
                                        @foreach ($products->reviews as $reviews)
                                            @php
                                                $r += $reviews->reviews_rating;
                                                $count++;
                                            @endphp
                                        @endforeach
                                        @php
                                            if ($r == 0 || $count == 0) {
                                                $rev = 0;
                                            } else {
                                                $rev = $r / $count;
                                            }
                                        @endphp


                                        <p class="text-right ">
                                            <a onclick="rating_fun(1,{{ $products->products_id }})"><span
                                                    class="rating @if ($rev >= 1) ion-ios-star @else ion-ios-star-outline @endif "></span></a>
                                            <a onclick="rating_fun(2,{{ $products->products_id }})"><span
                                                    class="rating @if ($rev >= 2) ion-ios-star @else ion-ios-star-outline @endif"></span></a>
                                            <a onclick="rating_fun(3,{{ $products->products_id }})"><span
                                                    class="rating @if ($rev >= 3) ion-ios-star @else ion-ios-star-outline @endif"></span></a>
                                            <a onclick="rating_fun(4,{{ $products->products_id }})"><span
                                                    class="rating @if ($rev >= 4) ion-ios-star @else ion-ios-star-outline @endif"></span></a>
                                            <a onclick="rating_fun(5,{{ $products->products_id }})"><span
                                                    class="rating @if ($rev >= 5) ion-ios-star @else ion-ios-star-outline @endif"></span></a>
                                        </p>
                                    </div>
                                </div>
                                <div class="bottom-area d-flex px-3">
                                    <a href="#" class="add-to-cart text-center py-2 mr-1"><span><i
                                                class="ion-ios-cart ml-1"></i></span></a>
                                    @if ($products->like() == 0)
                                        <form method="POST" style="width: 100%;" action="{{ route('add.to.like') }}">
                                            @csrf
                                            <input type="hidden" name="product_id"
                                                value="{{ $products->products_id }}">
                                            <button type="submit" style="width: 100%;"
                                                class="btn buy-now text-center py-2">
                                                <i class="ion-ios-heart"></i>
                                            </button>
                                        </form>
                                    @elseif($products->like() == 1)
                                        <form method="POST" style="width: 100%;" action="{{ route('destroy.like') }}">
                                            @csrf
                                            <input type="hidden" name="product_id"
                                                value="{{ $products->products_id }}">
                                            <button type="submit" style="width: 100%;"
                                                class="btn buy-now text-center py-2">
                                                <i class="ion-ios-heart-dislike"></i>
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection






@section('additional_scripts')
    <script>
        $("#myform").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('add.to.card') }}",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,

                success: function(response) { //console.log(response); 
                    if (response.code == 0) {


                        toastr.warning(response.error);
                    } else {
                        console.log(response.msg)
                        toastr.success(response.msg);
                        //location.reload();
                        if ({{ $user_id_Cookie }} != null) {
                            $.get('{{ route('view.cart.website') }}', {
                                user_id: {{ $user_id_Cookie }}
                            }, function(data) {

                                var div_con = "";
                                if (data.length != 0) {
                                    $('#product_count_id').html(data.length);

                                } else {

                                }

                            }, 'json');
                        }

                    }
                },
                error: function() {
                    console.log('no response');
                }
            });
        });

        function close_var() {
            $('#show_div').slideUp(500);
        }

        function open_avalable() {
            $('#show_div').slideDown(500);
        }
    </script>
@endsection
