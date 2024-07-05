@extends('layouts.website.main2')
@section('additional_styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    .row {
    --bs-gutter-x: 0 !important;
    --bs-gutter-y: 0;}
    .emptyspace {
    height: 10px !important;
}
.point_div_checkout{
     cursor: pointer;
    background: white;
    border: 1px solid #d8d7d8;
    border-radius: 50px;
    display: flex;
    justify-content: center;
    color: #a8a8a8;
    align-items: center;
}
.product_card h5{font-size: 16px !important;}
input:focus ~ .floating-label,
input:not(:focus):valid ~ .floating-label{
  top: 7px;
  bottom: 10px;
      left: 10px;
  font-size: 11px;
  opacity: 1;
}
textarea:focus ~ .floating-label,
textarea:not(:focus):valid ~ .floating-label{
    top: 7px;
    bottom: 10px;
    left: 10px;
    font-size: 10px;
    opacity: 1;
}

.inputText {
  font-size: 14px;
  height: 40px;
  width: 100%;
    border: 1px solid #d8d7d8;
    outline: none;
        color: #7a7879;
}

.floating-label {
  position: absolute;
  pointer-events: none;
   left: 10px;
    top: 17px;
  transition: 0.2s ease all;
      color: #d8d7d8;
}
.form-group {
    position: relative;
}
select.inputText.mt-1.contact-text {
    height: 40px;
    color: #d8dde5;
    padding: 5px;
}
.confirmed_div{cursor: none;background: #7a7879;color: white; width: 70px;height: 70px;display: flex;font-size: 30px !important;align-items: center;justify-content: center;border-radius: 50%;}
.fix_div{ height: 100%;padding: 40px 60px;position: fixed;right: 0;    box-shadow: -2px 0px 7px rgb(179 177 177 / 29%); background: white;}
 @media only screen and (max-width: 768px){
     .confirmed_div{cursor: none;background: #7a7879;color: white; width: 50px;height: 50px;display: flex;font-size: 25px !important;align-items: center;justify-content: center;border-radius: 50%;}
       .fix_div{
           height: 250px;
           padding: 10px 20px;
               bottom: 0;
           
       }
       .form_div{
           padding: 0 7%;
       }
    } 
    .point_div_checkout span {
    padding: 8px 14px;
}
.wizard-form-error{
    font-size: 12px!important;
    color: #f70a0a;
    display:none;
    letter-spacing: 1px;
}
.hide {
    display: none!important;
}
</style>
@endsection
@section('content')
<div class="bag">

        <div class="row" style="display:flex;">
                  
            <div class="col-md-1" >
                
              
            </div>
        <div class="col-md-5 form_div" style=" ">
             @if(session('error'))
                            <div class="alert alert-danger text-center" >
                              {{ session('error') }}
                            </div> 
                        @endif
                        
                        
                         @if(session('success'))
                            <div class="alert alert-success text-center" >
                              {{ session('success') }}
                            </div> 
                        @endif
             <h5 style="padding-top: 20px;" class="page_location"><a  href="/"> Home </a>><a href="/checkout"> checkout</a></h5>
            
            <div id="check_Div">
         <div style=" display: flex;align-items: center;">
              <div class="point_div_checkout tab_checkput_active" onclick="next_fun(1)" id="shipping_num"><span style="padding: 8px 15px;">1</span></div>
                      <svg height="2" width="250"><line x1="0" y1="0" x2="250" y2="0" style="stroke:#d8d7d8;stroke-width:7" /> </svg>
                      <div class="point_div_checkout" onclick="next_fun(2)" id="payment_num"><span>2</span> </div>
                      <svg height="2" width="250"><line x1="0" y1="0" x2="250" y2="0" style="stroke:#d8d7d8;stroke-width:7" /> </svg>
                      <div class="point_div_checkout" onclick="next_fun(3)" id="review_num"><span>3</span> </div>
                     </div>
        <div class="row">
            <div class="col-sm-4 tab_checkput tab_checkput_active" id="shipping_text">Shipping</div>
             <div class="col-sm-4 tab_checkput" style=" text-align: center;" id="payment_text">Payment</div>
              <div class="col-sm-4 tab_checkput" style=" text-align: right;" id="review_text">Done</div>
        </div>
     <form  role="form" action="{{ route('stripe.payment') }}" method="post" class="validation"
                            data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="payment-form" id="form1">
       @csrf
        <div class="row wizard-fieldset" id="shipping_id" >
            <div class="form-group col-md-6  p-1">
                 <input  name="f_name" type="text" id="f_name" class="inputText  mt-1 contact-text" required/>
                 <span class="floating-label">First name*</span>
                 <div class="wizard-form-error_fname wizard-form-error ">first name filed required</div>

            </div>
             <div class="form-group col-md-6  p-1">
                 <input name="l_name" id="l_name" type="text" class="inputText  mt-1 contact-text"  required/>
                 <span class="floating-label">Last name*</span>
                 <div class="wizard-form-error_lname wizard-form-error">last name filed required</div>

            </div>
             <div class="form-group col-md-12  pt-1 px-1">
                 <textarea name="address" id="address" type="text" class="inputText  mt-1 contact-text" style="padding: 10px;height: auto;" row="3" required/></textarea>
                 <span class="floating-label" >Address*</span>
                 <div class="wizard-form-error_address wizard-form-error">address filed required</div>
            </div>
             <div class="form-group col-md-6  p-1">
                 
                <select class="inputText  mt-1 contact-text" id="country"  name="country">
                  <option value="">Country*</option>
                  <option value="United Arab Emirates">United Arab Emirates</option>
                  
                </select>
                 <div class="wizard-form-error_country wizard-form-error">country filed required</div>
                

            </div>
           
             <div class="form-group col-md-6  p-1">
                <select class="inputText  mt-1 contact-text chosen-select" id="city" name="city">
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
               <input  name="street" type="text" id="street" class="inputText  mt-1 contact-text" required/>
                 <span class="floating-label"> Street*</span>
                 <div class="wizard-form-error_street wizard-form-error">street filed required</div>


            </div>
      <div class="form-group col-md-12  p-1">
                 <input  name="phone" type="text" id="phone" class="inputText  mt-1 contact-text" required/>
                 <span class="floating-label"> Phone number*</span>
                 <div class="wizard-form-error_phone wizard-form-error">phone filed required</div>

            </div>
             <div class="form-group col-md-12  p-1">
                 <input name="email" type="text" id="email" class="inputText  mt-1 contact-text" required/>
                 <span class="floating-label"> E-mail*</span>
                <div class="wizard-form-error_email wizard-form-error">E-mail filed required</div>
            </div>
            
           
        
        </div>
        
             <div class="row" id="payment_id">
                 <div class=" col-md-6 mb-1">
                 <img  src="{{asset('/assets/img/card1.png')}}" alt="" style="    width: 90%; margin-top: 30px;border-radius: 18px;float: left;">
            </div>
            <div class=" col-md-6 mb-1">
                 <img src="{{asset('/assets/img/card2.png')}}" alt=""  style="    width: 90%; margin-top: 30px;border-radius: 18px;float: right;">
            </div>
             <div class="form-group col-md-12  p-1">
                 <input name="holder" type="text" id="holder_name" class="inputText  mt-1 contact-text" required/>
                 <span class="floating-label"> Card holder nane & surname*</span>
                 <div class="wizard-form-error_holder wizard-form-error">Card holder nane filed required</div>
            </div>
            <div class="form-group col-md-12  p-1 required">
                 <input name="holder" type="text" id="card_number" class="inputText  mt-1 contact-text "  autocomplete='off' size='20' required/>
                 <span class="floating-label"> Card number*</span>
                 <div class="wizard-form-error_card_number wizard-form-error">Card number filed required</div>
            </div>
            <div class="form-group col-md-4 p-1 required">
                 <input name="holder" type="text" id="cvc" class="inputText  mt-1 contact-text " autocomplete='off' size='4' required/>
                 <span class="floating-label" > CVC*</span>
                 <div class="wizard-form-error_cvc wizard-form-error">CVC filed required</div>
            </div>
            <div class="form-group col-md-4  p-1 required">
                 <input name="holder" type="text" id="month" class="inputText  mt-1 contact-text " size='2' required/>
                 <span class="floating-label" > Expiration Month*</span>
                 <div class="wizard-form-error_month wizard-form-error">Expiration Month filed required</div>
            </div>
            <div class="form-group col-md-4  p-1 required">
                 <input name="holder" type="text" id="year" class="inputText  mt-1 contact-text " size='4' required/>
                 <span class="floating-label"> Expiration Year*</span>
                 <div class="wizard-form-error_year wizard-form-error">Expiration Year filed required</div>
            </div>
            <div class='form-row row'>
             
                                <div class='col-md-12 hide error form-group'>
                                    <div class='alert-danger alert'>Fix the errors before you begin.</div>
                                </div>
                            </div>
             </div>
             
                  <div class="row" id="review_id">
                        <div class="row" style="    display: flex;padding-top: 45px;align-items: center;justify-content: center;">
                          
                           <div class="confirmed_div"  style="">
                               <i class="fa fa-check"></i>
                               </div>
                            <h5 style="text-align: center; color: #7a7879;margin-top: 20px;">Your order has confirmed</h5>
                            <button type="button" class=" com_btn" onclick="location.href='/order'"  style="   width: 50%;margin-top: 20px;" >Go to your order</button>
                       </div>
                       <!--
                   <div style="border: 1px solid #d8d7d8;margin-top: 20px;">
                       <div style="padding: 10px;padding-bottom: 3px;border-bottom: 1px solid #e1e1e1;">
                           <h5 style="font-size: 14px; color: #9c9ca2;">
                              Shipping information 
                           </h5>
                       </div>
                       <div  class="row" style="padding: 0 10px;">
                          <div class="col-sm-6">
                              <p>Name:---------------</p> 
                          <p>Adress:-------------------------------------------------------------------------------------------------------</p>
                          <p>Phone:-----------------</p>
                          </div>
                          <div class="col-sm-6"><button type="button" class=" com_btn" style="    float: right;margin-top: 20px;" onclick="next_fun(1)" >Change</button></div>
                       </div>
                   </div>
                    <div style="border: 1px solid #d8d7d8;margin-top: 20px;">
                       <div style="padding: 10px;padding-bottom: 3px;border-bottom: 1px solid #e1e1e1;">
                           <h5 style="font-size: 14px; color: #9c9ca2;">
                              Payment information 
                           </h5>
                       </div>
                       <div  class="row" style="padding: 0 10px;">
                          <div class="col-sm-6">
                              <p>Payment methode:---------------</p> 
                          <p>Card holder name:---------------------------------------------------------------------------------------------</p>
                          <p>Phone:-----------------</p>
                          <p>E-mail:-----------------</p>
                          </div>
                          <div class="col-sm-6"><button type="button" class=" com_btn" onclick="next_fun(2)"  style="    float: right;margin-top: 20px;" >Change</button></div>
                       </div>
                   </div>
                        -->
       </div>
    </form>
            <div style="height: 200px;"></div>
            </div>
            <div id="done_Div">
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
              <div class="col-sm-4 tab_checkput" style=" text-align: right;" >Review</div>
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
         <div class="col-md-1 " >
              
            </div>
        <div class="col-md-5 fix_div" style="   ">
            <h1 style="font-size: 18px;">
                Order summary 
            </h1>
            <div class="emptyspace"></div>
            <hr>
            <div class="emptyspace"></div>
            <div class="row">
                <div class="col-4"><p>Subtotal:</p></div>
                <div class="col-8"><p id="price2_id"> </p></div>
            </div>
            <div class="row">
                <div class="col-4"><p>Shipping:</p></div>
                <div class="col-8"><p>Free shipping</p></div>
            </div>
            <div class="row">
                <div class="col-4"><p>Tax:</p></div>
                <div class="col-8"><p>10</p></div>
            </div>
            <div class="row" >
                <div class="col-4"><p style="color: #ff0000c2;">Discount:</p></div>
                <div class="col-8"><p style="color: #ff0000c2;">-10%</p></div>
            </div>
            <div class="emptyspace"></div>
            <hr>
            <div class="emptyspace"></div>
             <div class="row">
                <div class="col-4"><h3 style="font-size: 16px;">Order Total:</h3></div>
                <div class="col-8"><h3 style="font-size: 16px;" id="price1_id"> </h3></div>
            </div>
            
            <div class="emptyspace"></div>
            <hr>
            <div class="emptyspace"></div>
            <div id="discount_div">
            <h3 style="font-size: 16px;">Discount code</h3>
            <input type="text" class="bag_input" placeholder="Enter discount code" style="">
            <button class="com_btn" style="float: right;">Apply</button>
            </div>
        </div>
        <div class="col-sm-12"  style="background: white;box-shadow: 0px -2px 7px rgb(179 177 177 / 29%);padding: 15px 0;position: fixed;bottom: 0;">
            <div class="row" id="total_div">
                 <div class="col-7" style="    display: flex;justify-content: center;align-items: center;">
                     <button class="select_size" style="    padding: 5px 24px;letter-spacing: 1px;    padding: 7px 24px;letter-spacing: 1px;font-size: 12px;" id="sh_btn" onclick="next_fun(2)"   >Continue to billing</button>
                     <button class="select_size" style="    padding: 5px 24px;letter-spacing: 1px;  padding: 7px 24px;letter-spacing: 1px;font-size: 12px;" id="pay_btn" onclick="next_fun(3)" >Confirm</button>
                     <button class="select_size" style="    padding: 5px 24px;letter-spacing: 1px;  padding: 7px 24px;letter-spacing: 1px;font-size: 12px;" id="pr_btn" onclick="next_fun(4)"   >done</button>
                 </div>
                  <div class="col-5">
                      <div class="row" style="    display: flex;justify-content: flex-end;padding-right: 30px;">
                <div class="col-4" style="display: flex; align-items: center;justify-content: center;"><h3 style="font-size: 14px;    margin: 0;"> Total:</h3></div>
                <div class="col-4" style="display: flex; align-items: center;"><h3 style="font-size: 14px;    margin: 0;" id="total_h3"></h3></div>
            </div>
                
                  </div>
            </div>
        </div>
    </div>
   
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@section('additional_scripts')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 

<script>
 var $form = $(".validation");
$.get('{{ route("view.cart.website")}}',{user_id: {{$user_id_Cookie}}},function(data){
         
              var total=0;
              for (var i = 0; i < data.length; i++) {
                  console.log(data);
                // += " <a href='/categories/"++"'>"+data[i].name+" </a>";
                 total += parseFloat(data[i].price*data[i].quantity);
                   
                             
                 }
                // $('#cart_orders').html(products);
                 $('#total_h3').html(total+" AED");
                 $('#price1_id').html(total+" AED");
                 $('#price2_id').html(total+" AED");
                 
     
        },'json');
function next_fun(num){
    
    if (num==1){
        
        $("#sh_btn").show();
        $("#pay_btn").hide();
        $("#pr_btn").hide();
        
        $("#shipping_id").show();
        $("#review_id").hide();
        $("#payment_id").hide();
        
        $("#shipping_text").addClass('tab_checkput_active');
        $("#shipping_num").addClass('tab_checkput_active');   
        $("#payment_text").removeClass('tab_checkput_active');
        $("#payment_num").removeClass('tab_checkput_active');
        $("#review_text").removeClass('tab_checkput_active');
        $("#review_num").removeClass('tab_checkput_active');
    }
    if(num==2){
        
       // validation step
       var fname = document.getElementById('f_name').value;
       var lname = document.getElementById("l_name").value;
       var address = document.getElementById("address").value;
       var country = document.getElementById("country").value;
       var city = document.getElementById("city").value;
       var state = document.getElementById("state").value;
       var street = document.getElementById("street").value;
       var phone = document.getElementById("phone").value;
        var email = document.getElementById("email").value;
    if(fname=="" || lname=="" || address=="" || country=="" || city=="" || state=="" || street=="" || phone==""|| email==""){
       if(fname==""){  
           $(".wizard-form-error_fname").show();
       }else if(fname!=""){
            $(".wizard-form-error_fname").hide();
       }
        if(lname==""){  
           $(".wizard-form-error_lname").show();
       }else if(lname!=""){
            $(".wizard-form-error_lname").hide();
       }
       if(address==""){  
           $(".wizard-form-error_address").show();
       }else if(address!=""){
            $(".wizard-form-error_address").hide();
       }
        if(country==""){  
           $(".wizard-form-error_country").show();
       }else if(country!=""){
            $(".wizard-form-error_country").hide();
       }
        if(city==""){  
           $(".wizard-form-error_city").show();
       }else if(city!=""){
            $(".wizard-form-error_city").hide();
       }
          if(state==""){  
           $(".wizard-form-error_state").show();
       }else if(state!=""){
            $(".wizard-form-error_state").hide();
       }
         if(street==""){  
           $(".wizard-form-error_street").show();
       }else if(street!=""){
            $(".wizard-form-error_street").hide();
       }
        if(phone==""){  
           $(".wizard-form-error_phone").show();
       }else if(phone!=""){
            $(".wizard-form-error_phone").hide();
       } 
         if(email==""){
            $(".wizard-form-error_email").show();
       } 
       else if(email!=""){
            $(".wizard-form-error_email").hide();
       } 
    }else{
      
       $("#sh_btn").hide();
        $("#pay_btn").show();
        $("#pr_btn").hide();
        
         $("#payment_id").show();
        $("#review_id").hide();
        $("#shipping_id").hide();
        
         $("#payment_text").addClass('tab_checkput_active');
        $("#payment_num").addClass('tab_checkput_active');
        $("#shipping_text").removeClass('tab_checkput_active');
        $("#shipping_num").removeClass('tab_checkput_active'); 
        $("#review_text").removeClass('tab_checkput_active');
        $("#review_num").removeClass('tab_checkput_active');
       
       
    }
    }
    if(num==3){
         var holder_name = document.getElementById('holder_name').value;
       var card_number = document.getElementById("card_number").value;
       var cvc = document.getElementById("cvc").value;
       var month = document.getElementById("month").value;
       var year = document.getElementById("year").value;
      
    if(holder_name=="" || card_number=="" || cvc=="" || month=="" || year=="" ){
       if(holder_name==""){  
           $(".wizard-form-error_holder").show();
       }else if(holder_name!=""){
            $(".wizard-form-error_holder").hide();
       }
        if(card_number==""){  
           $(".wizard-form-error_card_number").show();
       }else if(card_number!=""){
            $(".wizard-form-error_card_number").hide();
       }
       if(cvc==""){  
           $(".wizard-form-error_cvc").show();
       }else if(cvc!=""){
            $(".wizard-form-error_cvc").hide();
       }
        if(month==""){  
           $(".wizard-form-error_month").show();
       }else if(month!=""){
            $(".wizard-form-error_month").hide();
       }
        if(year==""){  
           $(".wizard-form-error_year").show();
       }else if(year!=""){
            $(".wizard-form-error_year").hide();
       }
        
    }
    
       else{
           // var $form = $(".validation");
      
        $('form.validation').bind('submit', function(e) {
            var $form = $(".validation"),
                inputVal = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputVal),
                $errorStatus = $form.find('div.error'),
                valid = true;
                     alert('g');
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
                    number: $('#card_number').val(),
                    cvc: $('#cvc').val(),
                    exp_month: $('#month').val(),
                    exp_year: $('#year').val()
                },  function () {
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
        });
            }

        });
           // $(".wizard-form-error_email").hide();
      /*  $("#sh_btn").hide();
        $("#pay_btn").hide();
        $("#pr_btn").show();
        
          $("#review_id").show();
        $("#payment_id").hide();
        $("#shipping_id").hide();
        
        $("#review_text").addClass('tab_checkput_active');
        $("#review_num").addClass('tab_checkput_active');
        $("#shipping_text").removeClass('tab_checkput_active');
        $("#shipping_num").removeClass('tab_checkput_active');   
        $("#payment_text").removeClass('tab_checkput_active');
        $("#payment_num").removeClass('tab_checkput_active');
        */
      }
       
    }
    if(num==4){
     
       //  document.getElementById("form1").submit();
  //  document.getElementById("form2").submit();
        $("#done_Div").show();
        $("#check_Div").hide();
        $("#discount_div").hide();
        $("#total_div").hide();
    }
    
}
$("#done_Div").hide();
$("#pay_btn").hide();
$("#pr_btn").hide();
$("#payment_id").hide();
$("#review_id").hide();
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
  
    $(document).ready(function() {
            $(".chosen-select").chosen({rtl: false,width:"100%"});
    });
   
</script>
@endsection