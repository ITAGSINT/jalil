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
<style>
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
    margin: 10px 0px;
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
</style>
<style>
select {
    border: 0;
    background: #f3f5f8;
    border-radius: 10px;
      padding: 7px 7px;
        width: 100%;
}

.hide {
    display: none!important;
}
</style>
@extends('layouts.Dashboard.main')
@section('content')
<div class="content-wrappe">
    <div class="row bg_gray">
       

        
        <div class="col-sm-6 "  style="    padding: 34px 15px;">
            <div style="    background: white;margin: 46px;padding: 50px;    margin-top: 0;" id="receipt_id">
               <div style="    display: flex;flex-direction: row;justify-content: space-between;">
                    <img  style="width: 70px;" src="https://belucci-test.shop/assets/images_d/logo.png" alt="">
                    <div style="    display: flex;flex-direction: column;align-items: flex-end;align-items: center;">
                        
                        <span>helo@belucci.com</span>
                        <span>+90 (000)000 00 0</span>
                    </div>
               </div>
                <hr>
             
                @php $total=0; $htmlcontent=""; @endphp
                 @foreach($items as $item)
                <?php $total+=($item->final_price) * $item->customers_basket_quantity; 
                $Subtotal=$total;
                $Discount=$discount;
                $Total=$total-$Discount;
                 $htmlcontent.= $item->name.' (';
                        foreach($item->product_att as $id=>$details) {
                                        if($id=='size'){ 
                                            foreach($details as $value){
                                                if($value['option_value']['value_id']==$item->size_id){
                                                 if($item->size_id) {  $htmlcontent.= ' - size :' .$value['option_value']['value_name'] ; } 
                                                }
                                            }
                                        }
                                        if($id=='color') {
                                            foreach($details as $value){
                                                if($value['option_value']['value_id']==$item->color_id){
                                                  
                                                    if($item->color_id){  
                                                        $htmlcontent.= 'color : '. $value['option_value']['value_name'];
                                                        } 
                                                     
                                                    }
                                           }
                                        }
                                    }
                            $htmlcontent.=' )  price:'.$item->final_price.'X'. $item->customers_basket_quantity.'-----';
             
               ?>
                 
               <div class="order_div">
                  
                   
                    <div style="display: flex;justify-content: space-between;">
                        <span class="show_description_div" style="cursor: pointer;   width: 65%;">
                            {{$item->name}}<br>
                            <div style="    display: flex;font-size: 14px; ">(
                        @foreach($item->product_att as $id=>$details) 
                                        @if($id=='size') 
                                            @foreach($details as $value)
                                                @if($value['option_value']['value_id']==$item->size_id)
                                                    <span style="    padding-left: 5px;margin-left: 5px;border-left: 1px solid #e5e5e5;">@if($item->size_id)size : {{$value['option_value']['value_name']}}  @endif</span>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if($id=='color') 
                                            @foreach($details as $value)
                                                @if($value['option_value']['value_id']==$item->color_id)
                                                    <span style="    display: flex;">@if($item->color_id)color : {{$value['option_value']['value_name']}}  @endif	</span>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach    
                            )</div>
                        </span>
                        <span style="    color: #007bff;margin-left: 10px;font-size: 14px;">{{$item->final_price}} X {{$item->customers_basket_quantity}}</span>
                    </div>
                        </div>
               @endforeach
               
               <hr>
               <div class="order_total">
                   <span>Subtotal</span><span>{{$total}} AED</span>
               </div>
               <hr>
               <div class="order_total">
                   <span>Discount amount</span><span>{{$discount}} AED</span>
               </div>
               <hr>
               <div class="order_total" style="    color: red;">
                   <span>Total</span><span>{{$total-$discount}} AED</span>
               </div>
               <div style="text-align: center;margin-top: 100px;"><span>3/15/2023 10:22 AM</span></div>
            </div>
        </div>
        <div class="col-sm-6 "  style="    padding: 34px 15px;    padding-right: 60px;">   
        <div id="print_div" style="margin-bottom: 50px;">
        <h3>how would you like to receive your receipt ?</h3>
        <button onclick="receipt_fun()" class="add_cart_btn" style="background: white;
    box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
    margin-bottom: 15px;"><i class="mdi mdi-printer"></i> Print </button>
        
                <input type="email" name="email" id="email_id" style="box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
    border: 0;
    background: white;
    padding: 8px 16px;
        width: 85%;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;" placeholder="ex: admin@gmail.com">
                
                <button onclick="receipt_email()" style="    box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
    border: 0;
    background: white;
    padding: 8px 16px;
    width: 14%;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;">Send</button>
       </div>
         <div id="payment_div" class="row" >
           <h3 class="col-12">how would you like to Pay?</h3>  
           <div class="col-6">
               <button onclick="open_card()" class="add_cart_btn" style="background: white;
                    box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
                    margin-bottom: 15px;">Card</button>
           </div>
           <div class="col-6">
               <button onclick="open_cash()" class="add_cart_btn" style="background: white;
    box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
    margin-bottom: 15px;">Cash </button>
           </div>
           

           <div style="padding: 0 15px;" id="card_div">
               <div class="bag" id="unempty_bag" style="background: white;">
        <div class="row" >
      
            <div class="col-md-12 p-5 form_div">
                  
            
            <div id="check_Div"  style="display: @if (Session::has('success')) none @else block @endif">
        
      
                    

                        @if (Session::has('success'))
                            <div class="alert alert-success text-center ">
                               {{ Session::get('success') }}
                            </div>
                           
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-error text-center">
                              {{ Session::get('error') }}
                            </div>
                        @endif
                        <form role="form" action="{{ route('stripe.payment') }}" method="post" class="validation"
                            data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="payment-form">
                            @csrf
                            <div class="row wizard-fieldset" id="shipping_id" >
                                <div class="form-group col-md-6  p-1">
                                    <span class="floating-label">First name*</span>
                                     <input  name="f_name" type="text" id="f_name" class="inputText  mt-1 contact-text" required/>
                                     <div class="wizard-form-error_fname wizard-form-error ">first name filed required</div>
                                     <input  name="amount" type="text" id="amount" style="display:none"/>
                    
                                </div>
                                 <div class="form-group col-md-6  p-1">
                                      <span class="floating-label">Last name*</span>
                                     <input name="l_name" id="l_name" type="text" class="inputText  mt-1 contact-text"  required/>
                                    
                                     <div class="wizard-form-error_lname wizard-form-error">last name filed required</div>
                    
                                </div>
                                 <div class="form-group col-md-12  pt-1 px-1">
                                     <span class="floating-label" >Address*</span>
                                     <textarea name="address" id="address" type="text" class="inputText  mt-1 contact-text" style="padding: 10px;height: auto;" row="3" required/></textarea>
                                     
                                     <div class="wizard-form-error_address wizard-form-error">address filed required</div>
                                </div>
                                 <div class="form-group col-md-6  p-1">
                                     <span class="floating-label" >Country*</span> 
                                    <select class="inputText  mt-1 contact-text" id="country"  name="country">
                                      <option value="">Country*</option>
                                      <option value="United Arab Emirates">United Arab Emirates</option>
                                      
                                    </select>
                                     <div class="wizard-form-error_country wizard-form-error">country filed required</div>
                                    
                    
                                </div>
                               
                                 <div class="form-group col-md-6  p-1">
                                     <span class="floating-label" >City*</span> 
                                    <select class="inputText  mt-1 contact-text chosen-select" id="city" style="width: 100%;" name="city">
                                      <option value="">City*</option>
                                      <option value="Abu Dhabi Island and Internal Islands City" class="one">Abu Dhabi Island and Internal Islands City</option>
                                      <option value="Abu Dhabi Municipality"  class="one">Abu Dhabi Municipality</option>
                                      <option value="Al Ain City"  class="one">Al Ain City</option>
                                      <option value="Al Ain Municipality" class="one">Al Ain Municipality</option>
                                      <option value="Al Dhafra"  class="one">Al Dhafra</option>
                                      <option value="Al Shamkhah City"  class="one">Al Shamkhah City</option>
                                       <option value="Ar Ruways" class="one">Ar Ruways</option>
                                      <option value="Bani Yas City"  class="one">Bani Yas City</option>
                                      <option value="Khalifah A City"  class="one">Khalifah A City</option>
                                      <option value="Musaffah" class="one">Musaffah</option>
                                      <option value="Muzayri"  class="one">Muzayri</option>
                                      <option value="Zayed City"  class="one">Zayed City</option>
                                      
                                      <option value="Ajman"  class="two">Ajman</option>
                                      <option value="Ajman City"  class="two">Ajman City</option>
                                      <option value="Manama"  class="two">Manama</option>
                                      <option value="Masfout"  class="two">Masfout</option>
                                      
                                      <option value="Dubai"  class="three">Dubai</option>
                                      
                                       <option value="Al Fujairah City"  class="four">Al Fujairah City</option>
                                       <option value="Al Fujairah Municipality"  class="four">Al Fujairah Municipality</option>
                                       <option value="Dibba Al Fujairah Municipality"  class="four">Dibba Al Fujairah Municipality</option>
                                       <option value="Dibba Al-Fujairah"  class="four">Dibba Al-Fujairah</option>
                                       <option value="Dibba Al-Hisn"  class="four">Dibba Al-Hisn</option>
                                       <option value="Reef Al Fujairah City"  class="four">Reef Al Fujairah City</option>
                                       
                                       <option value="Ras Al Khaimah"  class="five">Ras Al Khaimah</option>
                                       <option value="Ras Al Khaimah City"  class="five">Ras Al Khaimah City</option>
                                        
                                        
                                        <option value="Adh Dhayd"  class="six">Adh Dhayd</option>
                                        <option value="Al Batayih"  class="six">Al Batayih</option>
                                        <option value="Al Hamriyah"  class="six">Al Hamriyah</option>
                                        <option value="Al Madam"  class="six">Al Madam</option>
                                        <option value="Dhaid"  class="six">Dhaid</option>
                                        <option value="Dibba Al Hesn"  class="six">Dibba Al Hesn</option>
                                        <option value="Kalba"  class="six">Kalba</option>
                                        <option value="Khawr Fakkān"  class="six">Khawr Fakkān</option>
                                        <option value="Khor Fakkan"  class="six">Khor Fakkan</option>
                                        <option value="Milehah"  class="six">Milehah</option>
                                        <option value="Murbaḩ"  class="six">Murbaḩ</option>
                                        <option value="Sharjah"  class="six">Sharjah</option>
                                        
                                         <option value="Umm AL Quwain" class="seven">Umm AL Quwain</option>
                                         <option value="Umm Al Quwain City" class="seven">Umm Al Quwain City</option>
                                        
                                      
                                    </select>
                                    <div class="wizard-form-error_city wizard-form-error">city filed required</div>
                                </div>
                                <div class="form-group col-md-6  p-1">
                                     <span class="floating-label" >State*</span> 
                                    <select class="inputText  mt-1 contact-text" id="state" name="state">
                                      <option value="">State*</option>
                                      <option value="Abu Dhabi">Abu Dhabi</option>
                                      <option value="Ajman">Ajman Emirate</option>
                                      <option value="Dubai">Dubai</option>
                                      <option value="Fujairah">Fujairah</option>
                                      <option value="Ras al-Khaimah">Ras al-Khaimah</option>
                                      <option value="Sharjah">Sharjah</option>
                                      <option value="Umm al-Quwain">Umm al-Quwain</option>
                                    </select>
                                    <div class="wizard-form-error_state wizard-form-error">state filed required</div>
                    
                                </div>
                                 <div class="form-group col-md-6  p-1">
                                     <span class="floating-label"> Street*</span>
                                   <input  name="street" type="text" id="street" class="inputText  mt-1 contact-text" required/>
                                     
                                     <div class="wizard-form-error_street wizard-form-error">street filed required</div>
                    
                    
                                </div>
                          <div class="form-group col-md-12  p-1">
                               <span class="floating-label"> Phone number*</span>
                                     <input  name="phone" type="text" id="phone" class="inputText  mt-1 contact-text" required/>
                                    
                                     <div class="wizard-form-error_phone wizard-form-error">phone filed required</div>
                    
                                </div>
                                 <div class="form-group col-md-12  p-1">
                                      <span class="floating-label"> E-mail*</span>
                                     <input name="email" type="text" id="email" class="inputText  mt-1 contact-text" required/>
                                    
                                    <div class="wizard-form-error_email wizard-form-error">E-mail filed required</div>
                                </div>
                                
                               
                            
                            </div>
                            <div class="row" id="payment_id" style="    ">
                                <div class="form-group col-md-12  p-1 required">
                                     <span class="floating-label">Name on Card*</span>
                                    <input class=' inputText  mt-1 contact-text'size='4' type='text'>
                                       
                                </div>
                            <div class="form-group col-md-12  p-1 card required" style="    border: 0;">
                                 <span class="floating-label">Card Number*</span>
                                    <input class=' inputText  mt-1 contact-text card-num' size='20' autocomplete='off' type='text'>
                                       
                                </div>
                             <div class="form-group col-md-12  p-1 cvc required">
                                 <span class="floating-label">CVC*</span>
                                    <input class=' inputText  mt-1 contact-text card-cvc' size='4' autocomplete='off' type='text'>
                                        
                                </div>
                            <div class="form-group col-md-6  p-1 expiration required">
                                <span class="floating-label">Expiration Month* (ex:MM)</span>
                                    <input class=' inputText  mt-1 contact-text card-expiry-month' size='2'  autocomplete='off' type='text'>
                                        
                                </div>
                             <div class="form-group col-md-6  p-1 expiration required">
                                    <span class="floating-label">Expiration Year* (ex:YYYY)</span>
                                    <input class=' inputText  mt-1 contact-text card-expiry-year' size='4'  autocomplete='off' type='text'>
                                     
                                </div>
                                
                            

                            <div class='form-row row'>
                                <div class='col-md-12 hide error form-group'>
                                    <div class='alert-danger alert'>Fix the errors before you begin.</div>
                                </div>
                            </div>

                           
                            </div>
                            <button class="add_cart_btn" style="  " id="pay_btn" type="submit" form="payment-form"  >Confirm</button>
                        </form>
                    
                </div>
                 <div id="done_Div"  style="display: @if (Session::has('success')) block @else none @endif">
                 <div style=" display: flex;align-items: center;">
              <div class="point_div_checkout "  style="cursor: none;background: #d8d7d8;color: white;"><span style="    padding: 5px 11px;font-size: 16px;"><i class="fa fa-check"></i></span></div>
                      <svg height="2" width="250"><line x1="0" y1="0" x2="250" y2="0" style="stroke:#d8d7d8;stroke-width:7" /> </svg>
                      <div class="point_div_checkout"  style="cursor: none;background: #d8d7d8;color: white;"><span style="    padding: 5px 11px;font-size: 16px;"><i class="fa fa-check"></i> </span></div>
                      <svg height="2" width="250"><line x1="0" y1="0" x2="250" y2="0" style="stroke:#d8d7d8;stroke-width:7" /> </svg>
                      <div class="point_div_checkout"  style="cursor: none;background: #d8d7d8;color: white;"><span style="    padding: 5px 11px;font-size: 16px;"><i class="fa fa-check"></i></span></div>
                     </div>
        <div class="row">
            <div class="col-sm-4 tab_checkput " >Shipping</div>
             <div class="col-sm-4 tab_checkput" style=" text-align: center;" >Payment</div>
              <div class="col-sm-4 tab_checkput" style=" text-align: right;" >Done</div>
        </div>
       <form  class="" method="post" role="form">
       
                       <div class="row" style="    display: flex;padding-top: 45px;align-items: center;justify-content: center;">
                          
                           <div class="confirmed_div"  style="">
                               <i class="fa fa-check"></i>
                               </div>
                            <h5 style="text-align: center; color: #7a7879;margin-top: 20px;">Your order has confirmed</h5>
                            <button type="button" class=" com_btn" onclick="location.href='/order'"  style="   width: 50%;margin-top: 20px;" >Go to your order</button>
                       </div>
           
    </form>
            <div style="height: 200px;"></div>
            </div>
            </div>
      
             

        </div>
    </div>
    <div class="bag" id="empty_bag" style=" display:none;   height: 80vh;">

    
    <div class="row" style="    padding: 60px 0;">
       <div class="col-sm-4"></div> 
        <div class="col-sm-4" style="    display: flex;flex-direction: column;align-items: center;">
            <img  src="{{asset('/assets/img/Group 210.png')}}" style="width: 130px;">
            <h5 style="color:#8E8E8E;font-size: 21px;margin: 0;padding: 15px 0;">Your bag is empty</h5>
            
            <button class="select_size" onclick="location.href='/categories/all'" style="">Continue shopping</button>
        </div> 
         <div class="col-sm-4"></div> 
    </div>
           
    </div>
           </div>
           <div  style=" width: 100%; display:none" id="cash_div">
               <div style="    margin: 0 15px;
    padding: 40px;
    background: white;"> <button class="add_cart_btn" >Confirm</button></div>
               
           </div>
         </div>
        </div>
</div>
</div>
  @endsection
  @section('additional_scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js" integrity="sha512-Fd3EQng6gZYBGzHbKd52pV76dXZZravPY7lxfg01nPx5mdekqS8kX4o1NfTtWiHqQyKhEGaReSf4BrtfKc+D5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>
    function  open_card(){
        $('#card_div').show();
        $('#cash_div').hide();
    }
    function open_cash(){
       $('#card_div').hide();
        $('#cash_div').show();
    }
   function receipt_email(){
      
       var email=$("#email_id").val();
       var Subtotal={{ $Subtotal ?? '' }};
       var Discount={{ $Subtotal ?? '' }};
       var Total={{ $Subtotal ?? '' }};
       $.get('{{ route("send_email")}}',{email:email,htmlcontent:'{{$htmlcontent}}',Subtotal:Subtotal,Discount:Discount,Total:Total},function(data){
         
              alert('done');
                 
     
        },'json');
       
   }
  function receipt_fun(){$("#receipt_id").printThis( {importCSSL: true, importStyle: true,});}
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
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
$.get('{{ route("view.cart.website")}}',{user_id: {{$user_id_Cookie}}},function(data){
         
              var total=0;
              for (var i = 0; i < data.length; i++) {
                  console.log(data);
                // += " <a href='/categories/"++"'>"+data[i].name+" </a>";
                 total += parseFloat(data[i].price*data[i].quantity);
                   
                             
                 }
                // $('#cart_orders').html(products);
                if(total==0 && @if(Session::has('success')) false @else true @endif){
                    
                    $("#empty_bag").show();
                    $("#unempty_bag").hide();
        
                }
                 $('#total_h3').html(total+" AED");
                 $('#price1_id').html(total+" AED");
                 $('#price2_id').html(total+" AED");
                $('#amount').val(total);
                 
     
        },'json');


    $(function() {
        var $form = $(".validation");
        $('form.validation').bind('submit', function(e) {
            var $form = $(".validation"),
                inputVal = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputVal),
                $errorStatus = $form.find('div.error'),
                valid = true;
            $errorStatus.addClass('hide');

            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorStatus.removeClass('hide');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-num').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeHandleResponse);
            }

        });

        function stripeHandleResponse(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                var token = response['id'];
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }

    });
 
</script>
@endsection
 
