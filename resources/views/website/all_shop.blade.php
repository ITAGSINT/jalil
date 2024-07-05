@extends('layouts.website.main')
@section('additional_styles')
<style>
</style>
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


@endsection
@section('content')
   <div class="hero-wrap hero-bread" style="background-image: url({{asset('/assets/images_site/bg_6.jpg')}});">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Products</span></p>
            <h1 class="mb-0 bread">Collection Products</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section bg-light">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-8 col-lg-10 order-md-last">
    				<div class="row">
		    		
		    			@foreach ($product as $products)
            			<div class="col-sm-6 col-md-6 col-lg-4 ftco-animate">
            				<div class="product pro_{{$products->products_id}}">
            					<a href="{{route('website.product',['id'=>$products->products_id])}}" class="img-prod"><img class="img-fluid" src="{{URL::asset((!is_null($products->mainImage)?$products->mainImage->path():'prod.png'))}}" alt="Colorlib Template">
            						@if($products->discount_price!=0)
            						<span class="status">Sale</span>
            						@endif
            						<div class="overlay"></div>
            					</a>
            					<div class="text py-3 px-3">
            						<h3><a href="{{route('website.product',['id'=>$products->products_id])}}">{{$products->description->products_name}}</a></h3>
            						<div class="d-flex">
            							<div class="pricing">
        		    						<p class="price">
        		    						    @if($products->discount_price==0)
        		    						    <p class="price"><span>${{ $products->products_price }}</span></p>
        		    						    @else
        		    						    <span class="mr-2 price-dc">${{ $products->products_price }}</span><span class="price-sale">${{ $products->discount_price }}</span>
        		    						    @endif
        		    						    </p>
        		    					</div>
        		    					<div class="rating">
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
                                                    
        
        	    							<p class="text-right ">
        	    								<a onclick="rating_fun(1,{{$products->products_id}})"><span  class="rating @if($rev>=1) ion-ios-star @else ion-ios-star-outline @endif "></span></a>
        	    								<a onclick="rating_fun(2,{{$products->products_id}})"><span class="rating @if($rev>=2) ion-ios-star @else ion-ios-star-outline @endif"></span></a>
        	    								<a onclick="rating_fun(3,{{$products->products_id}})"><span class="rating @if($rev>=3) ion-ios-star @else ion-ios-star-outline @endif"></span></a>
        	    								<a onclick="rating_fun(4,{{$products->products_id}})"><span class="rating @if($rev>=4) ion-ios-star @else ion-ios-star-outline @endif"></span></a>
        	    								<a onclick="rating_fun(5,{{$products->products_id}})"><span class="rating @if($rev>=5) ion-ios-star @else ion-ios-star-outline @endif"></span></a>
        	    							</p>
        	    						</div>
        	    					</div>
        	    					<div class="bottom-area d-flex px-3">
            							<a href="#" class="add-to-cart text-center py-2 mr-1"><span><i class="ion-ios-cart ml-1"></i></span></a>
            							@if(  $products->like()==0 )
                                                    <form method="POST" style="width: 100%;" action="{{ route('add.to.like') }}" >
                                                     @csrf
                                                        <input type="hidden" name="product_id" value="{{$products->products_id}}" >
                                                        <button type="submit" style="width: 100%;" class="btn buy-now text-center py-2">
                                                            <i class="ion-ios-heart"></i>
                                                        </button>
                                                    </form>
                                                    @elseif($products->like()==1)
                                                     <form method="POST" style="width: 100%;" action="{{ route('destroy.like') }}" >
                                                     @csrf
                                                        <input type="hidden" name="product_id" value="{{$products->products_id}}" >
                                                        <button type="submit" style="width: 100%;" class="btn buy-now text-center py-2">
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
		    		<div class="row mt-5">
		          <div class="col text-center">
		            <div class="block-27">
		              <ul>
		                <li><a @if($page-1>0) href="?page={{$page-1}}" @endif>&lt;</a></li>
		                @php
                        for( $i = 1.0 ; $i <= $pages ; $i++ ) { @endphp
		                <li class="@if($page == $i) active @endif"><a href="?page={{$i}}">{{$i}}</a></li>
		                 @php } @endphp
		                
		                <li><a @if($page+1<$pages) href="?page={{$page+1}}"  @endif>&gt;</a></li>
		              </ul>
		            </div>
		          </div>
		        </div>
		    	</div>

		    	<div class="col-md-4 col-lg-2 sidebar">
		    		<div class="sidebar-box-2">
		    			<h2 class="heading mb-4"><a href="#">Categories</a></h2>
		    			<ul>
		    			    <li class="{{Request::is('*shop/all*')?'active':''}}"><a href="{{route('website.shop')}}">All</a></li>
		    			@foreach ($category_name as $category)
		    			
		    				<li class="{{Request::is('*shop/'.$category->categories_id)?'active':''}}"><a href="{{route('website.shop.categories',$category->categories_id)}}">{{$category->description[0]->categories_name}}</a></li>
								
						@endforeach
		    			</ul>
		    		</div>
		    	
    			</div>
    		</div>
    	</div>
    </section>
    
    @endsection
    @section('additional_scripts')


    @endsection
