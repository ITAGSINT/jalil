@extends('layouts.website.main')
@section('additional_styles')
 @php
if(Auth::id()!=null)
{$user_id_Cookie=Auth::id();}
else {
 if(Cookie::get('user_id')==null)
{$user_id_Cookie=0;}
else {
 $user_id_Cookie=Cookie::get('user_id') ;
}
}

@endphp
@endsection
@section('content')

  <style>

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
  .ftco-navbar-light .navbar-nav > .nav-item > .nav-link{color:white;    height: 100%;}
  .ftco-navbar-light {
    background: #00000054 !important;
    z-index: 3;
    padding: 0;
}
      .ftco-section {
    padding: 7em 0 4em !important;
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
  <section class="ftco-section">
    	<div class="container">
    		<div class="row">
    			<div class="col-lg-8 mb-5 ftco-animate ">
    			     @php
                        $count=1;  
                      @endphp
                @foreach ( $items as $item)
                
                <div class="row product_card"  >
                <div class="col-3 p-3" style=""><img  src="{{$item->image}}" class="fit_image"></div>
                <div class="col-9 order_div">
               <form method="POST" action="/destroy-card" id="add_to_card">
                @csrf
                <input type="hidden" name="customers_basket_id" value="{{$item->customers_basket_id}}" >
               <input type="hidden" name="product_id" value="{{$item->products_id}}" >
            
             
                  <button type="submit" class="btn btn-white" style=" float: right;width: 40px;height: 40px;" ><span class="ion-ios-trash"></span></button>
                  </form>
                  <h5 style="font-size: 18px;    font-weight: bold;">{{$item->name}} - {{$item->price}}$</h5>
            
                  <h5 style="font-size: 15px;color: #a8a8a8;">
                  
                  @foreach($item->option as $details)
                   <input type="hidden" name="option[{{$details[2]}}]"   value="{{$details[3]}}" >
                 <span>{{$details[0]}} : {{$details[1]}} </span><br>
                 
                  @endforeach
                 </h5>
                    
                
                  <!-- put the product id  -->
                  <button class="btn " style="color: #c2b6ff;"  onclick="increase_fun({{$item->customers_basket_id}},{{$user_id_Cookie}},0,'-')">-</button>
                    <input class="btn btn-white" type="text" value="{{$item->quantity}}"  id="{{$item->customers_basket_id}}_qu" name="{{$item->customers_basket_id}}_qu" style="width: 50px;text-align: center;">
                    <button class="btn " style="color: #c2b6ff;"  onclick="increase_fun({{$item->customers_basket_id}},{{$user_id_Cookie}},{{$item->max_quantity}},'+')">+</button>
               </div>
            </div>
              @php
                        $count++;  
                      @endphp
                @endforeach
    			</div>
    			<div class="col-lg-4 product-details pl-md-5 ftco-animate">
    			    <div class="cart-total mb-3">
    					<h3>Cart Totals</h3>
    					<p class="d-flex">
    						<span>Subtotal</span>
    						<span id="price1_id"></span>

    					</p>
    					<p class="d-flex">
    						<span>Delivery</span>
    						<span>$0.00</span>
    					</p>
    					<p class="d-flex">
    						<span>Discount</span>
    						<span>$0.00</span>
    					</p>
    					<hr>
    					<p class="d-flex total-price">
    						<span>Total</span>
    						<span id="total_div"></span>
    					</p>
    				</div>
    				<p class="text-center"><a href="{{route('website.checkout')}}" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
    			</div>
    		</div>
    	</div>
    </section>


  
                
                
@endsection
@section('additional_scripts')
<script>
$(document).ready(function() {


$.get('{{ route("view.cart.website")}}',{user_id: {{$user_id_Cookie}}},function(data){
         
              var total=0;
              for (var i = 0; i < data.length; i++) {
                  console.log(data);
                // += " <a href='/categories/"++"'>"+data[i].name+" </a>";
                 total += parseFloat(data[i].price*data[i].quantity);
                   
                             
                 }
                // $('#cart_orders').html(products);
                 $('#total_div').html(total+" $");
                 $('#price1_id').html(total+" $");
                
                 
     
        },'json');
});
      function increase_fun(customers_basket_id,user_id_Cookie,max_quantity,option_id){
     var i=customers_basket_id+"_qu";
     var x = document.getElementById(i).value; 
    
     if(option_id=='+'){
          if (x<max_quantity){
     x++;
     $.get('{{ route("update.quantity")}}',{user_id: user_id_Cookie,customers_basket_id:customers_basket_id,opration:option_id},function(data){},'json');}
     else{   toastr.warning('You added all available to your cart!!');}
     }
     else{
          if(x==1){
          
      }
      else{
      x--;
    $.get('{{ route("update.quantity")}}',{user_id: user_id_Cookie,customers_basket_id:customers_basket_id,opration:option_id},function(data){},'json');
      }
     
         
     }
     $.get('{{ route("view.cart.website")}}',{user_id: {{$user_id_Cookie}}},function(data){
         
              var total=0;
              for (var i = 0; i < data.length; i++) {
                  console.log(data);
                // += " <a href='/categories/"++"'>"+data[i].name+" </a>";
                 total += parseFloat(data[i].price*data[i].quantity);
                   
                             
                 }
                // $('#cart_orders').html(products);
                 $('#total_div').html(total+" $");
                 $('#price1_id').html(total+" $");
                
                 
     
        },'json');
     document.getElementById(i).value=x; 
   
  }
</script>
@endsection
