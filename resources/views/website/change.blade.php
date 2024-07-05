@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/yes.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/no.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/change.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container" >
        <p class="toptext">Battery Change</p>
    </div>




    <div class="container">
        <div class="row w-100 ">
            <div class="col-4 ">
                <hr class="hrone">
            </div>
            <div class="col-4 ">
                <hr class="hrtwo">
            </div>
            <div class="col-4 ">
                <hr class="hrthree">
            </div>
        </div>
    </div>



<div class="container "> 
<div class="row w-100 pt-5 ">
    <div class="col-lg-5 col-md-12 choose mx-auto mt-3">
      <div class="row w-100 pt-4">
        <div class="col-11">
          <p class="right">Choose your ride</p>
        </div>
        <div class="col-1">
          <a href="{{route('website.add',1)}}" class="btn d-flex align-items-center justify-content-center" style="width: 100%;background-color: #F8F9FA;">
            <i class="bi bi-plus" style="color: #9098A5; "></i>
               
            </i>
          </a>
        </div>
       </div>
       <div class="row w-100 d-flex align-items-center py-3">
        <div class="col ">
          <a href="car.html" style="text-decoration: none;cursor: pointer;">
          <div class="d-flex carcontainer align-items-center justify-content-center activetype">
           <img src="{{asset('image/car.png')}}">
           <p>Car</p>
          </div></a>
        </div>
        <div class="col"><a href="bike.html" style="text-decoration: none;cursor: pointer;">
          <div class="d-flex bikecontainer align-items-center justify-content-center">
            
           <img src="{{asset('image/ri_motorbike-fill.png')}}">
           <p>Bike</p>
          </div></a>
        </div>
       </div> 
       <div class="row w-100  align-items-center justify-content-center pb-4 h-75">
        <div class="col-lg-5 col-md-12 carmarkone position-relative">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefaultthree" id="flexRadioDefaultone">
                <label class="form-check-label check" for="flexRadioDefaultone">
        <img src="{{asset('image/car1.png')}}">
        <p class="cartype">Defender 110 Land Rover</p>
        <p  class="carstyle">XX - DXB - XXXX <br>White</p>
    </label>
</div>
        </div>
        <div class="col-lg-5 col-md-12 carmarkone" >
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefaultthree" id="flexRadioDefaultone">
            <label class="form-check-label check" for="flexRadioDefaultone">
    <img src="{{asset('image/car1.png')}}">
    <p class="cartype">Defender 110 Land Rover</p>
    <p  class="carstyle">XX - DXB - XXXX <br>White</p>
</label>
</div>
        
            </div>
            <div class="col-lg-5 col-md-12 carmarkone">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefaultthree" id="flexRadioDefaultthree">
                    <label class="form-check-label check" for="flexRadioDefaultthree">
                <img src="{{asset('image/car2.png')}}">
                <p class="cartype">GMC Yukon</p>
                <p  class="carstyle">XX - DXB -XXX<br> Black</p>
            </label>
        </div>
                </div>
                <div class="col-lg-5 col-md-12 carmarkone">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefaultthree" id="flexRadioDefaultfour">
                        <label class="form-check-label check" for="flexRadioDefaultfour">
                    <img src="{{asset('image/car2.png')}}">
                    <p class="cartype">GMC Yukon</p>
                    <p class="carstyle">XX - DXB -XXX<br> Black</p>
                </label>
            </div>
                    </div>
       </div>
    </div>
    <div class="col-lg-5 col-md-12 mx-auto mt-3" style="background-color: white; border-radius:2.25rem;  padding: 1.5rem;">
      <div class="row w-100 pt-4">
       <div class="col-11">
         <p class="right">Choose the right battery for you !</p>
       </div>
       <div class="col-1">
        <a href="{{route('website.add',1)}}" class="btn d-flex align-items-center justify-content-center" style="width: 100%;background-color: #F8F9FA;">
          <i class="bi bi-plus" style="color: #9098A5; "></i>
             
          </i>
        </a>
       </div>
      </div>  
    
  
      <div class="row w-100">
       <div class="col-lg-6 col-md-12  p-4 ">
         <div class="container country">
         <div class="form-check">
           <input class="form-check-input flexRadioDefault7" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
           <label class="form-check-label check" for="flexRadioDefault1">
             Chinese battery
           </label>
         </div>
         <p class="launch">Launch Offer! 100%OFF!</p>
         <div>
           <p class="available">Available brands :<br> Rambo<br> Golden Stars</p>
         </div>
         <div class="d-flex align-content-end justify-content-end">
           <p class="available">300 AED</p>
         </div>
       </div></div>
       
       <div class="col-lg-6 col-md-12 p-4">
        <div class="container country">
        <div class="form-check">
          <input class="form-check-input flexRadioDefault7" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
          <label class="form-check-label check" for="flexRadioDefault2">
            Korean Battery
          </label>
        </div> 
        <p class="launch">Launch Offer! 100%OFF!</p>
        <div>
          <p class="available">Available brands :<br> Rambo<br> Golden Stars</p>
        </div>
        <div class="d-flex align-content-end justify-content-end">
          <p class="available">300 AED</p>
        </div>
      </div>
     </div>
    </div>
      <div class="row w-100 pt-5 ">
       <div class="col-lg-6 col-md-12  p-4">
         <div class="container country">
         <div class="form-check">
           <input class="form-check-input flexRadioDefault7" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
           <label class="form-check-label check" for="flexRadioDefault3">
             German Battery
           </label>
         </div> 
         <p class="launch">Launch Offer! 100%OFF!</p>
         <div>
           <p class="available">Available brands :<br> Rambo<br> Golden Stars</p>
         </div>
         <div class="d-flex align-content-end justify-content-end">
           <p class="available">300 AED</p>
         </div>
       </div></div>
       <div class="col-lg-6 col-md-12  p-4">
         <div class="container country">
         <div class="form-check">
           <input class="form-check-input flexRadioDefault7" type="radio" name="flexRadioDefault" id="flexRadioDefault4">
           <label class="form-check-label check" for="flexRadioDefault4">
             AGM Battery
           </label>
         </div>
         <p class="launch">Launch Offer! 100%OFF!</p>
         <div>
           <p class="available">Available brands :<br> Rambo<br> Golden Stars</p>
         </div>
         <div class="d-flex align-content-end justify-content-end">
           <p class="available">300 AED</p>
         </div> </div>
       </div>
      </div>
     </div>
</div>
</div>

<div class="row w-100 d-flex align-items-end justify-content-end pt-5 ">
  <div class="col-4 greenbutton">
    <a class="btn next " href="{{route('website.change.two')}}" role="button">Next</a>
  </div>
</div>
@endsection
@section('additional_scripts')
@endsection