<!-- include the library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.7/html5-qrcode.min.js" integrity="sha512-dH3HFLqbLJ4o/3CFGVkn1lrppE300cfrUiD2vzggDAtJKiCClLKjJEa7wBcx7Czu04Xzgf3jMRvSwjVTYtzxEA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script><style>
.distroy_btn{
    border: none;
    background: none;
    padding: 0;
    margin: 0;
}
    .order_details_table tr{
        background-color:#26292c;
    }
    .bg_gray{background: var(--lightgray);}
   .btn_serch{
           border: none;
    padding: 1px 8px;
    background: #f4f6f9;
    margin-left: -14px;
    border-top-right-radius: 9px;
    border-bottom-right-radius: 10px;
    color: #007bff;
    font-size: 25px;
   }
   .example{
           display: flex;
    flex-direction: row;
    align-items: center;
   }
   .select_btn{
           background: #f4f6f9;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    width: 80%;
    padding: 7px;
    height: 41px;
    margin: 8px 0;
   }
   .product_card img {
    width: 100%;
        padding: 0;
}
.name_price_div {
    display: flex;
    justify-content: space-between;flex-direction: column;
}
.product_color {
    width: 17px;
    height: 17px;
    margin: 1px;
    border-radius: 50px;
    box-shadow: -1px 2px 6px rgb(179 177 177 / 29%);
}
input[type="radio"] {
    visibility: hidden;
    width: 0;
}
:checked + label {
    border-radius: 50%;
    background: white;
    border: 1px solid gray;
}
.colod_div{
    display: flex;
    justify-content: space-between;
}
.select_size1 {
    background: #f4f6f9;
    border: none;
    border-radius: 10px;
    height: 30px;
    padding: 5px;
    width: 46%;
}
button.product_btn {
    background: #f4f6f9;
    border: none;
    border-radius: 10px;
    width: 100%;
    padding: 8px;
}
button.product_btn:hover {
  background: #f4f6f9bd;
    border: none;
    border-radius: 10px;
    width: 100%;
    padding: 8px;
}
hr {
    margin-top: .5rem;
    margin-bottom: .5rem;
    border: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.color_div{
        display: flex;
    justify-content: space-between;
    align-items: center;
}
button.add_cart_btn {
    background: #f4f6f9;
    border: none;
    width: 100%;
    padding: 5px;
    border-radius: 10px;
}
.product_card {
        box-shadow: 0 0px 8px rgb(0 0 0 / 7%);
    padding: 10px;
    margin: 16px 0px;
    font-size: 12px;
}
.size_div {
    display: flex;
    justify-content: space-between;
}
.order_div {
   display: flex;
    justify-content: space-between;
    padding:  0;
    flex-direction: column;
}
.order_total {
    display: flex;
    justify-content: space-between;
}
button.checkout_btn {
    background: white;
    border: none;
    width: 100%;
    padding: 8px;
    border-radius: 10px;
}


.choose_div {
    display: flex;
    flex-direction: row-reverse;
    align-items: flex-end;
    justify-content: space-between;
}

.choose_div a:hover {
    opacity: .5;
}

.choose_div a {
    color: var(--primary-color);
}
.description_div {
    position: absolute;
    width: 500px;
    left: -500px;
    margin-top: 5px;
    background: #ffffff;
    padding: 15px;
    box-shadow: 2px 1px 8px rgb(0 0 0 / 12%);
     display: none; 
}
.description_div:before {
       content: '';
    position: absolute;
    top: 10px;
    right: -1%;
    height: 20px;
    background: white;
    width: 14px;
    transform: skew(25deg, 0deg);
    border: 1px solid white;
    border-bottom: none;
}
.description_div:after {
    content: '';
    position: absolute;
    top: 30px;
    right: -1%;
    background: #ffffff;
    height: 20px;
    width: 13px;
    transform: skew(-25deg, 0deg);
    border: 1px solid #ffffff;
    border-top: none;
}
.description_div hr {
    margin-top: 4px !important;
    margin-bottom: 9px !important;
}
span.store_name {
    background: #f4f6f9;
    padding: 5px 8px;
    position: absolute;
    top: 2px;
        border-radius: 10px;
}
a {
    color: #6c797f !important;
    text-decoration: none;
    background-color: transparent;
        cursor: pointer !important;
}
</style>
<style>
.btn_store{
        width: 8%;
    float: right;
    margin: 0;
    padding: 0;
    background: none;
    border: none;
    font-weight: bold !important;
    color: var(--primary-color) !important;
}
    .order_details_table tr{
        background-color:#26292c;
    }
    .nav-tabs{
      padding:0 !important;  
    }
    .nav-tabs {
    border-bottom: 1px solid #f4f6f9 !important;
    background: white;
}
    .tab-content {
    border: 1px solid #f4f6f9 !important;
    border-top: 0;
    padding: 2rem 1rem;
    text-align: justify;
}
.nav-tabs .nav-link {
    background: none !important;
    color: #6c797f !important;
    border-radius: 0;
    border: 1px solid #f4f6f9 !important;
    padding: .75rem 1.5rem;
}
.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    color: #ffffff;
    background-color: #f4f6f9 !important;
    border-color: #f4f6f9;
}
.card .card-title {
    color: var(--primary-color);
    font-weight: bold;
    text-transform: capitalize;
    float: initial !important;
}
.table thead th, .jsgrid .jsgrid-table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #e5e5e5 !important;
}
.card-header {
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgb(255 255 255) !important;
    border-bottom: 1px solid #e5e5e5;
}
.btn-link {
    font-weight: bold !important;
    color: var(--primary-color) !important;
    text-decoration: none !important;
    font-size: 25px !important;
    border: none !important;
    border-bottom: 1px solid #e5e5e5 !important;
    border-radius: 0 !important;
    padding-bottom: 17px !important;
}
.tab-content {
    border: 1px solid #2c2e33;
    border-top: 0;
    padding: 2rem 2rem;
    text-align: justify;
}
.table th, .jsgrid .jsgrid-table th, .table td, .jsgrid .jsgrid-table td {
    padding: 0.9375rem;
    vertical-align: top;
    border-top: 1px solid #e5e5e5 !important;
}
.table td {
    padding: 0 !important;
}
.paginate_button a {
    font-size: 0.875rem !important;
}
.move_div select, .move_div input, .move_div button {
    width: 80% !important;
    background: #f4f6f9 !important;
    color: #6c797f !important;
    border-radius: 10px !important;
    margin: 0 !important;
    border: none !important;
    margin: 2px !important;
}
.table-responsive {
    display: block;
    width: 100%;
    overflow-x: unset !important;
    -webkit-overflow-scrolling: touch;
}
table.dataTable td, table.dataTable th {
    text-align: center;
}
.page-item.disabled .page-link, .jsgrid .jsgrid-pager .disabled.jsgrid-pager-nav-button .page-link, .jsgrid .jsgrid-pager .disabled.jsgrid-pager-page .page-link, .page-item.disabled .jsgrid .jsgrid-pager .jsgrid-pager-nav-button a, .jsgrid .jsgrid-pager .jsgrid-pager-nav-button .page-item.disabled a, .jsgrid .jsgrid-pager .disabled.jsgrid-pager-nav-button a, .page-item.disabled .jsgrid .jsgrid-pager .jsgrid-pager-page a, .jsgrid .jsgrid-pager .jsgrid-pager-page .page-item.disabled a, .jsgrid .jsgrid-pager .disabled.jsgrid-pager-page a {
    color: #6c757d;
    pointer-events: none;
    cursor: auto;
    background-color: #fff !important;
    padding: 0 !important;
    border-color: #ff000000 !important;
    padding-top: .85em !important;
}
.page-item.active .page-link, .jsgrid .jsgrid-pager .active.jsgrid-pager-nav-button .page-link, .jsgrid .jsgrid-pager .active.jsgrid-pager-page .page-link, .page-item.active .jsgrid .jsgrid-pager .jsgrid-pager-nav-button a, .jsgrid .jsgrid-pager .jsgrid-pager-nav-button .page-item.active a, .jsgrid .jsgrid-pager .active.jsgrid-pager-nav-button a, .page-item.active .jsgrid .jsgrid-pager .jsgrid-pager-page a, .jsgrid .jsgrid-pager .jsgrid-pager-page .page-item.active a, .jsgrid .jsgrid-pager .active.jsgrid-pager-page a {
    z-index: 3;
      padding-top: .85em !important;
    color: #007bff !important;
    background-color: #007bff00 !important;
    border-color: #007bff00 !important;
}

.move_div .col-12 {
    display: flex;
    align-items: center;
    padding: 8px 16px;
    justify-content: space-between;
}
select.form-control:focus, select.asColorPicker-input:focus, .dataTables_wrapper select:focus, .jsgrid .jsgrid-table .jsgrid-filter-row select:focus, .select2-container--default select.select2-selection--single:focus, .select2-container--default .select2-selection--single select.select2-search__field:focus, select.typeahead:focus, select.tt-query:focus, select.tt-hint:focus {
    outline: 1px solid white !important;
}
.form-control:focus, .asColorPicker-input:focus, .dataTables_wrapper select:focus, .jsgrid .jsgrid-table .jsgrid-filter-row input:focus[type=text], .jsgrid .jsgrid-table .jsgrid-filter-row select:focus, .jsgrid .jsgrid-table .jsgrid-filter-row input:focus[type=number], .select2-container--default .select2-selection--single:focus, .select2-container--default .select2-selection--single .select2-search__field:focus, .typeahead:focus, .tt-query:focus, .tt-hint:focus {
    border: 1px solid rgb(244 246 249) !important;
    background-color: #f4f6f9 !important;
}
button.add_btn {
    border: none;
    background: #f4f6f9;
    border-radius: 10px;
    padding: 9px 30px;
    float: right;
    margin-top: 25px;
}
</style>
@extends('layouts.Dashboard.main')
@section('content')
<div class="content-wrappe">
    <div class="row">
       
        <div class="col-sm-2 bg_gray"  style="padding: 34px 40px;">
            <div class="bg_gray">
             <h3>  Categories </h3><hr>
            <div id="cat_0" style="display: block;">
                  <a  href="{{ route('dashboard.point_of_sale')}}">All</a><br>
                @foreach($categories as $categorie)
          
           
              <a id="a_id_166">
                   {{ $categorie->name }}<i class="fa menu-anngle fa-angle-down"></i>
                    <div style="    padding-left: 20px;" id="cat_166">
                         @foreach($categorie->sun as $sun)
                        <a href="{{ route('dashboard.point_of_sale.cat',$sun->categories_id)}}">
                            {{$sun->description[0]->categories_name}} <div ></div>
                        </a>
                        
                         @endforeach
                    </div>
                </a>
                @endforeach
               
            </div>
            </div>
        </div>
        <div class="col-sm-7 "style="padding: 20px;">
            <div class="row" >
            <form class="col-6" style="">
              <lable>Sort by :</lable>
              <select class="select_btn">
                  <option value="0">---</option>
                  <option value="1">Featured</option>
                  <option value="2">Newest</option>
                  <option value="3">Price High-Low</option>
                  <option value="4">Price Low-High</option>
              </select>
            </form>
            <form class="col-6" style="  display:none">
              <lable>Store name: {{Auth::user()->role_id}}</lable>
              
            </form>
           <form class="example col-6" >
              <input type="text" placeholder="Search.." name="search" id="myInput">
              <button class="btn_serch" type="submit"><i class="mdi mdi-magnify"></i></button>
            </form>
            </div>
            @if(Auth::user()->role_id==1 || Auth::user()->role_id==13)
             
                
                  
                               
                                <div class="row" id="myList1" style="height: 70vh;overflow-y: scroll;">
                                      @foreach($stores as $store)
                                      @foreach($store->Product as $product) 
                 @foreach($product as $pro)
                  @if(Route::is('dashboard.point_of_sale.cat') )
                      @foreach($pro->category as $cat)
                      @if($cat->categories_id==$categories_id)
                        <div class="product_div col-3">
                           <div class="product_card">
                               <span class="store_name">{{$store->name}}</span>
                               <img src="{{URL::asset($pro->mainImage)}}">
                               <div class="name_price_div">
                                   <span class="product_name">{{$pro->description->products_name}}</span><span style="font-size: 10px;color: #177bff;">{{$pro->original_price}} AED</span>
                               </div>
                               <hr>
                               <form method="POST" action="{{ route('storeInDashboard') }}">
                            @csrf
                                <div class="colod_div">
            				       <lable> color</lable>
            				      
            				       <div>
            				            @foreach($pro->attributes as $attributes)
                               
                               
                               @if($attributes->pivot->options_id==1)
                               @foreach($attributes->actval as $actval)
                               <input type="radio" id="d{{$pro->products_id}}{{$attributes->pivot->options_values_id}}" name="color_Att{{$pro->products_id}}" value="{{$attributes->pivot->options_values_id}}" checked>
                                    
                                  <label for="d{{$pro->products_id}}{{$attributes->pivot->options_values_id}}">
                                    <div class="product_color" style="    background: 	{{$actval->product_act_val}};"></div>	
                                  </label>
                                   @endforeach
                                @endif
                                 @endforeach
                                    
                                  </div>
                                </div>
                                @php $count=0; @endphp
                                @foreach($pro->attributes as $attributes)
                                            @if($attributes->pivot->options_id==3)
                							   @php $count++; @endphp
                							@endif
                                        @endforeach
                                <div class="size_div">
                                    <lable> size</lable>
                                    @if($count==0)
                                    no size option
                                    @else
                                     <select class="input   select_size1" name="color_Att1" id="option" >
                                          @foreach($pro->attributes as $attributes)
                                            @if($attributes->pivot->options_id==3)
                                             @foreach($attributes->actval as $actval)
                							  <option value="{{$attributes->pivot->options_values_id}}">	{{$actval->products_options_values_name}}  </option>
                					    	@endforeach
                							@endif
                                        @endforeach
            					 </select>
            					    @endif
                                </div>
                                <hr>
                            
                                 <input type="hidden" name="product_id" value="{{$pro->products_id}}" >
                              
            					 <button type="submit" class="add_cart_btn">Add</button>
            				</form>
                           </div>
                       </div>
                       @endif
                        @endforeach
                  @else
                  <div class="product_div col-3">
                   <div class="product_card">
                         <span class="store_name">{{$store->name}}</span>
                       <img src="{{URL::asset($pro->mainImage)}}">
                       <div class="name_price_div">
                           <span class="product_name">{{$pro->description->products_name}}</span><span style="font-size: 10px;color: #177bff;">{{$pro->original_price}} AED</span>
                       </div>
                       <hr>
                       <form method="POST" action="{{ route('storeInDashboard') }}">
                    @csrf
                      <div class="colod_div">
    				       <lable> color</lable>
    				      
    				       <div>
    				            @foreach($pro->attributes as $attributes)
                       
                       
                       @if($attributes->pivot->options_id==1)
                       @foreach($attributes->actval as $actval)
                       <input type="radio" id="d{{$pro->products_id}}{{$attributes->pivot->options_values_id}}" name="color_Att{{$pro->products_id}}" value="{{$attributes->pivot->options_values_id}}" checked>
                            
                          <label for="d{{$pro->products_id}}{{$attributes->pivot->options_values_id}}">
                            <div class="product_color" style="    background: 	{{$actval->product_act_val}};"></div>	
                          </label>
                           @endforeach
                        @endif
                         @endforeach
                            
                          </div>
                        </div>
                        @php $count=0; @endphp
                        @foreach($pro->attributes as $attributes)
                                    @if($attributes->pivot->options_id==3)
        							   @php $count++; @endphp
        							@endif
                                @endforeach
                        <div class="size_div">
                            <lable> size</lable>
                            @if($count==0)
                            no size option
                            @else
                             <select class="input   select_size1" name="color_Att1" id="option" >
                                  @foreach($pro->attributes as $attributes)
                                    @if($attributes->pivot->options_id==3)
                                     @foreach($attributes->actval as $actval)
        							  <option value="{{$attributes->pivot->options_values_id}}">	{{$actval->products_options_values_name}}  </option>
        					    	@endforeach
        							@endif
                                @endforeach
    					 </select>
    					    @endif
                        </div>
                   <hr>
    					  <input type="hidden" name="product_id" value="{{$pro->products_id}}" >
                      
    					 <button type="submit" class="add_cart_btn">Add</button>
    				</form>
                   </div>
               </div>
                  @endif
                  @endforeach
           
             @endforeach
                 @endforeach
             </div>
                               
                               
                          
                   
             
                
            @else
            @foreach($stores as $store)
                @if(Auth::user()->store_user[0]->store_id==$store->id)
              
                    <div class="row" id="myList1" style="height: 70vh;overflow-y: scroll;">
                          @foreach($store->Product as $product) 
                 @foreach($product as $pro)
                  @if(Route::is('dashboard.point_of_sale.cat') )
                      @foreach($pro->category as $cat)
                      @if($cat->categories_id==$categories_id)
                        <div class="product_div col-3">
                           <div class="product_card">
                               <img src="{{URL::asset($pro->mainImage)}}">
                               <div class="name_price_div">
                                   <span class="product_name">{{$pro->description->products_name}}</span><span style="font-size: 10px;color: #177bff;">{{$pro->original_price}} AED</span>
                               </div>
                               <hr>
                               <form method="POST" action="{{ route('storeInDashboard') }}">
                            @csrf
                                <div class="colod_div">
            				       <lable> color</lable>
            				      
            				       <div>
            				            @foreach($pro->attributes as $attributes)
                               
                               
                               @if($attributes->pivot->options_id==1)
                               @foreach($attributes->actval as $actval)
                               <input type="radio" id="d{{$pro->products_id}}{{$attributes->pivot->options_values_id}}" name="color_Att{{$pro->products_id}}" value="{{$attributes->pivot->options_values_id}}" checked>
                                    
                                  <label for="d{{$pro->products_id}}{{$attributes->pivot->options_values_id}}">
                                    <div class="product_color" style="    background: 	{{$actval->product_act_val}};"></div>	
                                  </label>
                                   @endforeach
                                @endif
                                 @endforeach
                                    
                                  </div>
                                </div>
                                @php $count=0; @endphp
                                @foreach($pro->attributes as $attributes)
                                            @if($attributes->pivot->options_id==3)
                							   @php $count++; @endphp
                							@endif
                                        @endforeach
                                <div class="size_div">
                                    <lable> size</lable>
                                    @if($count==0)
                                    no size option
                                    @else
                                     <select class="input   select_size1" name="color_Att1" id="option" >
                                          @foreach($pro->attributes as $attributes)
                                            @if($attributes->pivot->options_id==3)
                                             @foreach($attributes->actval as $actval)
                							  <option value="{{$attributes->pivot->options_values_id}}">	{{$actval->products_options_values_name}}  </option>
                					    	@endforeach
                							@endif
                                        @endforeach
            					 </select>
            					    @endif
                                </div>
                                <hr>
                            
                                 <input type="hidden" name="product_id" value="{{$pro->products_id}}" >
                              
            					 <button type="submit" class="add_cart_btn">Add</button>
            				</form>
                           </div>
                       </div>
                       @endif
                        @endforeach
                  @else
                  <div class="product_div col-3">
                   <div class="product_card">
                       <img src="{{URL::asset($pro->mainImage)}}">
                       <div class="name_price_div">
                           <span class="product_name">{{$pro->description->products_name}}</span><span style="font-size: 10px;color: #177bff;">{{$pro->original_price}} AED</span>
                       </div>
                       <hr>
                       <form method="POST" action="{{ route('storeInDashboard') }}">
                    @csrf
                      <div class="colod_div">
    				       <lable> color</lable>
    				      
    				       <div>
    				            @foreach($pro->attributes as $attributes)
                       
                       
                       @if($attributes->pivot->options_id==1)
                       @foreach($attributes->actval as $actval)
                       <input type="radio" id="d{{$pro->products_id}}{{$attributes->pivot->options_values_id}}" name="color_Att{{$pro->products_id}}" value="{{$attributes->pivot->options_values_id}}" checked>
                            
                          <label for="d{{$pro->products_id}}{{$attributes->pivot->options_values_id}}">
                            <div class="product_color" style="    background: 	{{$actval->product_act_val}};"></div>	
                          </label>
                           @endforeach
                        @endif
                         @endforeach
                            
                          </div>
                        </div>
                        @php $count=0; @endphp
                        @foreach($pro->attributes as $attributes)
                                    @if($attributes->pivot->options_id==3)
        							   @php $count++; @endphp
        							@endif
                                @endforeach
                        <div class="size_div">
                            <lable> size</lable>
                            @if($count==0)
                            no size option
                            @else
                             <select class="input   select_size1" name="color_Att1" id="option" >
                                  @foreach($pro->attributes as $attributes)
                                    @if($attributes->pivot->options_id==3)
                                     @foreach($attributes->actval as $actval)
        							  <option value="{{$attributes->pivot->options_values_id}}">	{{$actval->products_options_values_name}}  </option>
        					    	@endforeach
        							@endif
                                @endforeach
    					 </select>
    					    @endif
                        </div>
                   <hr>
    					  <input type="hidden" name="product_id" value="{{$pro->products_id}}" >
                      
    					 <button type="submit" class="add_cart_btn">Add</button>
    				</form>
                   </div>
               </div>
                  @endif
                  @endforeach
           
             @endforeach</div>
                @endif   
                 @endforeach
           @endif
        </div>
        <div class="col-sm-3 bg_gray"  style="    padding: 34px 15px;    padding-right: 20px;">
            <div >
                <h3>Order summary</h3>
                <hr>
                @php $total=0; @endphp
                 @foreach($items as $item)
                 @php $total+=($item->final_price) * $item->customers_basket_quantity; @endphp
               <div class="order_div">
                    <div class="choose_div">
                      <form method="POST" action="/destroy-card" style="    margin-bottom: 0;">
                        @csrf
                        <input type="hidden" name="customers_basket_id" value="{{$item->customers_basket_id}}" >
                       <button type="submit" class="distroy_btn"><i class="mdi mdi-close"></i></button>
                       </form>
                    </div>
                    <div class="description_div"  >
                        <div style="    display: flex;flex-direction: row;">
                            <img src="{{$item->image}}" style="    width: 100px;    margin-right: 10px;"> <div ><span style="    font-size: 16px;font-weight: 900;margin-right: 15px;">{{$item->name}}</span><span>{{$item->final_price}}</span><hr>
                                    <span style="font-size: 12px;">{{$item->description}}</span><hr>
                                    <span>quantity : {{$item->customers_basket_quantity}}</span><br>
                                    @foreach($item->product_att as $id=>$details) 
                                        @if($id=='size') 
                                            @foreach($details as $value)
                                                @if($value['option_value']['value_id']==$item->size_id)
                                                    <span>@if($item->size_id)size : {{$value['option_value']['value_name']}}  @endif</span>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if($id=='color') 
                                            @foreach($details as $value)
                                                @if($value['option_value']['value_id']==$item->color_id)
                                                    <span style="    display: flex;">color: <span  class="product_color"  style="background: {{$value['option_value']['option_act_value']}};width: 17px;height: 17px;display: block;margin-left: 6px;" ></span>	</span>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                    
                                    
                                    </div> 
                                    
                        </div>
                       
                    </div>
                    <div style="display: flex;justify-content: space-between;">
                        <span class="show_description_div" style="font-size: 14px; cursor: pointer;   width: 65%;">{{$item->name}}</span>
                        <span style="    color: #007bff;margin-left: 10px;font-size: 14px;">{{$item->final_price}} X {{$item->customers_basket_quantity}}</span>
                    </div>
                        </div>
               @endforeach
               <hr>
               <div class="order_total">
                   <span>Total</span><span>{{$total}} AED</span>
               </div>
               <hr>
              <div>
                   <!--<div id="qr-reader" style="width: 100%"></div>-->
              </div>
               <div class="discount_div">
                   <span>Discount amount</span>
                   <input type="text" id="discount_id"  placeholder="Enter discount amount" style="    background: white;">
                   <button onclick="go_checkout()" class="checkout_btn">Checkout</button>
               </div>
            </div>
        </div>
      
    </div>
</div>

  @endsection
  @section('additional_scripts')
  <script>
  function go_checkout(){
      var  discount= 0;
      if($('#discount_id').val()!=''){discount= $('#discount_id').val();}
   location.href='./point_of_sale/checkout/'+discount;
  }
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myList1 .product_div .name_price_div .product_name").filter(function() {
      $(this).parent().parent().parent().toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
    <script>
        $(function() {
          
          $('#myTab li:first a').addClass('active');
           $('#myTabContent div:first').addClass('active');
            $('#myTabContent div:first').addClass('show');
 
function onScanSuccess(decodedText, decodedResult) {
    alert(`Code scanned = ${decodedText}`, decodedResult);
}
var html5QrcodeScanner = new Html5QrcodeScanner(
	"qr-reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);

        });
        $(function() {
            $('.sidebar').addClass('active');
         $('.sidebar').css('width','60px');
         $('.menu-title').hide();
         $('.sidebar .nav .nav-item .menu-icon').css('margin-right','0px');
         $('.sidebar .nav .nav-item .nav-link').css('padding','0.8rem 10px 0.8rem');
         $('.page-body-wrapper').css('width','calc(100% - 60px)');
         $('.nav').css('padding-left','5px');
                  $('.menue_icon').addClass('mdi-menu');
         $('.menue_icon').removeClass('mdi-menu-open');



        });
     function  show_description_div(id){
         $('#'+id).show();
     }
     $(document).ready(function(){
	$('.show_description_div').hover(function(){ 
	 
    	$(this).parent().siblings('.description_div').show();
	}, function(){
       $(this).parent().siblings('.description_div').hide();
    });
});
     
    </script>
@endsection
 
