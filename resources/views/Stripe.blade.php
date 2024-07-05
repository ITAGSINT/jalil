@extends('layouts.website.main')
@section('additional_styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <link rel="stylesheet" href="{{URL::asset('assets/css_site/pay.css')}}">
  <style>
.alert.alert-error {
    background: var(--danger);
    color: white;
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
<style>

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

    <section class="ftco-section bag" id="unempty_bag"  >
    <div class="container" id="check_Div"  style="display: @if (Session::has('success')) none @else block @endif">
        <div class="row" >
       
            <div class="col-md-7 form_div ftco-animate" >

            <div>
                <h4 class="row mb-3"> Payment Information </h4>

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
                        <form role="form" action="{{ route('stripe.payment') }}" method="post" class="validation mr-4"
                            data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="payment-form">
                            @csrf
                            <div class="row wizard-fieldset" >
                                <div class="form-group col-md-6  p-1">
                                    <lable for="f_name">First name*</lable>
                                     <input  name="f_name" type="text" id="f_name" class="form-control" required/>
                                     <div class="wizard-form-error_fname wizard-form-error ">first name filed required</div>
                                     <input  name="amount" type="text" id="amount" style="display:none"/>
                    
                                </div>
                                 <div class="form-group col-md-6  p-1">
                                      <lable for="l_name">Last name*</lable>
                                     <input name="l_name" id="l_name" type="text" class="form-control"  required/>
                                     <div class="wizard-form-error_lname wizard-form-error">last name filed required</div>
                    
                                </div>
                                      
                            <div class="form-group col-md-6  p-1">
                              <lable for="phone">Phone number*</lable>
                                     <input  name="phone" type="text" id="phone" class="form-control" required/>
                                     <div class="wizard-form-error_phone wizard-form-error">phone filed required</div>
                    
                                </div>
                            <div class="form-group col-md-6  p-1">
                                     <lable for="email">E-mail*</lable>
                                     <input name="email" type="text" id="email" class="form-control" required/>
                                    <div class="wizard-form-error_email wizard-form-error">E-mail filed required</div>
                            </div>
                            <div class="form-group col-md-12  pt-1 px-1">
                                     <lable for="address">Address*</lable>
                                     <textarea name="address" id="address" type="text" class="form-control" style="padding: 10px;height: auto;" row="3" required/></textarea>
                                     <div class="wizard-form-error_address wizard-form-error">address filed required</div>
                                </div>
                            <div class="form-group col-md-6  p-1">
                                     <lable for="email">Country*</lable>
                                     <input name="country" type="text" id="country" class="form-control" required/>
                                    <div class="wizard-form-error_email wizard-form-error">country filed required</div>
                            </div>
                            <div class="form-group col-md-6  p-1">
                                     <lable for="email">City*</lable>
                                     <input name="city" type="text" id="city" class="form-control" required/>
                                    <div class="wizard-form-error_email wizard-form-error">city filed required</div>
                            </div>
                            <div class="form-group col-md-6  p-1">
                                     <lable for="email">State*</lable>
                                     <input name="state" type="text" id="state" class="form-control" required/>
                                    <div class="wizard-form-error_email wizard-form-error">state filed required</div>
                            </div>
                            <div class="form-group col-md-6  p-1">
                                     <lable for="email">Street*</lable>
                                     <input name="street" type="text" id="street" class="form-control" required/>
                                    <div class="wizard-form-error_email wizard-form-error">street filed required</div>
                            </div>
                          
                                
                               
                            
                          
                                <div class="form-group col-md-12  p-1 required">
                                    <lable>Name on Card*</lable>
                                    <input class=' form-control'size='4' type='text'>
                                </div>
                            <div class="form-group col-md-12  p-1 card required" style="      margin-top: 0;  border: 0;">
                                <lable>Card Number*</lable>
                                    <input class=' form-control card-num' size='20' autocomplete='off' type='text'>
                                </div>
                             <div class="form-group col-md-12  p-1 cvc required">
                                  <lable>CVC*</lable>
                                    <input class=' form-control card-cvc' size='4' autocomplete='off' type='text'>
                                </div>
                            <div class="form-group col-md-6  p-1 expiration required">
                                 <lable>Expiration Month* (ex:MM)</lable>
                                    <input class=' form-control card-expiry-month' size='2'  autocomplete='off' type='text'>
                                </div>
                             <div class="form-group col-md-6  p-1 expiration required">
                                  <span class="floating-label">Expiration Year* (ex:YYYY)</span>
                                    <input class=' form-control card-expiry-year' size='4'  autocomplete='off' type='text'>
                                </div>
                                
                            

                            <div class='form-row row'>
                                <div class='col-md-12 hide error form-group'>
                                    <div class='alert-danger alert'>Fix the errors before you begin.</div>
                                </div>
                            </div>

                           
                            </div>
                        </form>
                        

                    
                </div>
                
            </div>
     
              <div class="col-md-5  ftco-animate" style="   ">
                  <h4 class="row mb-3"> Order summary </h4>
             @php
                        $count=1;  
                      @endphp
                @foreach ( $items as $item)
                
                <div class="row product_card mb-2"  >
                <div class="col-2 " style=""><img  src="{{$item->image}}" class="fit_image"></div>
                <div class="col-10 order_div">
                  <h5 style="font-size: 18px;  display: flex;justify-content: space-between;">{{$item->name}}  <span style="font-size: 15px;color:#4a52a3;">{{$item->price}}$ x {{$item->quantity}}</span></h5>
            
                  <h5 style="font-size: 15px;color: #a8a8a8;">
                  
                  @foreach($item->option as $details)
                   <input type="hidden" name="option[{{$details[2]}}]"   value="{{$details[3]}}" >
                 <span>{{$details[0]}} : {{$details[1]}} </span> | 
                 
                  @endforeach
                 </h5>
                    
                
               </div>
            </div>
              @php
                        $count++;  
                      @endphp
                @endforeach
                
               <h5 style="font-size: 18px;  display: flex;justify-content: space-between;border-top: 1px solid #ced4da;" class="mt-3 pt-2">Total: <span id="total_div"></span></h5>
            <button class="btn btn-primary mt-5"  id="pay_btn" type="submit" form="payment-form" style="    width: 100%; padding: 10px;" >Confirm</button>
            </div>
        </div>

        </div>
        <div class="container" id="done_Div"  style="display: @if (Session::has('success')) block @else none @endif">
                
       
       <form  class="" method="post" role="form">
       
                       <div class="row" style="    display: flex;padding-top: 45px;align-items: center;justify-content: center;">
                          
                            <h5 style="text-align: center; color: #7a7879;margin-top: 20px;">Your order has send</h5>
                            <button type="button" class=" btn btn-white" onclick="location.href='/order'"  style="   width: 50%;margin-top: 20px;" >Go to your order</button>
                       </div>
           
    </form>
            <div style="height: 200px;"></div>
            </div>
        </div>
    </section>
    <section class="bag ftco-section" id="empty_bag" style=" display:none;   height: 80vh;">

    <div class="row">
        <div class="col-sm-1"></div>
            <div class="col-sm-10">
            </div>
            <div class="col-sm-1"></div>
        </div>
    <div class="row" style=" padding: 60px 0;width: 100%;margin: 0;">
       <div class="col-sm-4"></div> 
        <div class="col-sm-4" style="    display: flex;flex-direction: column;align-items: center;">
            <img  src="{{asset('/assets/img/Group 210.png')}}" style="width: 130px;">
            <h5 style="color:#8E8E8E;font-size: 21px;margin: 0;padding: 15px 0;">Your cart is empty</h5>
            
            <button class="btn btn-white" onclick="location.href='/shop/all'" style="">Continue shopping</button>
        </div> 
         <div class="col-sm-4"></div> 
    </div>
           
    </section>
@endsection
@section('additional_scripts')
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
                 $('#total_div').html(total+" $");
                 
                
                 
     
        },'json');
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