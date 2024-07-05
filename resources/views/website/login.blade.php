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
::placeholder {
  color: #7e7c7da1 !important;
  opacity: 1; /* Firefox */
}

:-ms-input-placeholder { /* Internet Explorer 10-11 */
 color:  #7e7c7da1 !important;
}

::-ms-input-placeholder { /* Microsoft Edge */
 color:  #7e7c7da1 !important;
}
</style>
@endsection

@section('content')
<div class="checkout">
        
        <div class="row" style="padding-top: 80px;">
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                 <form  class="col-md-9 m-auto" method="post" role="form">
                <div class="row">
                    <div class="form-group col-md-12 mb-1 ">
                        <p style="    color: #7e7c7da1; font-size: 20px !important;">Returning customer</p>
                    </div>
                </div>
                        
                <div class="row ">
                    <div class="form-group col-md-12 mb-1">
                        <input type="email" class="form-control mt-1  contact-text" id="email" name="email" placeholder="E-mail">
                        
                    </div>
                    <div class="form-group col-md-12 mb-1">
                        <input type="password" class="form-control mt-1 contact-text" id="name" name="password" placeholder="Password">
                        
                    </div>
                    <div class="form-group col-md-12 mb-1">
                        <a class="underline_a" style="    float: right;">Forgot password</a>
                    </div>
                     <div class="form-group col-md-12 mb-1">
                        <button class="select_size" style="    padding: 5px 24px;letter-spacing: 1px; width:100%">Login</button>
                    </div>
                     <div class="form-group col-md-6 mb-1">
                         <img  src="{{asset('/assets/img/google.png')}}" alt="">
                    </div>
                    <div class="form-group col-md-6 mb-1">
                         <img src="{{asset('/assets/img/pp.png')}}" alt="">
                    </div>
                </div>
                
              
            </form>
            </div>
            <div class="col-sm-4">
                 <form  class="col-md-9 m-auto" method="post" role="form">
                <div class="row">
                    <div class="form-group col-md-12 mb-1 ">
                        <p style="    color: #7e7c7da1; font-size: 20px !important;">New customer</p>
                    </div>
                </div>
                        
                <div class="row contact">
                    <div class="form-group col-md-12 mb-1">
                        <input type="email" class="form-control mt-1  contact-text" id="email" name="email" placeholder="E-mail">
                        
                    </div>
                  
                     <div class="form-group col-md-12 mb-1">
                        <button class="select_size" style="     margin-top: 15px;   padding: 5px 24px;letter-spacing: 1px; width:100%">Continue</button>
                    </div>
                     <div class="form-group col-md-6 mb-1">
                         <img  src="{{asset('/assets/img/google.png')}}" alt="">
                    </div>
                    <div class="form-group col-md-6 mb-1">
                         <img src="{{asset('/assets/img/pp.png')}}" alt="">
                    </div>
                </div>
            </form>
            </div>
             <div class="col-sm-2"></div>
             <div class="col-sm-12" style="height:100px"></div>
                            <div class="col-sm-12" style="background: white;box-shadow: 0px -2px 7px rgb(179 177 177 / 29%);padding: 15px 0;">
                    <div class="row">
                        <div class="col-sm-6">
                            <a class="underline_a" style=" padding: 6px 20px;   float: left;">Terms & condition</a>
                        </div>
                          <div class="col-sm-6">
<a class="underline_a" style=" padding: 6px 20px;   float: right;">Whatsapp</a><a class="underline_a" style="padding: 6px 20px;    float: right;">Phone</a><a class="underline_a" style="  padding: 6px 20px;  float: right;">E-mail</a>
                          </div>
                    </div>
                </div>

        </div>

    </div>
    @endsection