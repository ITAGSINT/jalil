@extends('layouts.website.main')
@section('additional_styles')
<style>
    .row {
    --bs-gutter-x: 0 !important;
    --bs-gutter-y: 0;}
    .emptyspace {
    height: 10px !important;
}
.product_card h5{font-size: 18px !important;}
.select_size:hover {
    background: var(--text-color);
    color: white;
}
</style>
<style>
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
  .ftco-navbar-light .nav-item.cta > span {
    color: #fff !important;
    background: #c2b6ff;
    border: none !important;
}
  .ftco-navbar-light .nav-item.cta > a {
    color: #fff !important;
    background: #c2b6ff;
    border: none !important;
}
  .ftco-navbar-light .navbar-nav > .nav-item > .nav-link{color:white;}
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
  opacity: 1; }

@-webkit-keyframes pulsate {
  0% {
    -webkit-transform: scale(0.1, 0.1);
    opacity: 0.0; }
  50% {
    opacity: 1.0; }
  100% {
    -webkit-transform: scale(1.2, 1.2);
    opacity: 0.0; } }

  </style>
@endsection

@section('content')
  <section class="ftco-section">
    	<div class="container">


        <div class="row" style="display:flex;    padding-top: 20px;">
            <div class="col-md-2" ></div>
                <div class="col-md-8" style=" ">
                   <div id="prepared_id">
                       @php
                       $i=0;
                       @endphp
                  @foreach($products as $products)
                    <div class="row product_card"  >
                        <div class="col-sm-3" style="">
                            <img src="{{URL::asset((!is_null($products->mainImage)?$products->mainImage->path():'prod.png'))}}" class="fit_image">
                        </div>
                        <div class="col-sm-9" style="position: relative; padding-left: 10px;   padding-right: 80px;padding-top: 15px;">
                              <form method="POST" action="{{ route('destroy.like') }}" >
                         @csrf
                        <input type="hidden" name="product_id" value="{{$products->products_id}}" >
                        <button type="submit" class="btn btn-white" style=" float: right;width: 40px;height: 40px;"  onclick="delete_product({{$products->products_id}})">X</button>

                        </form>
                            
                            <h5 style="font-size: 18px;color: #a8a8a8;">{{ $products->description->products_name }}</h5>
                           
                            <p>{{ $products->description->products_description }}</p>
                            <h1 style="font-size: 16px;color: #a8a8a8;" >{{ $products->products_price }}<span class="currency_span">AED</span></h1>
                            <form id="destroylike_form" action="{{route('destroy.like')}}" method="POST" class="d-none">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$products->products_id}}" >
                            </form>
                            <div style="padding-top: 50px;display: flex;">
                                
                            <a  style="    background: white;border: 0px;display: flex;" onclick="event.preventDefault();
                                                        document.getElementById('destroylike_form').submit();">
                            <i class="fa  fa-heart hide_element like_pro"  style="color: white;border-color: red;background: red;"></i>

                            </a>                           
                            <button class="btn btn-white p-2" style="    text-decoration: none;width: 100%;padding: 0;" onclick="location.href='/product?id={{$products->products_id}}'" > Read more</button>
                            </div> 
                            <div class="b_product_card">
                            <h1 style="font-size: 20px;color: #a8a8a8;    text-align: right;    margin: 0;" ></h1>
                            <hr>
                            </div>
                        </div>
                    </div>
                    @php
                       $i++;
                       @endphp
                  @endforeach
                 
                    
                    </div>
                    
                </div>
                <div class="col-md-2" ></div>
            </div>
            @if($i==0)
                  <div class="row" style="    padding: 60px 0;     height: 75vh;">
       <div class="col-sm-4"></div> 
        <div class="col-sm-4" style="    display: flex;flex-direction: column;align-items: center;">
            <i class="icon-heart hide_element"  style="     color: #8e8e8e;padding: 8px 7px 5px 7px;font-size: 6rem;"></i>
            <h5 style="color:#8E8E8E;font-size: 21px;margin: 0;padding: 15px 0;">Your favorite is empty</h5>
            <button class="btn btn-white p-2" onclick="location.href='/shop/all'" style="    width: 80%;">Continue shopping</button>
        </div> 
         <div class="col-sm-4"></div> 
    </div>
        @else
        <div style="height: 100px;"></div>
                  @endif
    </div>  </div>
    @endsection
    