@extends('layouts.website.main')
@section('additional_styles')
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<style>
button.owl-prev {
    float: left;
}
button.owl-next {
    float: right;
}
.owl-nav {
    font-size: 40px !important;
    color: #8e8e8e;
    text-align: center;

   position: relative;
    top: -20px;
    padding: 0px 20px;
}
.fa-angle-right {
    padding: 0 0px !important;
}
.b_product_card {
    position: relative;
    bottom: 0;
    width: 100%;
    right: 0;
    padding-right: 47px;
    padding-left: 10px;
}
.product_color {
    width: 15px;
    height: 15px;
    margin: 3px;
    border-radius: 50px;
    box-shadow: -1px 2px 6px rgb(179 177 177 / 29%);
}
    :checked + label {
    
    border-radius: 50%;
    background: white;
    border: .8px solid gray;
}
input[type="radio"]{
    visibility:hidden;
    width: 0;
}
.p_id_input {
    display: none;
}
.attr_input {
    display: none;
}
.attr_size_input {
    display: none;
}
.owl-item > div img {
    display: block;
    width: 80% !important;
     margin: 12% 0;
}
.owl-item.center > div img {
    display: block;
    width: 100%!important;
     margin: 0;
   
}
.owl-item > div {
    
   display: flex;
    align-items: center;
justify-content: center;
}
.owl-carousel {
  margin-bottom: -0;
    display: none;
    width: 100%;
    z-index: 1;
}
.owl-item.center > div {
    cursor: auto;
    margin: 0;
    opacity: 1;
        padding: 0px;
       transition: all 1s ease;
}
.owl-item > div {
    cursor: pointer;
        padding: 0px;
    margin: 0;
    transition: all 1s ease;
    opacity: 0.5;
}
a.a_com.active h5 {
    color: #A1A1A1;
    font-weight:bold;
}
.product .hr{
      color: #cecece;
    height: 2px;
}


.owl-item.active.center img {
    display: block;
    width: 100%;
    transition: 1s;
}
button.com_btn {
    font-size: 12px;
    font-weight: bold;
   
    border: none;
    z-index: 3;
    color: #a3a3a3!important;
    border-radius: 30px;
    padding: 3px 26px;
    box-shadow: -1px 2px 4px 0px rgb(179 177 177 / 21%);
    background-image: linear-gradient(to right, #f7f7f7, #e5e5e5);
}
    .row {
    --bs-gutter-x: 0 !important;
    --bs-gutter-y: 0;}
 .close_div a {
    text-align: right;
    color: #676767;
    text-decoration: none;
    cursor: pointer;
    display:none;
} 
.close_div{   
    width: 100%;
    text-align: right;
    padding: 5px 4px;
    position: absolute;
    top: 0;
}
.price_div p{
    color: #676767;
    font-size:14px !important;
    margin: 0;
    position: absolute;
    bottom: 0;
    
}
.owl-item p {
    display: none;
}
.price_div {
    width: 100%;
    padding: 0 6px;
}
#choose_id{height: 85%;display: flex;justify-content: center;align-content: center;align-items: center;}
  @media only screen and (max-width: 2400px){.slider_div{height: 1300px;}#choose_id{height: 78%;}}
  @media only screen and (max-width: 2000px){.slider_div{height: 1100px;}}
  @media only screen and (max-width: 1900px){.slider_div{height: 1000px;}}
  @media only screen and (max-width: 1800px){.slider_div{height: 920px;}}
  @media only screen and (max-width: 1700px){.slider_div{height: 860px;}#choose_id{height: 65%;}}
  @media only screen and (max-width: 1600px){.slider_div{height: 800px;}}
  @media only screen and (max-width: 1500px){.slider_div{height: 740px;}}
  @media only screen and (max-width: 1400px){.slider_div{height: 690px;}}
  @media only screen and (max-width: 1300px){.slider_div{height: 600px;}}
  @media only screen and (max-width: 1200px){.slider_div{height: 550px;}}
  @media only screen and (max-width: 1100px){.slider_div{height: 600px;}#choose_id{height: 50%;}#choose_id .big_font{    font-size: 70px;}}
   @media only screen and (max-width: 950px){.slider_div{height: 550px;}}
   @media only screen and (max-width: 800px){.slider_div{height: 480px;}}
   @media only screen and (max-width: 768px){.slider_div{height: 1050px;}}
   @media only screen and (max-width: 600px){.slider_div{height: 780px;}}
    @media only screen and (max-width: 500px){.slider_div{height: 640px;}}
  @media only screen and (max-width: 400px){.slider_div{height: 530px;}}
  @media only screen and (max-width: 350px){.slider_div{height: 440px;}}
</style>
@endsection
@section('content')
    <div class="combination">
        <div class="row" style="display:flex;"> 
            <div class="col-md-1 hide_element" style="box-shadow: 5px 0px 6px rgb(179 177 177 / 29%);z-index: 2;">
                <div style="-webkit-transform: rotate(270deg );    display: flex;flex-wrap: nowrap;flex-direction: column;justify-content: center;align-items: center;">
                     <h1 style="width: 900px;color:#8E8E8E;font-size: 25px;">Make your own combination</h1>
                </div>
            </div>
            <div class="col-md-5 slider_div" style="      padding: 0;position: relative;">
                <div class="emptyspace hide_element"></div>
                <div class="emptyspace hide_element"></div>
                 <h5 class="page_location  hide_element" style="padding-left: 30px;"><a  href="/"> Home </a>><a href="/combination">  Belucci combination maker</a></h5>
                <div class="emptyspace"></div>
                <h5 class="hide_element" style=" color:#A1A1A1;font-size: 14px;font-weight:bold; padding-left: 30px; ">Let the game begin!</h5>
                <hr class="hide_element" style="width:32%;color: #A1A1A1; margin: 0;     margin-left: 30px;">
                <div class="hide_element" style="    padding-bottom: 10px;">
                <div class="div_a_com " style=" padding-left: 30px;">
                    <a class="a_com left_com"><h5 style="font-weight:bold">Clothing</h5></a>|<a class="a_com" id="a_trousers_id" onclick="select_product_fun('card_5')"><h5>Trousers</h5></a>|<a class="a_com" id="a_shirts_id" onclick="select_product_fun('card_4')"><h5>Shirts</h5></a>|<a class="a_com" id="a_coats_id" onclick="select_product_fun('card_6')"><h5>Coats</h5></a>
                </div>
                <div class="div_a_com " style=" padding-left: 30px;">
                    <a class="a_com left_com"><h5 style="font-weight:bold;margin-right:10px">Accessories</h5></a>|<a class="a_com" id="a_ties_id" onclick="select_product_fun('card_7')"><h5>Ties</h5></a>|<a class="a_com" id="a_shoes_id" onclick="select_product_fun('card_3')"><h5>Shoes</h5></a>|<a class="a_com" id="a_scarfs_id" onclick="select_product_fun('card_8')"><h5>Scarfs</h5></a>|<a class="a_com" id="a_belts_id" onclick="select_product_fun('card_1')"><h5>Belts</h5></a>|<a class="a_com" id="a_socks_id" onclick="select_product_fun('card_2')"><h5>Socks</h5></a>
                </div>
                </div>
                <h5 class="only_mobile_element" style=" color: #a3a3a3;font-size: 18px; text-align: center;     border-bottom: 2px solid #ebeaea;padding-bottom: 8px;">Make your own combination</h5>
                
                <div id="choose_id" style="">
                    <h1 class="big_font">Choose <span class="hide_element">to start</span></h1>
                </div>
                <div id="trousers_id">
                    <div class="owl-carousel">
                        @foreach ($products as $product)
                        @foreach ($product->category as $category)
                        @foreach ($category->description as $description )
                        @if($description->categories_id==160)
                        <div><img src="{{URL::asset((!is_null($product->mainImage)?$product->mainImage->path():'prod.png'))}}" alt="" ><p>{{ $product->products_price }}</p><input id="{{$product->products_id}}" type="text"  class="p_id_input" value="{{$product->products_id}}" style="display:none">
                            @php
                           $qw="";
                           $qw_size="";
                           @endphp
                           @foreach ($product->attr as $attr)
                           @php
                           $qw=$attr->options_values_id;
                           @endphp
                           @endforeach
                           @foreach ($product->attr_size as $attr)
                           @php
                           $qw_size=$attr->options_values_id;
                           @endphp
                           @endforeach
                           <input type="text" class="attr_input" value="{{$qw}}"> 
                           <input type="text"  class="attr_size_input" value="{{$qw_size}}"> 
                        </div>
                        
                        @endif
                        @endforeach
                        @endforeach
                        @endforeach
                         </div>              
                </div>
                <div id="shirts_id">
                    <div class="owl-carousel">
                        @foreach ($products as $product)
                        @foreach ($product->category as $category)
                        @foreach ($category->description as $description )
                        @if($description->categories_id==159)
                        <div><img src="{{URL::asset((!is_null($product->mainImage)?$product->mainImage->path():'prod.png'))}}" alt=""><p>{{ $product->products_price }}</p><input id="{{$product->products_id}}" type="text" class="p_id_input" value="{{$product->products_id}}" style="display:none">
                           @php
                           $qw="";
                           $qw_size="";
                           @endphp
                           @foreach ($product->attr as $attr)
                           @php
                           $qw=$attr->options_values_id;
                           @endphp
                           @endforeach
                           @foreach ($product->attr_size as $attr)
                           @php
                           $qw_size=$attr->options_values_id;
                           @endphp
                           @endforeach
                           <input type="text" class="attr_input" value="{{$qw}}"> 
                           <input type="text"  class="attr_size_input" value="{{$qw_size}}"> 
                        </div>
                        @endif
                        @endforeach
                        @endforeach
                        @endforeach
                    </div> 
                </div>
                <div id="coats_id">
                    <div class="owl-carousel">
                        @foreach ($products as $product)
                        @foreach ($product->category as $category)
                        @foreach ($category->description as $description )
                        @if($description->categories_id==158)
                        <div><img src="{{URL::asset((!is_null($product->mainImage)?$product->mainImage->path():'prod.png'))}}" alt=""><p>{{ $product->products_price }}</p><input id="{{$product->products_id}}" type="text"  class="p_id_input" value="{{$product->products_id}}" style="display:none">
                           @php
                           $qw="";
                           $qw_size="";
                           @endphp
                           @foreach ($product->attr as $attr)
                           @php
                           $qw=$attr->options_values_id;
                           @endphp
                           @endforeach
                           @foreach ($product->attr_size as $attr)
                           @php
                           $qw_size=$attr->options_values_id;
                           @endphp
                           @endforeach
                           <input type="text" class="attr_input" value="{{$qw}}"> 
                           <input type="text"  class="attr_size_input" value="{{$qw_size}}"> 
                        </div>
                        @endif
                        @endforeach
                        @endforeach
                        @endforeach
                    </div> 
                </div>
                <div id="ties_id">
                    <div class="owl-carousel">
                        @foreach ($products as $product)
                        @foreach ($product->category as $category)
                        @foreach ($category->description as $description )
                        @if($description->categories_id==161)
                        <div><img src="{{URL::asset((!is_null($product->mainImage)?$product->mainImage->path():'prod.png'))}}" alt=""><p>{{ $product->products_price }}</p>
                        <input class="p_id_input" type="text" value="{{$product->products_id}}" style="display:none">
                          @php
                           $qw="";
                           $qw_size="";
                           @endphp
                           @foreach ($product->attr as $attr)
                           @php
                           $qw=$attr->options_values_id;
                           @endphp
                           @endforeach
                           @foreach ($product->attr_size as $attr)
                           @php
                           $qw_size=$attr->options_values_id;
                           @endphp
                           @endforeach
                           <input type="text" class="attr_input" value="{{$qw}}"> 
                           <input type="text"  class="attr_size_input" value="{{$qw_size}}"> 
                        </div>
                        @endif
                        @endforeach
                        @endforeach
                        @endforeach
                    </div> 
                </div>
                <div id="shoes_id">
                    <div class="owl-carousel">
                        @foreach ($products as $product)
                        @foreach ($product->category as $category)
                        @foreach ($category->description as $description )
                        @if($description->categories_id==162)
                        <div><img src="{{URL::asset((!is_null($product->mainImage)?$product->mainImage->path():'prod.png'))}}" alt=""><p>{{ $product->products_price }}</p><input id="{{$product->products_id}}" type="text"  class="p_id_input" value="{{$product->products_id}}" style="display:none">
                           @php
                           $qw="";
                           $qw_size="";
                           @endphp
                           @foreach ($product->attr as $attr)
                           @php
                           $qw=$attr->options_values_id;
                           @endphp
                           @endforeach
                           @foreach ($product->attr_size as $attr)
                           @php
                           $qw_size=$attr->options_values_id;
                           @endphp
                           @endforeach
                           <input type="text" class="attr_input" value="{{$qw}}"> 
                           <input type="text"  class="attr_size_input" value="{{$qw_size}}"> 
                        </div>
                        @endif
                        @endforeach
                        @endforeach
                        @endforeach
                    </div> 
                </div>
                <div id="scarfs_id">
                    <div class="owl-carousel">
                        @foreach ($products as $product)
                        @foreach ($product->category as $category)
                        @foreach ($category->description as $description )
                        @if($description->categories_id==163)
                        <div><img src="{{URL::asset((!is_null($product->mainImage)?$product->mainImage->path():'prod.png'))}}" alt="" ><p>{{ $product->products_price }}</p><input id="{{$product->products_id}}" type="text"  class="p_id_input" value="{{$product->products_id}}" style="display:none">
                            @php
                           $qw="";
                           $qw_size="";
                           @endphp
                           @foreach ($product->attr as $attr)
                           @php
                           $qw=$attr->options_values_id;
                           @endphp
                           @endforeach
                           @foreach ($product->attr_size as $attr)
                           @php
                           $qw_size=$attr->options_values_id;
                           @endphp
                           @endforeach
                           <input type="text" class="attr_input" value="{{$qw}}"> 
                           <input type="text"  class="attr_size_input" value="{{$qw_size}}"> 
                        </div>
                        @endif
                        @endforeach
                        @endforeach
                        @endforeach
                    </div> 
                </div>
                <div id="belts_id">
                    <div class="owl-carousel">
                        @foreach ($products as $product)
                        @foreach ($product->category as $category)
                        @foreach ($category->description as $description )
                        @if($description->categories_id==164)
                        <div><img src="{{URL::asset((!is_null($product->mainImage)?$product->mainImage->path():'prod.png'))}}" alt=""><p>{{ $product->products_price }}</p><input id="{{$product->products_id}}" type="text" class="p_id_input" value="{{$product->products_id}}" style="display:none">
                             @php
                           $qw="";
                           $qw_size="";
                           @endphp
                           @foreach ($product->attr as $attr)
                           @php
                           $qw=$attr->options_values_id;
                           @endphp
                           @endforeach
                           @foreach ($product->attr_size as $attr)
                           @php
                           $qw_size=$attr->options_values_id;
                           @endphp
                           @endforeach
                           <input type="text" class="attr_input" value="{{$qw}}"> 
                           <input type="text"  class="attr_size_input" value="{{$qw_size}}"> 
                        </div>
                        @endif
                        @endforeach
                        @endforeach
                        @endforeach
                    </div> 
                </div>
                <div id="socks_id">
                    <div class="owl-carousel">
                        @foreach ($products as $product)
                        @foreach ($product->category as $category)
                        @foreach ($category->description as $description )
                        @if($description->categories_id==165)
                        <div><img src="{{URL::asset((!is_null($product->mainImage)?$product->mainImage->path():'prod.png'))}}" alt=""><p>{{ $product->products_price }}</p><input id="{{$product->products_id}}" type="text"  class="p_id_input" value="{{$product->products_id}}" style="display:none">
                            @php
                           $qw="";
                           $qw_size="";
                           @endphp
                           @foreach ($product->attr as $attr)
                           @php
                           $qw=$attr->options_values_id;
                           @endphp
                           @endforeach
                           @foreach ($product->attr_size as $attr)
                           @php
                           $qw_size=$attr->options_values_id;
                           @endphp
                           @endforeach
                           <input type="text" class="attr_input" value="{{$qw}}"> 
                           <input type="text"  class="attr_size_input" value="{{$qw_size}}"> 
                        </div>
                        @endif
                        @endforeach
                        @endforeach
                        @endforeach
                    </div> 
                </div>
                <div style="position: absolute; bottom: 8px;     width: 100%;  ">
                    <hr style="  color: #cecece;height: 2px;   margin-bottom: 8px;">
                    <h5 style="color: #a3a3a3;font-size: 15px;float: right; "><span style="font-weight:normal">My combination is done</span><button type="button" class=" com_btn"  style="margin: 0px 9px;padding: 7px 16px;font-weight:800;"  onclick="add_to_popup()" >Select details</button></h5>
                </div>
            </div>
            <div class="col-md-6 col-s-12 row" >
             
                    <div class=" col-4 com_shadow com_div">
                        <div class="com_card" id="card_1" style="border-bottom: 2px solid #f1f1f1;    height: 30%" >
                            <div class="cover_com" onclick="skip_remove_fun('card_1')"></div> 
                            <div class="close_div"><a onclick="un_select_product_fun('card_1')">X</a></div>
                            <img  style="width: 40% !important;    /*padding: 20px 0;*/" onclick="select_product_fun('card_1')" src="{{asset('/assets/img/belt.png')}}">
                            <div  class="btn_div" style="    margin-top: -20px;">
                                <h5 style="padding-bottom: 9px; !important">Belts</h5>
                                <button type="button" class=" com_btn" onclick="select_product_fun('card_1')">Select</button>
                                <a class="a_com"  onclick="skip_fun('card_1')"><h5>Skip</h5></a>
                            </div>
                            <form method="POST"  id="form_card_1">
                              @csrf
                            <input type="text" class="product_id_choosen p_id_input" name="product_id">
                            <input type="text" name="color_Att" class="attr_input">
                            <input type="text" name="color_Att1" class="attr_size_input">
                            </form>
                            <div class="price_div"><p></p></div>
                        </div>
                        <div class="com_card" id="card_2" style="border-bottom: 2px solid #f1f1f1;    height: 40%;">
                            <div class="cover_com" onclick="skip_remove_fun('card_2')" ></div> 
                            <div class="close_div"><a onclick="un_select_product_fun('card_2')">X</a></div>
                            <img  style="width: 23% !important;/*padding: 35px 0;*/" onclick="select_product_fun('card_2')"  src="{{asset('/assets/img/socks.png')}}">
                            <div  class="btn_div" style="margin-top:-47px">
                                <h5 style="padding-bottom: 30px;">Socks</h5>
                                <button type="button" class=" com_btn" onclick="select_product_fun('card_2')">Select</button>
                                <a class="a_com" onclick="skip_fun('card_2')"><h5>Skip</h5></a>
                            </div>
                            <form method="POST" action="{{ route('add.to.card2') }}" id="form_card_2">
                              @csrf
                            <input type="text" class="product_id_choosen p_id_input" name="product_id">
                            <input type="text" name="color_Att" class="attr_input">
                            <input type="text" name="color_Att1" class="attr_size_input">
                            </form>
                            
                            <div class="price_div"><p></p></div>
                            <hr>
                        </div>
                        <div class="com_card" id="card_3" style=" height: 30%;">
                            <div class="cover_com" onclick="skip_remove_fun('card_3')"></div> 
                            <div class="close_div"><a onclick="un_select_product_fun('card_3')">X</a></div>
                            <img style="width: 44% !important;   /* padding: 29px 0;*/" onclick="select_product_fun('card_3')" src="{{asset('/assets/img/shoes.png')}}">
                            <div  class="btn_div" style="margin-top: -30px;">
                                <h5  style="padding-bottom: 20px;" >Shoes</h5>
                                <button type="button" class=" com_btn"  onclick="select_product_fun('card_3')">Select</button>
                                <a class="a_com" onclick="skip_fun('card_3')"><h5>Skip</h5></a>
                            </div>
                           <form method="POST" action="{{ route('add.to.card2') }}" id="form_card_3">
                              @csrf
                            <input type="text" class="product_id_choosen p_id_input" name="product_id">
                            <input type="text" name="color_Att" class="attr_input">
                            <input type="text" name="color_Att1" class="attr_size_input">
                            </form>
                            <div class="price_div"><p></p></div>
                        </div>
                    </div>
                    <div class="col-4 com_div ">
                        <div class="com_card" id="card_4" style="border-bottom: 2px solid #f1f1f1; height: 45%;">
                            <div class="cover_com" onclick="skip_remove_fun('card_4')"></div> 
                            <div class="close_div"><a onclick="un_select_product_fun('card_4')">X</a></div>
                            <div class="emptyspace"></div>
                            <img style="width: 40% !important;padding:16px 0" onclick="select_product_fun('card_4')"  src="{{asset('/assets/img/Shirts.png')}}">
                            <div  class="btn_div" style="margin-top: -55px !important;">
                                <h5 style="padding-bottom: 29px;">Shirts</h5>
                                <button type="button" class=" com_btn" onclick="select_product_fun('card_4')">Select</button>
                                <a class="a_com" onclick="skip_fun('card_4')"><h5>Skip</h5></a>
                            </div>
                            <div class="emptyspace"></div> <div class="emptyspace"></div>
                            <form method="POST" action="{{ route('add.to.card2') }}" id="form_card_4">
                              @csrf
                            <input type="text" class="product_id_choosen p_id_input" name="product_id">
                            <input type="text" name="color_Att" class="attr_input">
                            <input type="text" name="color_Att1" class="attr_size_input">
                            </form>
                            <div class=""></div><div></div>
                            <div class="price_div"><p></p></div>
                            
                            <hr>
                        </div>
                        <div class="com_card" id="card_5" style=" height: 55%;  ">
                            <div class="cover_com" onclick="skip_remove_fun('card_5')"></div> 
                            <div class="close_div"><a onclick="un_select_product_fun('card_5')">X</a></div>
                            <div class="emptyspace"></div> <div class="emptyspace"></div>
                            <img style="width: 30% !important;   /* padding: 0px 0;*/" onclick="select_product_fun('card_5')" src="{{asset('/assets/img/trousers.png')}}">
                            <div  class="btn_div" style="margin-top: -63px;">
                                <h5 style="padding-bottom: 83px;">Trousers</h5>
                                <button type="button" class=" com_btn" onclick="select_product_fun('card_5')">Select</button>
                                <a class="a_com" onclick="skip_fun('card_5')"><h5>Skip</h5></a>
                            </div>
                            <div class="emptyspace" style="height: 40px;"></div>
                            <div class="emptyspace"></div>
                           <form method="POST" action="{{ route('add.to.card2') }}" id="form_card_5">
                              @csrf
                            <input type="text" class="product_id_choosen p_id_input" name="product_id">
                            <input type="text" name="color_Att" class="attr_input">
                            <input type="text" name="color_Att1" class="attr_size_input">
                            </form>
                            <div class="price_div"><p></p></div>
                        </div>
                    </div>
                    <div class="col-4 com_shadow com_div">
                        <div class="com_card" id="card_6" style="border-bottom: 2px solid #f1f1f1;height: 45%;">
                            <div class="cover_com" onclick="skip_remove_fun('card_6')"></div> 
                            <div class="close_div"><a onclick="un_select_product_fun('card_6')">X</a></div>
                            <div class="emptyspace"></div>
                            <img style="width:40% !important; padding: 15px 0;" onclick="select_product_fun('card_6')" src="{{asset('/assets/img/Coats.png')}}">
                            <div  class="btn_div" style="margin-top: -63px;">
                                <h5 style="padding-bottom: 26px;">Coats</h5>
                                <button type="button" class=" com_btn" onclick="select_product_fun('card_6')">Select</button>
                                <a class="a_com" onclick="skip_fun('card_6')"><h5>Skip</h5></a>
                            </div>
                            <div class="emptyspace"></div>
                            <div class="emptyspace"></div>
                           <form method="POST" action="{{ route('add.to.card2') }}" id="form_card_6">
                              @csrf
                            <input type="text" class="product_id_choosen p_id_input" name="product_id">
                            <input type="text" name="color_Att" class="attr_input">
                            <input type="text" name="color_Att1" class="attr_size_input">
                            </form>
                            <div class="price_div"><p></p></div>
                            <hr>
                        </div>
                        <div class="com_card" id="card_7" style="border-bottom: 2px solid #f1f1f1;    height: 25%;">
                            <div class="cover_com" onclick="skip_remove_fun('card_7')"></div> 
                            <div class="close_div"><a onclick="un_select_product_fun('card_7')">X</a></div>
                            <img style="width: 9% !important;/*    padding: 20px 0;*/" onclick="select_product_fun('card_7')"  src="{{asset('/assets/img/Ties.png')}}">
                            <div  class="btn_div" style="    margin-top: -70px;">
                                <h5 style="padding-bottom: 15px;">Ties</h5>
                                <button type="button" class=" com_btn" onclick="select_product_fun('card_7')">Select</button>
                                <a class="a_com" onclick="skip_fun('card_7')"><h5>Skip</h5></a>
                            </div>
                            <form method="POST" action="{{ route('add.to.card2') }}" id="form_card_7">
                              @csrf
                            <input type="text" class="product_id_choosen p_id_input" name="product_id">
                            <input type="text" name="color_Att" class="attr_input">
                            <input type="text" name="color_Att1" class="attr_size_input">
                            </form>
                            <div class="price_div"><p></p></div>
                            <hr>
                        </div>
                        <div class="com_card" id="card_8" style="  height: 30%; ">
                            <div class="cover_com" onclick="skip_remove_fun('card_8')"></div> 
                            <div class="close_div"><a onclick="un_select_product_fun('card_8')">X</a></div>
                            <img style="width: 26% !important;  /*  padding: 20px 0;*/" onclick="select_product_fun('card_8')" src="{{asset('/assets/img/scarfs.png')}}">
                            <div  class="btn_div" style="margin-top: -55px;">
                                <h5>Scarfs</h5>
                                <button type="button" class=" com_btn" onclick="select_product_fun('card_8')">Select</button>
                                <a class="a_com" onclick="skip_fun('card_8')"><h5>Skip</h5></a>
                            </div>
                            <div class="emptyspace" style="height: 10px;"></div>
                             <form method="POST" action="{{ route('add.to.card2') }}" id="form_card_8">
                              @csrf
                            <input type="text" class="product_id_choosen p_id_input" name="product_id">
                            <input type="text" name="color_Att" class="attr_input">
                            <input type="text" name="color_Att1" class="attr_size_input">
                            </form>
                            <div class="price_div"><p></p></div>
                        </div>
                        
                    </div>
                
            </div>
        </div> 
   
    </div>
  

  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" style=" font-size: 20px;   color: gray;">Combination summary</h4>
          <button type="button" class="close" data-dismiss="modal" onclick="close_modal()" style="      color: gray;  background: white;border: none;font-size: 25px;">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" >
           <div id="cart_orders1"></div>
           <div id="cart_orders2"></div>
           <div id="cart_orders3"></div>
           <div id="cart_orders4"></div>
           <div id="cart_orders5"></div>
           <div id="cart_orders6"></div>
           <div id="cart_orders7"></div>
           <div id="cart_orders8"></div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="select_size1" onclick="add_to_bag_fun()" style="    width: auto;padding: 10px 20px 9px 20px">Add to bag</button>
        </div>
        
      </div>
    </div>
  </div>
    
  
@endsection
@section('additional_scripts')
<script>
function close_modal(){
    $("#myModal").modal('hide');
}

function add_to_popup(){
    var id=$("#form_card_1 .p_id_input").val();
    var id2=$("#form_card_2 .p_id_input").val();
    var id3=$("#form_card_3 .p_id_input").val();
    var id4=$("#form_card_4 .p_id_input").val();
    var id5=$("#form_card_5 .p_id_input").val();
    var id6=$("#form_card_6 .p_id_input").val();
    var id7=$("#form_card_7 .p_id_input").val();
    var id8=$("#form_card_8 .p_id_input").val();
    $('#cart_orders1').html('');
    $('#cart_orders2').html('');
    $('#cart_orders3').html('');
    $('#cart_orders4').html('');
    $('#cart_orders5').html('');
    $('#cart_orders6').html('');
    $('#cart_orders7').html('');
    $('#cart_orders8').html('');
    if(id==0 && id2==0 && id3==0 && id4==0 && id5==0 && id6==0 && id7==0 && id8==0)
       {
       Swal.fire(
      'Oops...',
      '<p style="    text-align: center !important;font-size: 14px !important;">You Should choose your combination</p>',
      'error')
       }
    else{
    $("#myModal").modal('show');
    if(id !=0) (add_product_to_Div(id,1));
    if(id2 !=0) (add_product_to_Div(id2,2));
    if(id3 !=0) (add_product_to_Div(id3,3));
    if(id4 !=0) (add_product_to_Div(id4,4));
    if(id5 !=0) (add_product_to_Div(id5,5));
    if(id6 !=0) (add_product_to_Div(id6,6));
    if(id7 !=0) (add_product_to_Div(id7,7));
    if(id8 !=0) (add_product_to_Div(id8,8));
    }
} 
function add_product_to_Div(id,num){
    
     $.get('{{ route("productDetails_conbination")}}',{id: id},function(data){
        var colors="";
        var sizes='';
				
			
        
       
        if(data.options.size){
          sizes +='<select class="input   "  class="attr_size_input_'+id+'"  id="d_'+id+'"  name="color_Att1_'+id+'" >';
        for (var i = 0; i < data.options.size.length; i++) {
            
            sizes+=' 		<option value="'+data.options.size[i].option_value['value_id']+'" >'+data.options.size[i].option_value['value_name']+'  </option>'
        }}
        sizes+='	 </select>';
        for (var i = 0; i < data.options.color.length; i++) {
            colors+=' <input type="radio" id="d_'+id+'_'+i+'" class="attr_input_'+id+'" name="color_Att_'+id+'" value="'+data.options.color[i].option_value['value_id']+'">'
                    +'<label for="d_'+id+'_'+i+'">'
                    + ' <div  class="product_color"  style="    background: '+data.options.color[i].option_value['option_act_value']+';"></div>	'
                    +'</label>';
        }
        var  products = '<div class="row product_card"  style="padding-top: 5px;">'
                          +'<div class="col-2" style=""><img style="width:60%"  src="'+data.product.m_image+'" class="fit_image"></div>'
                          +' <div class="col-10 order_div">'
                             +'<form method="POST" action="/destroy-card" id="add_to_card">'
                                +'@csrf'
                                + '<input type="hidden" name="product_id" value="" >'
                                + '<input type="hidden" name="option_value_id" value="" >'
                     
                              +'</form>'
                             + '<h5 style="font-size: 14px;color: #a8a8a8;    font-weight: bold;">'+ data.product.description['products_name']+'</h5>'
                             +'<h5 style="font-size: 14px;color: #a8a8a8;">Size: '+sizes+'</h5>'
                             + '<h5 style="font-size: 14px;color: #a8a8a8;">Color: '+colors+'</h5>'
                             + '<p>'+ data.product.description['products_description']+'</p>'
                             +'<div class="b_product_card">'
                               +'<h1 style="font-size: 14px;color: #a8a8a8;    text-align: right;    margin: 0;" >'+parseFloat(data.product.products_price)+'AED</h1>'
                               +' <hr>'
                             +'</div>'
                           +'</div>'
                       +'</div>' ;  
              
        $('#cart_orders'+num).html(products);
         jQuery("input:radio[name=color_Att_"+id+"]:visible")[0].checked=true;
    },'json');
    
    
}
add_to_bag_fun = function(){
     $.get('{{ route("check_user") }}',function(data2){
    var id=$("#form_card_1 .p_id_input").val();
    var attr=$("#cart_orders1 .attr_input_"+id+':checked').val();
    var attr_size=$("#cart_orders1 attr_size_input_"+id+".d_"+id).val();
  $.get('{{ route("add.to.card2") }}',{product_id:id,color_Att:attr,color_Att1:attr_size,id:data2},function(data){},'json');
    var id2=$("#form_card_2 .p_id_input").val();
    var attr2=$("#cart_orders2 .attr_input_"+id2+':checked').val();
    var attr_size2=$("#cart_orders2 attr_size_input_"+id+".d_"+id).val();
   $.get('{{ route("add.to.card2") }}',{product_id:id2,color_Att:attr2,color_Att1:attr_size2,id:data2},function(data){},'json');
       var id3=$("#form_card_3 .p_id_input").val();
    var attr3=$("#cart_orders3 .attr_input_"+id3+':checked').val();
     var attr_size3=$("#cart_orders3 attr_size_input_"+id+".d_"+id).val();
   $.get('{{ route("add.to.card2") }}',{product_id:id3,color_Att:attr3,color_Att1:attr_size3,id:data2},function(data){},'json');
       var id4=$("#form_card_4 .p_id_input").val();
    var attr4=$("#cart_orders4 .attr_input_"+id4+':checked').val();
     var attr_size4=$("#cart_orders4 attr_size_input_"+id+".d_"+id).val();
   $.get('{{ route("add.to.card2") }}',{product_id:id4,color_Att:attr4,color_Att1:attr_size4,id:data2},function(data){},'json');
       var id5=$("#form_card_5 .p_id_input").val();
    var attr5=$("#cart_orders5 .attr_input_"+id5+':checked').val();
     var attr_size5=$("#cart_orders5 attr_size_input_"+id+".d_"+id).val();
   $.get('{{ route("add.to.card2") }}',{product_id:id5,color_Att:attr5,color_Att1:attr_size5,id:data2},function(data){},'json');
       var id6=$("#form_card_6 .p_id_input").val();
    var attr6=$("#cart_orders6 .attr_input_"+id6+':checked').val();
     var attr_size6=$("#cart_orders6 attr_size_input_"+id+".d_"+id).val();
   $.get('{{ route("add.to.card2") }}',{product_id:id6,color_Att:attr6,color_Att1:attr_size6,id:data2},function(data){},'json');
       var id7=$("#form_card_7 .p_id_input").val();
    var attr7=$("#cart_orders7 .attr_input_"+id7+':checked').val();
     var attr_size7=$("#cart_orders7 attr_size_input_"+id+".d_"+id).val();
   $.get('{{ route("add.to.card2") }}',{product_id:id7,color_Att:attr7,color_Att1:attr_size7,id:data2},function(data){},'json');
       var id8=$("#form_card_8 .p_id_input").val();
    var attr8=$("#cart_orders8 .attr_input_"+id8+':checked').val();
     var attr_size8=$("#cart_orders8 attr_size_input_"+id+".d_"+id).val();
   $.get('{{ route("add.to.card2") }}',{product_id:id8,color_Att:attr8,color_Att1:attr_size8,id:data2},function(data){},'json');
   
  window.location.reload();
 
     },'json');
    
}

function skip_remove_fun(id){
     $("#"+id+" .cover_com").slideUp();
}
function skip_fun(id){
         $("#"+id+" .cover_com").slideDown();
     //  $("#"+id+" .cover_com").addClass("cover_com_skip");
      //   $("#"+id+" .cover_com").show( 'slide', {direction: 'up'} );
        //$("#"+id+" .cover_com").show('slide', { direction: "up" }, 80000);
    }
function select_product_fun(id){
     $("#"+id+" .cover_com").slideUp();
    $("#choose_id").hide();
        $("#shirts_id").hide();
        $("#shoes_id").hide();
        $("#trousers_id").hide();
        $("#coats_id").hide();
        $("#socks_id").hide();
        $("#ties_id").hide();
        $("#belts_id").hide();
        $("#scarfs_id").hide();
        $("#a_scarfs_id").removeClass('active');
        $("#a_ties_id").removeClass("active");
        $('#a_belts_id').removeClass("active");
        $("#a_shoes_id").removeClass("active");
        $("#a_socks_id").removeClass("active");
        $("#a_shirts_id").removeClass('active');
        $("#a_trousers_id").removeClass("active");
        $('#a_coats_id').removeClass("active");
        
    if(id=="card_1"){
        $('#a_belts_id').addClass('active');
        $("#belts_id").fadeIn(3000);
        $('#card_1 img').attr('src',$('#belts_id   img').attr('src'));
        $('#card_1 p').text($('#belts_id p:eq(0)').text());
        $('#card_1 .p_id_input').val($('#belts_id .p_id_input').val());
        $('#card_1 .attr_input').val($('#belts_id .attr_input').val());
        $('#card_1 .attr_size_input').val($('#belts_id .attr_size_input').val());
        $('#card_1 img').css("width","50%");
        $('#card_1 img').css("padding","0");
         $('#card_1 img').css("height","95px");
        $('#card_1 img').css("object-fit","cover");
        $('#card_1 img').css("cursor","pointer");
        $('#card_1 .btn_div').hide();
        $('#card_1 .close_div a').show();
        
    }
    if(id=="card_2"){
        $("#a_socks_id").addClass('active');
        $("#socks_id").fadeIn(3000);
        $('#card_2 img').attr('src',$('#socks_id  img').attr('src'));
        $('#card_2 p').text($('#socks_id p:eq(0)').text());
        $('#card_2 .p_id_input').val($('#socks_id .p_id_input').val());
        $('#card_2 .attr_input').val($('#socks_id .attr_input').val());
        $('#card_2 .attr_size_input').val($('#socks_id .attr_size_input').val());
        $('#card_2 .btn_div').hide();
        $('#card_2 img').css("width","51%");
        $('#card_2 img').css("padding","0");
        $('#card_2 img').css("cursor","pointer");
        $('#card_2 .close_div a').show();
    }
    if(id=="card_3"){
        $("#a_shoes_id").addClass('active');
        $("#shoes_id").fadeIn(3000);
        $('#card_3 img').attr('src',$('#shoes_id  img').attr('src'));
        $('#card_3 p').text($('#shoes_id p:eq(0)').text());
        $('#card_3 .p_id_input').val($('#shoes_id .p_id_input').val());
        $('#card_3 .attr_input').val($('#shoes_id .attr_input').val());
        $('#card_3 .attr_size_input').val($('#shoes_id .attr_size_input').val());
        $('#card_3 .btn_div').hide();
        $('#card_3 img').css("width","51%");
        $('#card_3 img').css("padding","0");
        $('#card_3 img').css("cursor","pointer");
        $('#card_3 .close_div a').show();
    }
    if(id=="card_4"){
        $("#a_shirts_id").addClass('active');
        $("#shirts_id").fadeIn(3000);
        $('#card_4 img').attr('src',$('#shirts_id  img').attr('src'));
        $('#card_4 p').text($('#shirts_id p:eq(0)').text());
        $('#card_4 .p_id_input').val($('#shirts_id .p_id_input').val());
        $('#card_4 .attr_input').val($('#shirts_id .attr_input').val());
        $('#card_4 .attr_size_input').val($('#shirts_id .attr_size_input').val());
        $('#card_4 .btn_div').hide();
        $('#card_4 img').css("padding","16px 0");
        $('#card_4 img').css("cursor","pointer");
        $('#card_4 .close_div a').show();
    }
    if(id=="card_5"){
        $("#a_trousers_id").addClass('active');
        $("#trousers_id").fadeIn(3000);
        $('#card_5 img').attr('src',$('#trousers_id  img').attr('src'));
        $('#card_5 p').text($('#trousers_id p:eq(0)').text());
        $('#card_5 .p_id_input').val($('#trousers_id .p_id_input').val());
        $('#card_5 .attr_input').val($('#trousers_id .attr_input').val());
        $('#card_5 .attr_size_input').val($('#trousers_id .attr_size_input').val());
        $('#card_5 .btn_div').hide();
        $('#card_5 img').css("width","62%");
        $('#card_5 img').css("padding","0");
        $('#card_5 img').css("cursor","pointer");
        $('#card_5 .close_div a').show();
    }
    if(id=="card_6"){
        $('#a_coats_id').addClass('active');
        $("#coats_id").fadeIn(3000);
        $('#card_6 img').attr('src',$('#coats_id  img').attr('src'));
        $('#card_6 p').text($('#coats_id p:eq(0)').text());
        $('#card_6 .p_id_input').val($('#coats_id .p_id_input').val());
        $('#card_6 .attr_input').val($('#coats_id .attr_input').val());
        $('#card_6 .attr_size_input').val($('#coats_id .attr_size_input').val());
        
        $('#card_6 .btn_div').hide();
        $('#card_6 img').css("padding","5px 0");
        $('#card_6 img').css("cursor","pointer");
        $('#card_6 .close_div a').show();
    }
    if(id=="card_7"){
        $("#a_ties_id").addClass('active');
        $("#ties_id").fadeIn(3000);
        $('#card_7 img').attr('src',$('#ties_id  img').attr('src'));
        $('#card_7 p').text($('#ties_id p:eq(0)').text());
        $('#card_7 .p_id_input').val($('#ties_id .p_id_input').val());
        $('#card_7 .attr_input').val($('#ties_id .attr_input').val());
        $('#card_7 .attr_size_input').val($('#ties_id .attr_size_input').val());
        $('#card_7 .btn_div').hide();
        $('#card_7 img').css("width","50%");
        $('#card_7 img').css("padding","0");
        $('#card_7 img').css("cursor","pointer");
        $('#card_7 .close_div a').show();
    }
    if(id=="card_8"){
        $("#a_scarfs_id").addClass('active');
        $("#scarfs_id").fadeIn(3000);
        $('#card_8 img').attr('src',$('#scarfs_id  img').attr('src'));
        $('#card_8 p').text($('#scarfs_id p:eq(0)').text());
        $('#card_8 .p_id_input').val($('#scarfs_id .p_id_input').val());
        $('#card_8 .attr_input').val($('#scarfs_id .attr_input').val());
        $('#card_8 .attr_size_input').val($('#scarfs_id .attr_size_input').val());
        $('#card_8 .btn_div').hide();
        $('#card_8 img').css("width","35%");
        $('#card_8 img').css("padding","0");
        $('#card_8 img').css("cursor","pointer");
        $('#card_8 .close_div a').show();
    }
    
} 
function un_select_product_fun(id){
    $("#choose_id").fadeIn(300);
    $("#shirts_id").hide();
        $("#shoes_id").hide();
        $("#trousers_id").hide();
        $("#coats_id").hide();
        $("#socks_id").hide();
        $("#ties_id").hide();
        $("#belts_id").hide();
        $("#scarfs_id").hide();  
    if(id=="card_1"){
        $('#card_1 img').attr('src','/assets/img/belt.png');
        $('#card_1 p').text("");
        $('#card_1 img').css("width","40%");
       // $('#card_1 img').css("padding","20px 0");
        $('#card_1 .btn_div').show();
        $('#card_1 .close_div a').hide();
         $('#card_1 img').css("height","auto"); 
        $('#card_1 img').css("object-fit","unset");
        $('#card_1 img').css("cursor","auto");
         $('#card_1 .p_id_input').val('');
        $('#card_1 .attr_input').val('');
        $('#card_1 .attr_size_input').val('');
    }
    if(id=="card_2"){
        $('#card_2 img').attr('src','/assets/img/socks.png');
        $('#card_2 p').text("");
        $('#card_2 .btn_div').show();
        $('#card_2 img').css("width","32%");
       // $('#card_2 img').css("padding","35px 0");
        $('#card_2 .close_div a').hide();
         $('#card_2 img').css("height","auto"); 
        $('#card_2 img').css("object-fit","unset");
        $('#card_2 img').css("cursor","auto");
        $('#card_2 .p_id_input').val('');
        $('#card_2 .attr_input').val('');
        $('#card_2 .attr_size_input').val('');
    }
    if(id=="card_3"){
        $('#card_3 img').attr('src','/assets/img/shoes.png');
        $('#card_3 p').text("");
        $('#card_3 .btn_div').show();
        $('#card_3 img').css("width","44%");
       // $('#card_3 img').css("padding","29px 0");
        $('#card_3 .close_div a').hide();
         $('#card_3 img').css("height","auto"); 
        $('#card_3 img').css("object-fit","unset");
        $('#card_3 img').css("cursor","auto");
        $('#card_3 .p_id_input').val('');
        $('#card_3 .attr_input').val('');
        $('#card_3 .attr_size_input').val('');
    }
    if(id=="card_4"){
        $('#card_4 img').attr('src','/assets/img/Shirts.png');
        $('#card_4 p').text("");
        $('#card_4 .btn_div').show();
        $('#card_4 img').css("width","40%");
       // $('#card_4 img').css("padding","16px 0");
        $('#card_4 .close_div a').hide();
         $('#card_4 img').css("height","auto"); 
        $('#card_4 img').css("object-fit","unset");
        $('#card_4 img').css("cursor","auto");
         //$('#card_4 img').attr('height','100%');
         $('#card_4 .p_id_input').val('');
        $('#card_4 .attr_input').val('');
        $('#card_4 .attr_size_input').val('');
    }
    if(id=="card_5"){
        $('#card_5 img').attr('src','/assets/img/trousers.png');
        $('#card_5 p').text("");
        $('#card_5 .btn_div').show();
        $('#card_5 img').css("width","30%");
        //$('#card_5 img').css("padding","0px 0");
        $('#card_5 .close_div a').hide();
         $('#card_5 img').css("height","auto"); 
        $('#card_5 img').css("object-fit","unset");
        $('#card_5 img').css("cursor","auto");
        $('#card_5 .p_id_input').val('');
        $('#card_5 .attr_input').val('');
        $('#card_5 .attr_size_input').val('');
    }
    if(id=="card_6"){
        $('#card_6 img').attr('src','/assets/img/Coats.png');
        $('#card_6 p').text("");
        $('#card_6 .btn_div').show();
        $('#card_5 img').css("width","40%");
        $('#card_6 img').css("padding","15px 0");
        $('#card_6 .close_div a').hide();
         $('#card_6 img').css("height","auto"); 
        $('#card_6 img').css("object-fit","unset");
        $('#card_6 img').css("cursor","auto");
         //$('#card_6 img').attr('height','100%');
         $('#card_6 .p_id_input').val('');
        $('#card_6 .attr_input').val('');
        $('#card_6 .attr_size_input').val('');
    }
    if(id=="card_7"){
        $('#card_7 img').attr('src','/assets/img/Ties.png');
        $('#card_7 p').text("");
        $('#card_7 .btn_div').show();
        $('#card_7 img').css("width","9%");
        //$('#card_7 img').css("padding","20px 0");
        $('#card_7 .close_div a').hide();
         $('#card_7 img').css("height","auto"); 
        $('#card_7 img').css("object-fit","unset");
        $('#card_7 img').css("cursor","auto");
        $('#card_7 .p_id_input').val('');
        $('#card_7 .attr_input').val('');
        $('#card_7 .attr_size_input').val('');
    }
    if(id=="card_8"){
        $('#card_8 img').attr('src','/assets/img/scarfs.png');
        $('#card_8 p').text("");
        $('#card_8 .btn_div').show();
        $('#card_8 img').css("width","26%");
      //  $('#card_8 img').css("padding","20px 0");
        $('#card_8 .close_div a').hide();
         $('#card_8 img').css("height","auto"); 
        $('#card_8 img').css("object-fit","unset");
        $('#card_8 img').css("cursor","auto");
         $('#card_8 .p_id_input').val('');
        $('#card_8 .attr_input').val('');
        $('#card_8 .attr_size_input').val('');
    }
    
} 
/////////////// 
    
    $("#shirts_id").hide();
    $("#shoes_id").hide();
    $("#trousers_id").hide();
    $("#coats_id").hide();
    $("#socks_id").hide();
    $("#ties_id").hide();
    $("#belts_id").hide();
    $("#scarfs_id").hide();
//////////////// 
</script>
<script>
    
     // Custom Navigation Events
      var $owl = $('#trousers_id .owl-carousel');
      
$owl.children().each( function( index ) {
  $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
  
});

$owl.owlCarousel({
  center: true,
  loop: true,
  items: 1,
  nav:true,
  navText : ['<i class=" fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
   responsive:{
   0:{stagePadding: 60},
   300:{stagePadding: 90},
   500:{stagePadding: 100},
   768:{stagePadding: 110},
   1100:{stagePadding: 150},
   
    }
});

$(document).on('click', '#trousers_id .owl-item>div', function() {
  $owl.trigger('to.owl.carousel', $(this).data( 'position' ) ); 
 $(' .owl-carousel .owl-item img').css('transition','all 1s ease 0s');
  $(' .owl-carousel .owl-stage').css('transition','all 1s ease 0s');
  
  $('#card_5 img').attr('src',$('#trousers_id .center img').attr('src'));
     $('#card_5 p').text($('#trousers_id .center p').text());
     $('#card_5 .p_id_input').val($('#trousers_id .center .p_id_input').val());
      $('#card_5 .attr_input').val($('#trousers_id .center .attr_input').val());
      $('#card_5 .attr_size_input').val($('#trousers_id .center .attr_size_input').val());
  $('#card_5 .btn_div').hide();
  
});
//////////////////

var $owl2 = $('#shirts_id .owl-carousel');
var $owl2_img=$('#shirts_id img').attr('src');
$owl2.children().each( function( index ) {
  $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
});

$owl2.owlCarousel({
  center: true,
  loop: true,
  items: 1,
   nav:true,
  navText : ['<i class=" fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
  responsive:{
   0:{stagePadding: 60},
   300:{stagePadding: 90},
   500:{stagePadding: 100},
   768:{stagePadding: 110},
   1100:{stagePadding: 150},
   
    }
   
});

$(document).on('click', '#shirts_id .owl-item>div', function() {
  $owl2.trigger('to.owl.carousel', $(this).data( 'position' ) ); 
  $(' .owl-carousel .owl-item img').css('transition','all 1s ease 0s');
  $(' .owl-carousel .owl-stage').css('transition','all 1s ease 0s');
  
  $('#card_4 img').attr('src',$('#shirts_id .center img').attr('src'));
     $('#card_4 p').text($('#shirts_id .center p').text());
       $('#card_4 .p_id_input').val($('#shirts_id .center .p_id_input').val());
         $('#card_4 .attr_input').val($('#shirts_id .center .attr_input').val());
      $('#card_4 .attr_size_input').val($('#shirts_id .center .attr_size_input').val());
  $('#card_4 .btn_div').hide();
});

/////////////////
var $owl3 = $('#coats_id .owl-carousel');
var $owl3_img=$('#coats_id img').attr('src');
$owl3.children().each( function( index ) {
  $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
});

$owl3.owlCarousel({
  center: true,
  loop: true,
  items: 1,
   nav:true,
  navText : ['<i class=" fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
   responsive:{
   0:{stagePadding: 60},
   300:{stagePadding: 90},
   500:{stagePadding: 100},
   768:{stagePadding: 110},
   1100:{stagePadding: 150},
   
    }
});

$(document).on('click', '#coats_id .owl-item>div', function() {
  $owl3.trigger('to.owl.carousel', $(this).data( 'position' ) ); 
  $(' .owl-carousel .owl-item img').css('transition','all 1s ease 0s');
  $(' .owl-carousel .owl-stage').css('transition','all 1s ease 0s');
  
  $('#card_6 img').attr('src',$('#coats_id .center img').attr('src'));
   $('#card_6 p').text($('#coats_id .center p').text());
   $('#card_6 .p_id_input').val($('#coats_id .center .p_id_input').val());
  $('#card_6 .attr_input').val($('#coats_id .center .attr_input').val());
      $('#card_6 .attr_size_input').val($('#coats_id .center .attr_size_input').val());
  $('#card_6 .btn_div').hide();
});
/////////////////
var $owl4 = $('#ties_id .owl-carousel');
var $owl4_img=$('#ties_id img').attr('src');
$owl4.children().each( function( index ) {
  $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
});

$owl4.owlCarousel({
  center: true,
  loop: true,
  items: 1,
   nav:true,
  navText : ['<i class=" fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
  responsive:{
   0:{stagePadding: 60},
   300:{stagePadding: 90},
   500:{stagePadding: 100},
   768:{stagePadding: 110},
   1100:{stagePadding: 150},
   
    }
});

$(document).on('click', '#ties_id .owl-item>div', function() {
  $owl4.trigger('to.owl.carousel', $(this).data( 'position' ) ); 
  $(' .owl-carousel .owl-item img').css('transition','all 1s ease 0s');
  $(' .owl-carousel .owl-stage').css('transition','all 1s ease 0s');
  $('#card_7 img').attr('src',$('#ties_id .center img').attr('src'));
  $('#card_7 p').text($('#ties_id .center p').text());
  $('#card_7 .p_id_input').val($('#ties_id .center .p_id_input').val());
  $('#card_7 .btn_div').hide();
     $('#card_7 .attr_input').val($('#ties_id .center .attr_input').val());
      $('#card_7 .attr_size_input').val($('#ties_id .center .attr_size_input').val());
});

/////////////////
var $owl5 = $('#shoes_id .owl-carousel');
var $owl5_img=$('#shoes_id img').attr('src');
$owl5.children().each( function( index ) {
  $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
});

$owl5.owlCarousel({
  center: true,
  loop: true,
  items: 1,
   nav:true,
  navText : ['<i class=" fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
 responsive:{
   0:{stagePadding: 60},
   300:{stagePadding: 90},
   500:{stagePadding: 100},
   768:{stagePadding: 110},
   1100:{stagePadding: 150},
   
    }
});

$(document).on('click', '#shoes_id .owl-item>div', function() {
  $owl5.trigger('to.owl.carousel', $(this).data( 'position' ) ); 
  $(' .owl-carousel .owl-item img').css('transition','all 1s ease 0s');
  $(' .owl-carousel .owl-stage').css('transition','all 1s ease 0s');
  $('#card_3 img').attr('src',$('#shoes_id .center img').attr('src'));
  $('#card_3 p').text($('#shoes_id .center p').text());
  $('#card_3 .p_id_input').val($('#shoes_id .center .p_id_input').val());
   $('#card_3 .attr_input').val($('#shoes_id .center .attr_input').val());
      $('#card_3 .attr_size_input').val($('#shoes_id .center .attr_size_input').val());

  $('#card_3 .btn_div').hide();
});

/////////////////
var $owl6 = $('#scarfs_id .owl-carousel');
var $owl6_img=$('#scarfs_id img').attr('src');
$owl6.children().each( function( index ) {
  $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
});

$owl6.owlCarousel({
  center: true,
  loop: true,
  items: 1,
   nav:true,
  navText : ['<i class=" fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
 responsive:{
   0:{stagePadding: 60},
   300:{stagePadding: 90},
   500:{stagePadding: 100},
   768:{stagePadding: 110},
   1100:{stagePadding: 150},
   
    }
});

$(document).on('click', '#scarfs_id .owl-item>div', function() {
  $owl6.trigger('to.owl.carousel', $(this).data( 'position' ) ); 
  $(' .owl-carousel .owl-item img').css('transition','all 1s ease 0s');
  $(' .owl-carousel .owl-stage').css('transition','all 1s ease 0s');
  $('#card_8 img').attr('src',$('#scarfs_id .center img').attr('src'));
       $('#card_8 p').text($('#scarfs_id .center p').text());
       $('#card_8 .p_id_input').val($('#scarfs_id .center .p_id_input').val());
        $('#card_8 .attr_input').val($('#scarfs_id .center .attr_input').val());
      $('#card_8 .attr_size_input').val($('#scarfs_id .center .attr_size_input').val());

  $('#card_8 .btn_div').hide();
});
/////////////////
var $owl7 = $('#belts_id .owl-carousel');
var $owl7_img=$('#belts_id img').attr('src');
$owl7.children().each( function( index ) {
  $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
});

$owl7.owlCarousel({
  center: true,
  loop: true,
  items: 1,
   nav:true,
  navText : ['<i class=" fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
  responsive:{
   0:{stagePadding: 60},
   300:{stagePadding: 90},
   500:{stagePadding: 100},
   768:{stagePadding: 110},
   1100:{stagePadding: 150},
   
    }
});

$(document).on('click', '#belts_id .owl-item>div', function() {
  $owl7.trigger('to.owl.carousel', $(this).data( 'position' ) ); 
  $(' .owl-carousel .owl-item img').css('transition','all 1s ease 0s');
  $(' .owl-carousel .owl-stage').css('transition','all 1s ease 0s');
  $('#card_1 img').attr('src',$('#belts_id .center img').attr('src'));
   $('#card_1 p').text($('#belts_id .center p').text());
    $('#card_1 .p_id_input').val($('#belts_id .center .p_id_input').val());
          $('#card_1 .attr_input').val($('#belts_id .center .attr_input').val());
      $('#card_1 .attr_size_input').val($('#belts_id .center .attr_size_input').val());
  
  $('#card_1 .btn_div').hide();
});
/////////////////
var $owl8 = $('#socks_id .owl-carousel');
var $owl8_img=$('#socks_id img').attr('src');
$owl8.children().each( function( index ) {
  $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
});

$owl8.owlCarousel({
  center: true,
  loop: true,
  items: 1,
   nav:true,
  navText : ['<i class=" fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
 responsive:{
   0:{stagePadding: 60},
   300:{stagePadding: 90},
   500:{stagePadding: 100},
   768:{stagePadding: 110},
   1100:{stagePadding: 150},
   
    }
});

$(document).on('click', '#socks_id .owl-item>div', function() {
  $owl8.trigger('to.owl.carousel', $(this).data( 'position' ) ); 
   $(' .owl-carousel .owl-item img').css('transition','all 1s ease 0s');
  $(' .owl-carousel .owl-stage').css('transition','all 1s ease 0s');
  $('#card_2 img').attr('src',$('#socks_id .center img').attr('src'));
     $('#card_2 p').text($('#socks_id .center p').text());
     $('#card_2 .p_id_input').val($('#socks_id .center .p_id_input').val());
      $('#card_2 .attr_input').val($('#socks_id .center .attr_input').val());
      $('#card_2 .attr_size_input').val($('#socks_id .center .attr_size_input').val());

  $('#card_2 .btn_div').hide();
  
});


</script>
@endsection


