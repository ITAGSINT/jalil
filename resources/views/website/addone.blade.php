@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/add.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/addone.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@section('content')
<div class="alert alert-danger" style="display:none">
                                
                            </div>
<div class="container">
  <div class="row w-100">
    <div class="col-12 d-flex">
      <a class="btn" href="">
        <i class="fa-solid fa-chevron-left left"></i></a>
      <p class="add">Add your Ride</p>
    </div>
  </div>
</div>
<div class="container">
  <div class="row w-100">
    <div class="col-lg-5 col-md-12 mx-auto" style="background-color: #ffffff;border-radius: 36px;">

      <div class="row w-100 d-flex align-items-center pt-4">
        <div class="col-4">
          <div class="input-group mb-3">
            <input type="text" id="main_item_one" class="form-control numinput main_item_one" placeholder="Number" aria-label="Username" aria-describedby="basic-addon1" />
          </div>
        </div>
        <div class="col-4">
          <div class="input-group mb-3">
            <input type="text" id="main_item_two" class="form-control numinput main_item_one" placeholder="DXB" aria-label="Username" aria-describedby="basic-addon1" />
          </div>
        </div>
        <div class="col-4">
          <div class="input-group mb-3">
            <input type="text" id="main_item_three" class="form-control numinput main_item_one" placeholder="code" aria-label="Username" aria-describedby="basic-addon1" />
          </div>
        </div>
      </div>

      <div class="row w-100 d-flex align-items-center py-3">
        <div class="col-12">
          <p class="chooseemirate">Choose Emirate</p>
        </div>
      </div>
      <div class="row w-100 mx-0 px-0">
        <div class="col-12">
          <p class="emirate">Choose Emirate</p>

          <ul id="myUL" class="add-ul cities">
            
          </ul>
        </div>
      </div>
    </div>




    <div class="col-lg-5 col-md-12 mx-auto col-color" style="background-color: #ffffff;border-radius: 36px;">

      <div class="row w-100 pt-3">
        <div class="col-12">
          <p class="chooseemirate">Select vehicle color</p>
        </div>
      </div>
      <div class="row w-100">
        <div class="col-12">
          <p class="emirate">Select vehicle color</p>

          <ul id="myUL" style="border:1px solid #F8F9FA;border-radius: 0.5rem;" class="ul-select px-1 mx-0 colors">
           
          </ul>
        
          <a class="skip btn my-4">SKIP</a>
        </div>
      </div>

    </div>


  </div>


</div>




<div class="container pt-4  ">
  <div class="row w-100">
    <div class="col-11 d-flex mx-auto justify-content-end " style="background-color:#ffffff;border-radius: 16px;padding: 16px;">
      <!--  <ul id="myULBottom"></ul>-->
      
      <div class="col-lg-2 col-md-12 mx-auto" @if( $manfname=="" ) style="display:none" @endif>
        <input readonly type="text" id="myInputone" placeholder="" class=" myInputone"  value="{{$manfname}}" />
      </div>
      <div class="col-lg-2 col-md-12 mx-auto" @if( $modelname == "" ) style="display:none" @endif>
        <input readonly type="text" id="myInputtwo" placeholder="" class="myInputtwo" value="{{$modelname}}" />
      </div>
      <div class="col-lg-2 col-md-12 mx-auto">
        <input readonly type="text" id="myInputthree" placeholder="" class="myInputthree" />
      </div>
      <div class="col-lg-2 col-md-12 mx-auto">
        <input readonly type="text" id="myInputfive" placeholder="" class="myInputfive" />
      </div>
      <div class="col-lg-2 col-md-12 mx-auto">
        <input readonly type="text" id="myInputfour" placeholder="" class="myInputfour" />
      </div>
      <div class="col-lg-2 col-md-12 mx-auto">
        <div id="myDIV" class="header">
          <form id="myform" method="get" action="">
            @csrf
            <input type="text" id="sertype" name="sertype" value="{{$servicetype}}" hidden>
            <input type="text" id="manfinput" name="manfinput" value="{{$manfinput}}" hidden>
            <input type="text" id="modelinput" name="modelinput" value="{{$modelinput}}" hidden>
            <input type="text" id="emirateinput" name="emirateinput" value="" hidden>
            <input type="text" id="colorinput" name="colorinput"  value="" hidden>
            <input type="text" id="vichleinput" name="vichleinput" value="{{$vichleinput}}" hidden>


            <button id="myBtn1" type="submit" class="addBtnCar" style="border:none;width:100%">Add Car</button>

          </form>
          <button id="myBtn" type="submit" data-bs-toggle="modal" data-bs-target="#myModal" class="addBtnCar" style="border:none;width:100%;display:none">Add Car</button>

          {{-- <a id="myBtn" onclick="newElement()" href="#"  class="addBtnCar" >Add Car</a>--}}
        </div>
      </div>
    </div>
  </div>
</div>

<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <h3>Successfully added your ride</h3>
    <div class="row w-100 end-add text-center">
      <div class="col-12 p-5" id="modal_image">


      </div>
      <div class="col-12">
        <p id="modal_manf_model"></p>
        <p id="modal_code"></p>
        <p>Super 98</p>

      </div>
    </div>
  </div>

</div>
@endsection
@section('additional_scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Template Javascript -->
<script>

</script>
<script>
  $(document).ready(function() {
    showCities()
    showColors()
  });

  function showCities() {
    $.ajax({
      url: '{{ route('api.car.city') }}',
      type: "get",
      data: {},
      // processData: false,
      // contentType: false,
      success: function(data) {

        if (data.success == true) {
          $('.cities').empty()
          var row = `<div class="row w-100  "> `;
          var element = ``;
          for (var i = 0; i < data.data.length; i++) {
            element += `<div class="col-6 pt-2 pb-2">
             
            <li ><a href="#" class="myli city_element"  data-city="` + data.data[i].id + `">` + data.data[i].name + `</a></li>
            </div>`
          }
          row += element;
          row += `</div>`
          $('.cities').append(row)
        } else {


        }


      },
    });
  }

  function showColors() {
    $.ajax({
      url: '{{ route('website.get.all.colors') }}',
      type: "get",
      data: {},
      // processData: false,
      // contentType: false,
      success: function(data) {

        if (data.success == true) {
          $('.colors').empty()
          var row = `<div class="row w-100 pt-4 pb-5 mx-0  px-0 row-top"> `;
          var element = ``;
          for (var i = 0; i < data.data.length; i++) {
            if(data.data[i].id != 1) {
            element += `<div class="col-2 col-wid">
          <li style="list-style: none;"><a  style="text-decoration: none;" class="text-center myli-color " data-color="` + data.data[i].id + `"><div class="rounded-circle car-color mx-auto " style="background-color: ` + data.data[i].hex_code + `;"></div><p class="color-name">` + data.data[i].name + `</p></a></li></div>`
            }  
            
        }
          element += `<div class="col-2 col-wid"> <li style="list-style: none;"><a  style="text-decoration: none;" class="text-center myli-color" data-color="1" ><div class="rounded-circle car-color mx-auto" style="background-image: url('{{asset('image/Rectangle.png')}}');"></div><p class="color-name">Other</p></a></li></div>`
          row += element;
          row += `</div>`
          $('.colors').append(row)
        } else {


        }


      },
    });
  }
</script>
<script src="{{ URL::asset('js/addone.js') }}"></script>
<script>
  $(function() {
    //WHEN YOU CLICK THE ELEMENT..
    $(document).on('click', '.myli', function(event) {
      event.preventDefault();

      var id = $(this).attr("data-city");
      //PLACE THE TEXT INSIDE THE INPUT FIELD, YOU CAN CHANGE YOUR SELECTOR TO TARGET THE RIGHT INPUT

      $('input[id="emirateinput"]').val(id);
      //HERE YOU CAN DO SOMETHING ELSE LIKE SIBMITING THE FORM, OR CLICK A BUTTON.. OR SOMETHING ELSE
    });
  });
</script>
<script>
  $(function() {
    //WHEN YOU CLICK THE ELEMENT..
    $(document).on('click', '.myli-color', function(event) {
      event.preventDefault();
      //GET THE TEXT INSIDE THAT SPECIFIC LI

      var id = $(this).attr("data-color");
      //PLACE THE TEXT INSIDE THE INPUT FIELD, YOU CAN CHANGE YOUR SELECTOR TO TARGET THE RIGHT INPUT
      $('input[id="colorinput"]').val(id);
      //HERE YOU CAN DO SOMETHING ELSE LIKE SIBMITING THE FORM, OR CLICK A BUTTON.. OR SOMETHING ELSE
    });
  });
</script>
<script>
  $(function() {
    //WHEN YOU CLICK THE ELEMENT..
    $(document).on("click", ".myli", function() {
      //GET THE TEXT INSIDE THAT SPECIFIC LI
      var content = $(this).text();
      $("#myInputthree").css("display", "block");
      //PLACE THE TEXT INSIDE THE INPUT FIELD, YOU CAN CHANGE YOUR SELECTOR TO TARGET THE RIGHT INPUT
      $('input[id="myInputthree"]').val(content);
      //HERE YOU CAN DO SOMETHING ELSE LIKE SIBMITING THE FORM, OR CLICK A BUTTON.. OR SOMETHING ELSE
    });
  });

  $(function() {
    //WHEN YOU CLICK THE ELEMENT..
    $(document).on("click", ".myli-color", function() {
      //GET THE TEXT INSIDE THAT SPECIFIC LI
      var content = $(this).text();
      $("#myInputfour").css("display", "block");
      //PLACE THE TEXT INSIDE THE INPUT FIELD, YOU CAN CHANGE YOUR SELECTOR TO TARGET THE RIGHT INPUT
      $('input[class="myInputfour"]').val(content);
      //HERE YOU CAN DO SOMETHING ELSE LIKE SIBMITING THE FORM, OR CLICK A BUTTON.. OR SOMETHING ELSE
    });
  });

  // JavaScript
  
  $(function() {
    //WHEN YOU CLICK THE ELEMENT..
    $(document).on("change", ".main_item_one", function() {
      //GET THE TEXT INSIDE THAT SPECIFIC LI
      var input = $("#main_item_one").val();
      // var inputValue = input.value;
      var inputOne = $("#main_item_two").val();
      // var inputValueOne = inputOne.value;
      var inputTwo = $("#main_item_three").val();
      inputValueThree = input + "-" + inputOne + "-" + inputTwo;
      console.log(input);
      console.log(inputValueThree);
      // var content= $('inputValueThree').html();
      $("#myInputfive").css("display", "block");
      //PLACE THE TEXT INSIDE THE INPUT FIELD, YOU CAN CHANGE YOUR SELECTOR TO TARGET THE RIGHT INPUT
      $("#myInputfive").val(inputValueThree);
      //HERE YOU CAN DO SOMETHING ELSE LIKE SIBMITING THE FORM, OR CLICK A BUTTON.. OR SOMETHING ELSE
    });
  });
</script>
<script>
  $(document).on('click', "#myBtn1", function(e) {
    e.preventDefault();
    var manfinput = $('#manfinput').val();
    var modelinput = $('#modelinput').val();
    var emirateinput = $('#emirateinput').val();
    var colorinput = $('#colorinput').val();
    var sertype = $('#sertype').val();
    var vichle = $('#vichleinput').val();
    var plate_num=$('#myInputfive').val();
    $.ajax({
      url: "{{route('website.storeCarInSession')}}",
      type: "post",
      data: {
        "_token": "{{ csrf_token() }}",
        'vichle': vichle,
        'manfinput': manfinput,
        'modelinput': modelinput,
        'emirateinput': emirateinput,
        'colorinput': colorinput,
        'sertype': sertype,
        'plate_num':plate_num
      },
      dataType: "JSON",


      success: function(response) {
        if (response.success == true) {
          $('.alert').css('display','none')
          image = response.data.model_image;
          manf_model = response.data.manufacturer + ` ` + response.data.model
          plate_num=response.data.plate_num
          $('#modal_image').empty()
          $('#modal_image').append(`<img src="` + image + `">`)
          $('#modal_manf_model').text(manf_model)
          $('#modal_code').text(plate_num)
          $('#myBtn').click();
          $('#myform')[0].reset();
          setTimeout(function() {
            $('#myBtn').click();
           if(response.serviceType==3) {
              //tyre change
              // Simulate a mouse click:
window.location.href = "{{route('website.tyre')}}";
           }
           else if(response.serviceType==1) {
              //battery change
              window.location.href = "{{route('website.two')}}";
           }
           else if (response.serviceType==2) {
            //car wash
            window.location.href = "{{route('website.carWash')}}";
           
           }
          }, 1000);

        }
        else {
          $('.alert').empty()
          var ul=`<ul>`
          
          for(var i=0;i<response.length;i++) {
            if(response[i].messages['colorinput']) {
              ul+=`<li>`+response[i].messages['colorinput']+`</li>`
            }
            if(response[i].messages['modelinput']) {
              ul+=`<li>`+response[i].messages['modelinput']+`</li>`
            }
            if(response[i].messages['vichle']) {
             ul+=`<li>`+response[i].messages['vichle']+`</li>`
            }
            if(response[i].messages['plate_num']) {
              ul+=`<li>`+response[i].messages['plate_num']+`</li>`
            }

          }
          ul+=`</ul>`
          $('.alert').append(ul)
          $('.alert').css('display','block')
        Swal.fire({
          text: "Failed",
          icon: "error"
           });
        }
      },
      error: function(xhr, status, error,data) {
       
      }
    });

  })
</script>
<script>
  function DisableBackButton(){
 window.history.forward()
}
DisableBackButton();
window.onload = DisableBackButton;
window.onpageshow = function(evt) { if (evt.persisted) DisableBackButton() }
window.onload = function() {void(0)}
  </script>
@endsection