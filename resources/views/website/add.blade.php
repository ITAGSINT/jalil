@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/no.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/add.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
<div class="row w-100">
    <div class="col-12 d-flex">
        <a class="btn" href="">
        <i class="fa-solid fa-chevron-left left"></i></a>
       <p class="add">Add your Ride</p>
    </div>
    </div>
</div>



<div class="container" >
    <div class="row w-100">
        <div class="col-lg-5 col-md-12 mx-auto" style="background-color: #ffffff;border-radius: 36px;">
            <div class="row w-100 d-flex align-items-center py-3">
                <div class="col-3 ">
                  <a href="#" style="text-decoration: none;cursor: pointer;" class="type" data-id="1">
                  <div class="d-flex carcontainer activetype align-items-center justify-content-center">
                   <img src="{{asset('image/car.png')}}">
                   <p>Car</p>
                  </div></a>
                </div>
                <div class="col-3"><a href="#" style="text-decoration: none;cursor: pointer;" class="type" data-id="2">
                  <div class="d-flex bikecontainer align-items-center justify-content-center">
                    
                   <img src="{{asset('image/ri_motorbike-fill.png')}}">
                   <p>Bike</p>
                  </div></a>
                </div>
               </div> 
               <div class="row w-100">
                <div class="col-12">
                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Type manufacturer name|" class="mylisearch">
                    

<ul id="myUL" class="add-ul manufacturer">
 
</ul>
@error('manufacturerinput')
<p class="text-danger">{{ $message }}</p>
@enderror
                </div>
               </div>
        </div>




        <div class="col-lg-5 col-md-12 mx-auto" style="background-color: #ffffff;border-radius: 36px;">
             
               <div class="row w-100 pt-3">
                <div class="col-12">
                    <input type="text"  class="mymodal" id="myInput" onkeyup="myFunction()" placeholder="Type model name" >
                    
<ul id="myUL" class="add-ul models">
   

</ul>
@error('modelinput')
<p class="text-danger">{{ $message }}</p>
@enderror
                </div>
               </div>
           
        </div>


    </div>

   
</div>

<div class="container pt-4  ">
  <div class="row w-100">
    <div class="col-11 d-flex mx-auto justify-content-end "   style="background-color:#ffffff;border-radius: 16px;padding: 16px;" >
    <!--  <ul id="myULBottom"></ul>-->
    <div class="col-md-4 col-sm-12 mx-auto">
    <input readonly type="text" id="myInputone"  placeholder="" class="myInputone"></div>
    <div class="col-md-4 col-sm-12 mx-auto">
    <input readonly type="text" id="myInputtwo"  placeholder="" class="myInputtwo"></div>
    <div class="col-md-3 col-sm-12 " >
      <div id="myDIV" class="header">
      <form method="POST" action="{{route('website.storeaddPage')}}">
        @csrf
        <input type="text" id="sertype"  name="sertype"  value={{$id}} hidden>
        <input type="text" id="vichletype"  name="vichletype"   value=1 hidden>
        <input type="text" id="manfinput"  name="manufacturerinput" hidden>
        <input type="text" id="modelinput" name="modelinput" hidden >
        <input type="text" id="manfname"  name="manfname" hidden >
        <input type="text" id="modelname" name="modelname" hidden >
        <button type="submit" class="addBtn" style="border:none">Add Car</button>
     
      </form>
       {{-- <a onclick="addNext()" href="{{route('website.add.next')}}" class="addBtn" >aDD CAR</a>--}}
      </div>
</div>
    </div>
  </div>
</div>
@endsection
@section('additional_scripts')
<script>
    function myFunction() {
      // Declare variables
      var input, filter, ul, li, a, i, txtValue;
      input = document.getElementById('myInput');
      filter = input.value.toUpperCase();
      ul = document.getElementById("myUL");
      li = ul.getElementsByTagName('li');
    
      // Loop through all list items, and hide those who don't match the search query
      for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          li[i].style.display = "";
        } else {
          li[i].style.display = "none";
        }
      }
    }
    </script>
  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ URL::asset('js/add.js') }}"></script>
  <script>
    $(function(){
//WHEN YOU CLICK THE ELEMENT..
$(document).on('click','.myli',function(event){
  event.preventDefault();
  //GET THE TEXT INSIDE THAT SPECIFIC LI
var content= $(this).text();
var id=$(this).attr("data-id");
//PLACE THE TEXT INSIDE THE INPUT FIELD, YOU CAN CHANGE YOUR SELECTOR TO TARGET THE RIGHT INPUT
$('input[class="mylisearch"]').val(content);
$('input[id="manfinput"]').val(id);
//HERE YOU CAN DO SOMETHING ELSE LIKE SIBMITING THE FORM, OR CLICK A BUTTON.. OR SOMETHING ELSE
  });
});
  </script>
   <script>
    $(function(){
//WHEN YOU CLICK THE ELEMENT..
$(document).on('click','.range',function(event){
  event.preventDefault();
//GET THE TEXT INSIDE THAT SPECIFIC LI
var content= $(this).text();
var id=$(this).attr("data-model");
//PLACE THE TEXT INSIDE THE INPUT FIELD, YOU CAN CHANGE YOUR SELECTOR TO TARGET THE RIGHT INPUT
$('input[class="mymodal"]').val(content);
$('input[id="modelinput"]').val(id);
//HERE YOU CAN DO SOMETHING ELSE LIKE SIBMITING THE FORM, OR CLICK A BUTTON.. OR SOMETHING ELSE
  });
});
  </script>
  <script>
    $(document).ready(function() {
      showManufacturer(1)
    }) 
    $(document).on('click','.type',function (event) {
    event.preventDefault();
     let id = $(this).data("id");
     $('#vichletype').val(id)
     if(id==2)  {
        $(".carcontainer").removeClass("activetype");
        $(".bikecontainer").addClass("activetype");
     }
     else if(id==1)  {
      $(".bikecontainer").removeClass("activetype");
      $(".carcontainer").addClass("activetype");
     }
     showManufacturer(id)
    });
    $(document).on('click','.manufcturer_element',function (event) {
    event.preventDefault();
     let id = $(this).data("id");
     $('input[id="modelinput"]').val("");
     $('#myInputtwo').css("display","none")
           //PLACE THE TEXT INSIDE THE INPUT FIELD, YOU CAN CHANGE YOUR SELECTOR TO TARGET THE RIGHT INPUT
           $('input[class="myInputtwo"]').val("");
           $('#modelname').val("")
     showManufacturerModels(id)
    });
    function showManufacturer(id) {
      $.ajax({
        url:'{{ route('api.car.manufacture') }}',
        type: "get",
        data:{type:id,},
        // processData: false,
        // contentType: false,
        success: function (data) {
          
         if(data.success==true){
          $('.manufacturer').empty()
          var row=`<div class="row w-100  "> `;
           var element=``;
           for(var i=0;i<data.data.length;i++) {
             element +=`<div class="col-6 pt-2 pb-2">
             
            <li ><a href="#" class="myli manufcturer_element" data-id="`+data.data[i].id+`"><img src="`+data.data[i].logo+`">`+data.data[i].name+`</a></li>
            </div>`
           }
           row +=element;
           row += `</div>`
           $('.manufacturer').append(row)
         }
         else {
             
             
         }
     
        
      },
    });
    
    }
    function showManufacturerModels(id) {
      $.ajax({
        url:'{{ route('api.car.model') }}',
        type: "get",
        data:{manufacturer_id:id,},
        // processData: false,
        // contentType: false,
        success: function (data) {
          
         if(data.success==true){
          $('.models').empty()
          var row=`<div class="row w-100  "> `;
           var element=``;
           for(var i=0;i<data.data.length;i++) {
             element +=`<div class="col-6 pt-2 pb-2">
             <li> <a href="#" class="range model_element" data-model="`+data.data[i].id+`">`+data.data[i].name+`</a></li>
            </div>`
           }
           row +=element;
           row += `</div>`
           $('.models').append(row)
         }
         else {
             
             
         }
     
        
      },
    });
    }
    
    </script>
@endsection