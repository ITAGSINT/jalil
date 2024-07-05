@extends('layouts.website.main')
@section('additional_styles')
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
<style>
    .row {
    --bs-gutter-x: 0 !important;
    --bs-gutter-y: 0;}
    .emptyspace {
    height: 10px !important;
}
.b_product_card{
    padding-right: 15px !important;
}
.product_card h5{font-size: 14px !important;}
img.fit_image {
    width: 100%;
    border: 1px solid #f2f2f2;
}
</style>
@endsection
@section('content')
  <section class="ftco-section">
    	<div class="container">
    		

        <div class="row" style="padding:15px">
      
            <div class="col-sm-1"></div>
             <div class="col-sm-10" style="    padding: 0 9%;">
                 

                  <div style="     display: flex;align-items: center;align-items: baseline;    justify-content: center;  ">
                        <div class=" tab_checkput tab_checkput_active" style=" text-align: center;" id="prepared_text">
                            <div class="point_div_order " onclick="next_fun(1)" id="prepared_num"><img style="width: 60px;" src="{{asset('/assets/img/order1_0.png')}}" class=""></div>
                            Being <br>prepared</div>
                              <svg height="2" width="300"><line x1="0" y1="0" x2="300" y2="0" style="stroke:#d8d7d8;stroke-width:7" /> </svg>
                                <div class=" tab_checkput" style=" text-align: center;" id="shipped_text">
                              <div class="point_div_order" onclick="next_fun(2)" id="shipped_num"><img style="width: 60px;" src="{{asset('/assets/img/order2_1.png')}}" class=""></div>
                              Shipped</div>
                              <svg height="2" width="300"><line x1="0" y1="0" x2="300" y2="0" style="stroke:#d8d7d8;stroke-width:7" /> </svg>
                              <div class=" tab_checkput" style=" text-align: left;" id="delivered_text">
                              <div class="point_div_order" onclick="next_fun(3)" id="delivered_num"><img style="width: 60px;" src="{{asset('/assets/img/order3.png')}}" class=""></div>
                             Delivered</div>
                             </div>
               
                 
            
                            </div>
              <div class="col-sm-1"></div>
        </div>
        
                <div class="row" style="display:flex;    padding-top: 60px;">
                          
                    <div class="col-md-1" ></div>
                <div class="col-md-6" style=" ">
                    
                   <div id="prepared_id">
                   
                      @foreach ( $Order as $Order_products)
                      @if($Order_products->status=='Pending')
                       <div class="row product_card"  >
                        <div class="col-3" style=""><img  src="{{asset($Order_products->mainImage)}}" class="fit_image"></div>
                        <div class="col-9" style="position: relative; padding-left: 10px;padding-top: 15px;">
                            <h5 style="font-size: 18px;color: #a8a8a8;">{{$Order_products->product_name}}</h5>
                            <p>{{$Order_products->created_at}}</p>
                             @foreach ( $Order_products->orders_products_att as $orders_products_att)
                            <h5 style="font-size: 18px;color: #a8a8a8;">{{$orders_products_att->option}}: {{$orders_products_att->val}}</h5>

                             @endforeach
                            <p>{{$Order_products->products_description}}</p>
                            <div class="b_product_card">
                            <h1 style="font-size: 18px;color: #a8a8a8;    text-align: right;    margin: 0;" >{{$Order_products->product_price}} AED X {{$Order_products->products_quantity}}</h1>
                            <hr>
                            </div>
                        </div>
                    </div>
                    @endif
                      @endforeach
            
                    <div style="height: 200px;"></div>
                    </div>
                    
                    <div id="shipped_id">
                    
                    @foreach ( $Order as $Order_products)
                      @if($Order_products->status=='Shipped')
                       <div class="row product_card"  >
                        <div class="col-3" style=""><img  src="{{asset($Order_products->mainImage)}}" class="fit_image"></div>
                        <div class="col-9" style="position: relative; padding-left: 10px;padding-top: 15px;">
                            <h5 style="font-size: 18px;color: #a8a8a8;">{{$Order_products->product_name}}</h5>
                            <p>{{$Order_products->created_at}}</p>
                             @foreach ( $Order_products->orders_products_att as $orders_products_att)
                            <h5 style="font-size: 18px;color: #a8a8a8;">{{$orders_products_att->option}}: {{$orders_products_att->val}}</h5>

                             @endforeach
                            <p>{{$Order_products->products_description}}</p>
                            <div class="b_product_card">
                            <h1 style="font-size: 18px;color: #a8a8a8;    text-align: right;    margin: 0;" >{{$Order_products->product_price}} AED X {{$Order_products->products_quantity}}</h1>
                            <hr>
                            </div>
                        </div>
                    </div>
                    @endif
                      @endforeach
            
                    <div style="height: 200px;"></div>
                    </div>
                    <div id="delivered_id">
                     @foreach ( $Order as $Order_products)
                      @if($Order_products->status=='Completed')
                       <div class="row product_card"  >
                        <div class="col-3" style=""><img  src="{{asset($Order_products->mainImage)}}" class="fit_image"></div>
                        <div class="col-9" style="position: relative; padding-left: 10px;padding-top: 15px;">
                            <h5 style="font-size: 18px;color: #a8a8a8;">{{$Order_products->product_name}}</h5>
                            <p>{{$Order_products->created_at}}</p>
                             @foreach ( $Order_products->orders_products_att as $orders_products_att)
                            <h5 style="font-size: 18px;color: #a8a8a8;">{{$orders_products_att->option}}: {{$orders_products_att->val}}</h5>

                             @endforeach
                            <p>{{$Order_products->products_description}}</p>
                            <div class="b_product_card">
                            <h1 style="font-size: 18px;color: #a8a8a8;    text-align: right;    margin: 0;" >{{$Order_products->product_price}} AED X {{$Order_products->products_quantity}}</h1>
                            <hr>
                            </div>
                        </div>
                    </div>
                    @endif
                      @endforeach
            
                    <div style="height: 200px;"></div>
                    </div>
                </div>
                <div class="col-md-5" ></div>
            </div>
         </div>    
    </div>
    @endsection
    @section('additional_scripts')
    <script>
$("#shipped_id").hide();
$("#delivered_id").hide();
  function increase_fun(id){
     var i=id+"_qu";
     var x = document.getElementById(i).value; 
     x++;
     document.getElementById(i).value=x; 
     
  }
  function decrease_fun(id){
    var  i=id+"_qu";
      var x = document.getElementById(i).value;
      if(x==0){
          
      }
      else{
      x--;}
       document.getElementById(i).value=x; 
  }
  function next_fun(num){
       if (num==1){
        $("#prepared_id").show();
        $("#shipped_id").hide();
        $("#delivered_id").hide();
    
        
        $("#prepared_text").addClass('tab_checkput_active');
        $("#shipped_text").removeClass('tab_checkput_active');
        $("#delivered_text").removeClass('tab_checkput_active');
        
        $('#prepared_text img').attr('src','{{asset("/assets/img/order1_0.png")}}');
        $('#shipped_text img').attr('src','{{asset("/assets/img/order2_1.png")}}');
        $('#delivered_text img').attr('src','{{asset("/assets/img/order3.png")}}');
     
    }
    if(num==2){
         $("#prepared_id").hide();
        $("#shipped_id").show();
        $("#delivered_id").hide();
    
        
        $("#prepared_text").removeClass('tab_checkput_active');
        $("#shipped_text").addClass('tab_checkput_active');
        $("#delivered_text").removeClass('tab_checkput_active');
        
        $('#prepared_text img').attr('src','{{asset("/assets/img/order1_2.png")}}');
        $('#shipped_text img').attr('src','{{asset("/assets/img/order2_2.png")}}');
        $('#delivered_text img').attr('src','{{asset("/assets/img/order3.png")}}');
    }
    if(num==3){
       $("#prepared_id").hide();
        $("#shipped_id").hide();
        $("#delivered_id").show();
    
        
        $("#prepared_text").removeClass('tab_checkput_active');
        $("#shipped_text").removeClass('tab_checkput_active');
        $("#delivered_text").addClass('tab_checkput_active');
        
        $('#prepared_text img').attr('src','{{asset("/assets/img/order1_2.png")}}');
        $('#shipped_text img').attr('src','{{asset("/assets/img/order2_1.png")}}');
        $('#delivered_text img').attr('src','{{asset("/assets/img/order3_3.png")}}');
    }
      
  }
  
  
</script>
@endsection