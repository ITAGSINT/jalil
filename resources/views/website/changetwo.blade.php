@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/no.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/change.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/changetwo.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
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
                <hr class="hrone">
            </div>
            <div class="col-4 ">
                <hr class="hrthree">
            </div>
        </div>
    </div>






<div class="container">
  <div class="row w-100">
    <div class="col-lg-6 col-md-12 row ">
      <div class="col-12  choose choose-right">
        <div class="row w-100 ">
          <div class="col-11 ">
            <p class="right">Choose Delivery Address</p>
          </div>
          <div class="col-1">
            <a href="add.html" class="btn d-flex align-items-center justify-content-center" style="width: 100%;background-color: #F8F9FA;">
              <i class="bi bi-plus" style="color: #9098A5; "></i>
                 
              </i>
            </a>
          </div>
         </div>


         <div class="row w-100  align-content-center justify-content-center pb-4 h-100"  style="border:1px solid #F8F9FA;border-radius: 16px;">
          <div class="col-md-6 col-sm-12">
           <p class="select ">Select from saved addresses</p>
           <div class="form-check">
            <input class="form-check-input check-location" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
              <div class="row w-100">
                <div class="col-2 pt-3">
                  <i class="bi bi-geo-alt location-icon"></i>
                </div>
                <div class="col-10">
                  <p class="location-name">Office</p>
                  <p class="location-name-details">2118 Thornridge Cir. Syracuse, Connecticut 35624</p>
                </div>
              </div>
              
              
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input check-location" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
            <label class="form-check-label" for="flexRadioDefault2">
              <div class="row w-100">
                <div class="col-2 pt-3">
                  <i class="bi bi-geo-alt location-icon"></i>
                </div>
                <div class="col-10">
                  <p class="location-name">Office</p>
                  <p class="location-name-details">2118 Thornridge Cir. Syracuse, Connecticut 35624</p>
                </div>
              </div>
              
              
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input check-location" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
            <label class="form-check-label" for="flexRadioDefault3">
              <div class="row w-100">
                <div class="col-2 pt-3">
                  <i class="bi bi-geo-alt location-icon"></i>
                </div>
                <div class="col-10">
                  <p class="location-name">Office</p>
                  <p class="location-name-details">2118 Thornridge Cir. Syracuse, Connecticut 35624</p>
                </div>
              </div>
              
              
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input check-location" type="radio" name="flexRadioDefault" id="flexRadioDefault4">
            <label class="form-check-label" for="flexRadioDefault4">
              <div class="row w-100">
                <div class="col-2 pt-3">
                  <i class="bi bi-geo-alt location-icon"></i>
                </div>
                <div class="col-10">
                  <p class="location-name">Office</p>
                  <p class="location-name-details">2118 Thornridge Cir. Syracuse, Connecticut 35624</p>
                </div>
              </div>
              
              
            </label>
          </div>
           
          </div>
          <div class="col-md-6 col-sm-12">
            <div class="form-check">
              <input class="form-check-input check-location" type="radio" name="flexRadioDefault" id="flexRadioDefault5">
              <label class="form-check-label" for="flexRadioDefault5">
                <div class="row w-100">
                 
                  <div class="col-12">
                    <p class="location-name">Or choose your current location</p>
                  </div>
                </div>
                
                
              </label>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d2503345.026653993!2d5.2793703!3d52.2129919!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snl!4v1716894214590!5m2!1sen!2snl" width="100%" height="75%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <form class="example" action="action_page.php">
              <input type="text" placeholder="Search your location" name="search">
              <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        
          </div>
                 
          </div>
      </div>
    </div>







    <div class="col-lg-6 col-md-12 row ">
      <div class="col-12  choose choose-left" >
        <div class="row w-100 pt-4">
          <div class="col-12">
            <p class="right">Select arrival date & time</p>
          </div>
       
         </div>  


         <div class="row w-100">
          <div class="col-md-7 col-sm-12" style="border:1px solid #F8F9FA; border-radius: 16px;padding-top: 2rem;">
            <div class="row w-100 mx-0 px-0">
              <div class="col-10 mx-0 px-0 h-100"> <input type="text" id="alternate" class="input-date h-100"></div>
              <div class="col-2 mx-0 px-0 h-100" style="  background-color: #F8F9FA;text-align: center;"> <i class="bi bi-chevron-down h-100" style="  background-color: #F8F9FA;width: 100%;height: 100%;"></i></div>
            </div>
          <div id="datepicker"></div>
          </div>


          <div class="col-md-5 col-sm-12" >
            <ul id="myUL" class="change-time py-5" style="overflow-y: scroll;height: 18rem;">
             
            <li class="my-1 text-center"><a  class="myli">10am-11am</a></li>
           
            <li class="my-1 text-center" ><a class="myli">11am-12pm</a></li>

            <li class="my-1 text-center" ><a  class="myli">1pm-2pm</a></li>

            <li class="my-1 text-center" ><a  class="myli active ">3pm-4pm</a></li>

            <li class="my-1 text-center" ><a  class="myli">4pm-5pm</a></li>

            <li class="my-1 text-center" ><a  class="myli">5pm-6pm</a></li>
          
            <li class="my-1 text-center" ><a  class="myli">5pm-6pm</a></li>

            <li class="my-1 text-center" ><a  class="myli">5pm-6pm</a></li>

            <li class="my-1 text-center" ><a class="myli">5pm-6pm</a></li>
        
       
          </ul>
          </div>
         </div>
      </div>
    </div>
  </div>
</div>
<div class="row w-100 d-flex align-items-end justify-content-end pt-5 ">
  <div class="col-4 greenbutton">
    <a class="btn next " href="{{route('website.addresses')}}" role="button">Next</a>
  </div>
</div>
@endsection
@section('additional_scripts')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
      <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="{{URL::asset('js/changetwo.js') }}"></script>   
@endsection