@extends('layouts.website.main')
@section('additional_styles')
<link rel="stylesheet" href="{{URL::asset('assets/css/Filter.css')}}">
 @php
 $o_p="";
 @endphp
 @foreach($order_products as $order_products)
 @php
 $o_p=$o_p.$order_products->products_id.","
 @endphp
 @endforeach
 @php
  $o_p_arr=explode(',', $o_p);
  
 @endphp
<style>

    .row {
    --bs-gutter-x: 0 !important;
    --bs-gutter-y: 0;}
    body {
    overflow-x: hidden;
}
.accordion-body {
    padding: 1rem 2.25rem !important;
}
[data-aos][data-aos][data-aos-duration="400"], body[data-aos-duration="400"] [data-aos] {
    transition-duration: 1s;
}
.rate span{    font-weight: bold;
    padding: 0 3px;}
    .rate {  padding-bottom: 8px;
}
.clear_btn{    margin: 0 5px;background: gray;
    color: white;
    border: 1px solid gray;
    border-radius: 6px;
    padding: 8px 0;
    width: 30%;}
    .aplay_btn{    margin: 0 5px;background: white;
    color: gray;
    border: 1px solid gray;
    border-radius: 6px;
    padding: 8px 0;
    width: 30%;}
.fix_div{    border-top: 1px solid #dfdfdf;
    padding: 5px;
    position: absolute;
    bottom: 0;
    height: auto !important;
    text-align: center;
    width: 35% !important;
    background: white;
    padding: 8px 0 !important;
    margin: 0;
    z-index: 100000000;
    box-shadow: none !important;


}

</style>

@endsection
@section('content')
    <script>
        /////////////////// add categoriers to munue and function to url///////////////////
        var all_cat="";
        $.get('<?= route("website.categoriers_sub_menue")?>',function(data){
            var sub="";
            
            for (var i = 0; i < data.length; i++) {
                sub += ' <label class="container1">'+data[i].categories_name+
                        '<input type="checkbox" name="cat" id="cat_'+data[i].categories_id+'"  value="'+data[i].categories_id+'">'+
                        '<span class="checkmark1" ></span>'+
                        '</label>';
                        all_cat+=data[i].categories_id+",";
            }
            $('#product_cat').html(sub);
            //////php code to checke choosen categoriers///////////////
            @php
            if(!empty($filter_cat)){
                $array = explode(',', $filter_cat);
                foreach ($array as $element) {
            @endphp
                $("#cat_@php echo $element; @endphp").attr('checked', 'checked');
            @php
              
              }  }
            @endphp
        },'json');
        function filter_and_sort_fun(type){
            var checkedvalue = $("input[name='cat']:checked").map(function(){
                return $(this).val(); 
            }).get();
            if(checkedvalue==""){checkedvalue=all_cat;}
            var minprice=  $('#minprice').val();
            var maxprice=  $('#maxprice').val();
            if(type=='this_page') window.location.href='/categories/all/all/'+checkedvalue+'/'+minprice+','+maxprice;	
           if(type=='feature') window.location.href='/categories/feature/'+checkedvalue+'/'+minprice+','+maxprice;	
            if(type=='newCollection') window.location.href='/categories/new-collection/'+checkedvalue+'/'+minprice+','+maxprice;
            if(type=='height_low_price') window.location.href='/categories/height-low/'+checkedvalue+'/'+minprice+','+maxprice;
            if(type=='low_height_price') window.location.href='/categories/low-height/'+checkedvalue+'/'+minprice+','+maxprice;
        }
	</script>
<div class="">   
    <h5 style="padding-top: 25px; padding-left: 25px;" class="page_location"><a  href="/"> Home </a>><a href="/categories/all"> Categories </a>><a href=""> Price High-Low </a></h5>
</div>
<div class="container-fluid">
    <div class="row sort">
<input type="text" style="display:none" id="all_cat" name="all_cat">
        <div class="col-md-12 buttons">
            <a onclick="openSort()"  class="btn3 stay"> Sort by</a>
            <br>
            <a onclick="openFilter()" class="btn3 stay"> Filter</a>
        </div>
    </div> 
    
    
    
    
    
</div>
<div id="myFilter" class="filter_r">
    <div class="stay" style="padding: 30px;color: #939393;">
        <h5 style="text-align: center;">Filter</h5>
        <hr>
        <div class="filter_div2">
       <div class="accordion" id="accordionPanelsStayOpenExample">
                              <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                                   Products
                                  </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse " aria-labelledby="panelsStayOpen-headingOne">
                                  <div class="accordion-body" id="product_cat">
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    Size
                                  </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                  <div class="accordion-body">
                                    <label class="container1"> S
                                          <input type="checkbox" >
                                          <span class="checkmark1"></span>
                                    </label>
                                     <label class="container1"> L
                                          <input type="checkbox" >
                                          <span class="checkmark1"></span>
                                    </label>
                                     <label class="container1"> XL
                                          <input type="checkbox" >
                                          <span class="checkmark1"></span>
                                    </label> <label class="container1"> XXL
                                          <input type="checkbox" >
                                          <span class="checkmark1"></span>
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                    Price
                                  </button>
                                </h2>
                                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                  <div class="accordion-body">
                                    <section class="range-slider ">
                                      <span class="output outputOne"></span>
                                      <span class="output outputTwo"></span>
                                      <span class="full-range"></span>
                                      <span class="incl-range"></span>
                                      
                                      <input name="rangeOne" value="0" min="0" max="{{$max_price}}" step="1" type="range" id="minprice">
                                      <input name="rangeTwo" value="{{$max_price}}" min="0" max="{{$max_price}}" step="1" type="range" id="maxprice">
                                    </section>
                                  </div>
                                </div>
                              </div>
                            </div>
         
        </div>
        <div class="fix_div " style="">
           <button class="clear_btn " >Clear All</button>
             <button class="aplay_btn" onclick="filter_and_sort_fun('this_page')" >Apply</button>
         </div>
    </div>
</div>
<div id="mySort" class="filter ">
    <div  class="stay" style="padding: 30px;color: #939393;">
          <h5 style="text-align: center;">Sort by</h5>
          <hr>
          <div class="filter_div">
            <label class="container">Featured
              <input type="radio"  onclick="filter_and_sort_fun('feature')" name="radio">
              <span class="checkmark"></span>
            </label>
            <label class="container">Newest
              <input type="radio"   onclick="filter_and_sort_fun('newCollection')" name="radio">
              <span class="checkmark"></span>
            </label>
          
           <label class="container">Price High-Low
              <input type="radio"  onclick="filter_and_sort_fun('height_low_price')" name="radio" checked>
              <span class="checkmark"></span>
            </label>
             <label class="container">Price Low-High
              <input type="radio" onclick="filter_and_sort_fun('low_height_price')" name="radio">
              <span class="checkmark"></span>
            </label>
            
            </div>

    </div>
</div>


                   
<desktop>


    
    <div class="container" id="product_container">      
        
        @foreach($category_name as $category_name)
        @php
        $filter_cat_array = explode(',', $filter_cat);
        $filter_price_array = explode(',', $filter_price);
        @endphp
        @if(in_array($category_name->categories_id, $filter_cat_array) )
                @php
                $cc=count($category_name->heightLowProducts);
                 @endphp 
            <div class="row  categories " style="@if($cc==0) display:none @endif">
                @foreach($category_name->description as $descriptiona)
                 <h4 style="text-align: center;color: #928e8e;    padding-top: 10px;">{{$descriptiona->categories_name}}</h4>
                @endforeach
                @php
                $i=1;
                $s=count($category_name->heightLowProducts);
                 @endphp 
                @foreach($category_name->heightLowProducts as $products)
                @if( $products->products_price >= $filter_price_array[0] && $products->products_price <= $filter_price_array[1])
                    @if($i %2)
                    @if ($i==$s)
                        <div class="col-md-6  sec-one" >
                        </div>
                        <div class="col-6  sec-two alone">
                            <div class="row  flip" data-aos="fade-left">
                                <div class="col-md-6">
                                    <a  href="{{route('website.product',['id'=>$products->products_id])}}">
                                        <img src="{{URL::asset((!is_null($products->mainImage)?$products->mainImage->path():'prod.png'))}}">
                                    </a>
                                </div>
                                <div class="col-md-6 text">
                                    <span>   
                                        <h2>{{ $products->description->products_name }} </h2>
                                        <p>{{ $products->description->products_description }} </p>
                                        <div class="rate"><span>{{ $products->products_price }}<span class="currency_span">AED</span></span> 
                                             @php
                                            $r=0;
                                            $count=0;
                                            @endphp
                                            @foreach($products->reviews as $reviews)
                                             @php
                                           $r += $reviews->reviews_rating;
                                            $count++;
                                            @endphp
                                            
                                            @endforeach
                                             @php
                                             if($r==0 || $count==0){$rev=0;}
                                             else{
                                            $rev=$r/$count;}
                                            @endphp
                                           @if($rev==0)
                                             <i class="fa  fa-star hide_element "  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==1)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})" ></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==2)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})" ></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==3)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==4)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==5)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>0 &&  $rev<1)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                              <i class="fa  fa-star-half hide_element  fill_star "  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>1 &&  $rev<2)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star-half hide_element  fill_star "  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>2 &&  $rev<3)
                                             <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element" onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element" onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>3 &&  $rev<4)
                                             <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element " onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element" onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>4 &&  $rev<5)
                                             <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            
                                        </div>
                                        @if(! in_array($products->products_id, $o_p_arr) ) <div class="stop_rating"></div> @endif 
                                        <div class="price">
                                            @if(  $products->like()==0 )
                                           <form method="POST" action="{{ route('add.to.like') }}" >
                                             @csrf
                                                <input type="hidden" name="product_id" value="{{$products->products_id}}" >
                                                <button type="submit" style="    background: white;border: 0px;display: flex;">
                                                    <i class="fa fa-heart-o " style="font-size: 25px;margin-top: -4px;color: #7e7c7d;"></i>
                                                    <p>Add to favorites   </p>
                                                </button>
                                            </form>
                                            @elseif($products->like()==1)
                                            <form method="POST" action="{{ route('destroy.like') }}" >
                                             @csrf
                                                <input type="hidden" name="product_id" value="{{$products->products_id}}" >
                                                <button type="submit" style="    background: white;border: 0px;display: flex;">
                                                    <i class="fa fa-heart " style="font-size: 25px;margin-top: -4px;color: red"></i>
                                                    <p>Is favorite  </p>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-6  sec-one">
                            <div class="row" data-aos="fade-right" >
                                <div class="col-md-6 text">
                                    <span>
                                        <h2>{{ $products->description->products_name }} </h2>
                                        <p>{{ $products->description->products_description }}  </p>
                                        <div class="rate">
                                            @php
                                            $r=0;
                                            $count=0;
                                            @endphp
                                            @foreach($products->reviews as $reviews)
                                             @php
                                           $r += $reviews->reviews_rating;
                                            $count++;
                                            @endphp
                                            
                                            @endforeach
                                             @php
                                             if($r==0 || $count==0){$rev=0;}
                                             else{
                                            $rev=$r/$count;}
                                            @endphp
                                            @if($rev==0)
                                             <i class="fa  fa-star hide_element "  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==1)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})" ></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==2)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})" ></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==3)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==4)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==5)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>0 &&  $rev<1)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                              <i class="fa  fa-star-half hide_element  fill_star "  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>1 &&  $rev<2)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star-half hide_element  fill_star "  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>2 &&  $rev<3)
                                             <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element" onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element" onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>3 &&  $rev<4)
                                             <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element " onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element" onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>4 &&  $rev<5)
                                             <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            <span>  {{ $products->products_price }}<span class="currency_span">AED</span>
                                            </span> 
                                        </div>
                                        @if(! in_array($products->products_id, $o_p_arr) ) <div class="stop_rating"></div> @endif 
                                        <div class="price">
                                            @if(  $products->like()==0 )
                                           <form method="POST" action="{{ route('add.to.like') }}" >
                                             @csrf
                                                <input type="hidden" name="product_id" value="{{$products->products_id}}" >
                                                 <button type="submit" style="    background: white;border: 0px;display: flex;">
                                                    <i class="fa fa-heart-o " style="font-size: 25px;margin-top: -4px;color: #7e7c7d;"></i>
                                                    <p>Add to favorites   </p>
                                                </button>
                                            </form>
                                            @elseif($products->like()==1)
                                            <form method="POST" action="{{ route('destroy.like') }}" >
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$products->products_id}}" >
                                                <button type="submit" style="    background: white;border: 0px;display: flex;">
                                                    <i class="fa fa-heart " style="font-size: 25px;margin-top: -4px;color: red"></i>
                                                    <p>Is favorite  </p>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <a  href="{{route('website.product',['id'=>$products->products_id])}}">
                                        <img src="{{URL::asset((!is_null($products->mainImage)?$products->mainImage->path():'prod.png'))}}">
                                    </a>
                                </div>
                            </div>
                        </div>  
                    @endif
                    @else
                        <div class="col-6  sec-two">
                            <div class="row  flip" data-aos="fade-left">
                                <div class="col-md-6">
                                    <a  href="{{route('website.product',['id'=>$products->products_id])}}">
                                        <img src="{{URL::asset((!is_null($products->mainImage)?$products->mainImage->path():'prod.png'))}}">
                                    </a>
                                </div>
                               <div class="col-md-6 text">
                                    <span>   
                                        <h2>{{ $products->description->products_name }} </h2>
                                        <p>{{ $products->description->products_description }} </p>
                                        <div class="rate">
                                            <span>{{ $products->products_price }}<span class="currency_span">AED</span></span>
                                            @php
                                            $r=0;
                                            $count=0;
                                            @endphp
                                            @foreach($products->reviews as $reviews)
                                             @php
                                           $r += $reviews->reviews_rating;
                                            $count++;
                                            @endphp
                                            
                                            @endforeach
                                             @php
                                             if($r==0 || $count==0){$rev=0;}
                                             else{
                                            $rev=$r/$count;}
                                            @endphp
                                            @if($rev==0)
                                             <i class="fa  fa-star hide_element "  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==1)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})" ></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==2)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})" ></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==3)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==4)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev==5)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>0 &&  $rev<1)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                              <i class="fa  fa-star-half hide_element  fill_star "  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>1 &&  $rev<2)
                                             <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star-half hide_element  fill_star "  onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element "  onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            
                                            <i class="fa  fa-star hide_element"  onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>2 &&  $rev<3)
                                             <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element" onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element" onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>3 &&  $rev<4)
                                             <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element " onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element" onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                            @if($rev>4 &&  $rev<5)
                                             <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(4,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(5,{{$products->products_id}})"></i>
                                            @endif
                                        </div>
                                        @if(! in_array($products->products_id, $o_p_arr) ) <div class="stop_rating"></div> @endif 
                                        <div class="price">
                                            @if(  $products->like()==0 )
                                            <form method="POST" action="{{ route('add.to.like') }}" >
                                             @csrf
                                                <input type="hidden" name="product_id" value="{{$products->products_id}}" >
                                                <button type="submit" style="    background: white;border: 0px;display: flex;">
                                                    <i class="fa fa-heart-o " style="font-size: 25px;margin-top: -4px;color: #7e7c7d;"></i>
                                                    <p>Add to favorites   </p>
                                                </button>
                                            </form>
                                            @elseif($products->like()==1)
                                             <form method="POST" action="{{ route('destroy.like') }}" >
                                             @csrf
                                                <input type="hidden" name="product_id" value="{{$products->products_id}}" >
                                                <button type="submit" style="    background: white;border: 0px;display: flex;">
                                                    <i class="fa fa-heart " style="font-size: 25px;margin-top: -4px;color: red"></i>
                                                   <p>Is favorite  </p>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                   </span>
                                </div>
                            </div>
                        </div>
        
                    @endif
                    @php
                        $i++;
                    @endphp 
                 @endif
                @endforeach
            </div>
             @endif
        @endforeach
       
              
           
            
                
                
                
                
            

        <div class="container-fluid">
     
     <div class="row   fit">
         <h1>Are you looking for a <span>specific fit?</span></h1>
     </div>
     
    <div class="row  categories">
         
            <div class="col-md-1 shirt">
                 
             </div>
             <div class="col-sm-2 shirt">
                 <img src="{{asset('/assets/img/shirt.jpg')}}">
                 <h2>Washington</h2>
                 <p>Extra slim fit</p>
             </div>
             <div class="col-md-2 shirt">
                 <img src="{{asset('/assets/img/shirt.jpg')}}">
                 <h2>Lazio</h2>
                 <p>Slim & lightly padded</p>
             </div>
             <div class="col-md-2 shirt">
                 <img src="{{asset('/assets/img/shirt.jpg')}}">
                 <h2>Havana</h2>
                 <p>Slim & Natural</p>
             </div>
             <div class="col-md-2 shirt">
                 <img src="{{asset('/assets/img/shirt.jpg')}}">
                 <h2>Sienna</h2>
                 <p>Regular & Natural</p>
             </div>
             <div class="col-md-2 shirt">
                 <img src="{{asset('/assets/img/shirt.jpg')}}">
                 <h2>Napoli</h2>
                 <p>Regular & lightly padded</p>
             </div>
            <div class="col-md-1 shirt">
                 
             </div>
         
         
         
      
    </div>
</div>
    </div>
</desktop>   
<!-- end Categories  -->  
  
  

<!-- start Categories  responsive-->
<responsive>
    <div class="container-fluid"> 
 @foreach($category_name1 as $category_name)
        
         
         
    @foreach($category_name->description as $descriptiona)
         <h4 style="text-align: center;color: #928e8e;">{{$descriptiona->categories_name}}</h4>
         @endforeach
          @foreach($category_name->heightLowProducts as $products)
          <div class="row  categories res-categories">
        <div class="col-12  sec-one" >
            <div class="price">
                     @if(  $products->like()==0 )
                       <form method="POST" action="{{ route('add.to.like') }}" >
                         @csrf
                        <input type="hidden" name="product_id" value="{{$products->products_id}}" >
                         <button type="submit" style="    background: white;border: 0px;display: flex;">
                                                <i class="fa fa-heart-o " style="font-size: 25px;margin-top: -4px;color: #7e7c7d;"></i>

                        </button>
                        </form>
                        @elseif($products->like()==1)
                         <form method="POST" action="{{ route('destroy.like') }}" >
                         @csrf
                        <input type="hidden" name="product_id" value="{{$products->products_id}}" >
                         <button type="submit" style="    background: white;border: 0px;display: flex;">
                            <i class="fa fa-heart " style="font-size: 25px;margin-top: -4px;color: red"></i>

                        </button>
                        </form>
                        @endif

            </div>
            <div class="row" >
                <div class="col-2 text">
                    <span>
                    <h2>{{ $products->description->products_name }} </h2>
                    
                    <h2>{{ $products->products_price }}<span class="currency_span">AED</span></h2>
                    
                    </span>
                </div>
                <div class="col-10">
                    <a style="    text-align: center; display: flex;justify-content: center;" href="{{route('website.product',['id'=>$products->products_id])}}">
                        <img  src="{{URL::asset((!is_null($products->mainImage)?$products->mainImage->path():'prod.png'))}}">
                    </a>
                </div>
            </div>
        </div>
       
    </div>
    <hr>
          @endforeach
         @endforeach
    
   
 
    
    <div clas="row  categories res-categories" style="text-align:center">
         <button   class="btn-more"   onclick="show()" >See more </button>
    </div>
    
    
    <div  id="more" class="more">
        <div class="container-fluid" >
     
     <div class="row   fit">
         <h1>Are you looking for a <span>specific fit?</span></h1>
     </div>
     
         <div class="row  categories  ">
         
            <div class="col-md-1 shirt">
                 
             </div>
             <div class="col-md-2 shirt">
                 <img src="{{asset('/assets/img/shirt.jpg')}}">
                 <h2>Washington</h2>
                 <p>Extra slim fit</p>
             </div>
             <div class="col-md-2 shirt">
                 <img src="{{asset('/assets/img/shirt.jpg')}}">
                 <h2>Lazio</h2>
                 <p>Slim & lightly padded</p>
             </div>
             <div class="col-md-2 shirt">
                 <img src="{{asset('/assets/img/shirt.jpg')}}">
                 <h2>Havana</h2>
                 <p>Slim & Natural</p>
             </div>
             <div class="col-md-2 shirt">
                 <img src="{{asset('/assets/img/shirt.jpg')}}">
                 <h2>Sienna</h2>
                 <p>Regular & Natural</p>
             </div>
             <div class="col-md-2 shirt">
                 <img src="{{asset('/assets/img/shirt.jpg')}}">
                 <h2>Napoli</h2>
                 <p>Regular & lightly padded</p>
             </div>
            <div class="col-md-1 shirt">
                 
             </div>
         
         
         
      
    </div>
    </div>
 
    </div>
    
    
    
</div>


    
</responsive>    
<!-- end Categories  responsive-->  
  
  
  
    
    
    @endsection
    @section('additional_scripts')
 <script src="{{asset('assets/js/Filter.js')}}"></script>

    @endsection
