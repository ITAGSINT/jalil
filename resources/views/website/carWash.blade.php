@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/yes.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/no.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/change.css') }}" rel="stylesheet">

@endsection
@section('content')
<style>
  .flexRadioDefault {
    display: none;
  }

  .flexRadioDefault+.check::before {
    margin-top: 0.2rem;
    color: black;
    font-family: FontAwesome;
    border: 2px solid #519C66;
    content: "\f00c";
    font-size: 24px;
    position: absolute;
    top: 0px;
    left: 90%;
    transform: translateX(-50%);
    height: 50px;
    width: 50px;
    line-height: 50px;
    text-align: center;
    border-radius: 50%;
    background: #16330000;
    box-shadow: 0px 2px 5px -2px hsla(0, 0%, 0%, 0.25);
  }

  .flexRadioDefault:checked+.check::before {

    margin-top: 0.2rem;
    top: 0px;
    left: 90%;
    background-color: #519C66;
    color: white;
  }
</style>
<div class="container">
  <p class="toptext">Car Wash</p>
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
    <div class="col-lg-6 col-md-12 choose mx-auto mt-3">
      <div class="row w-100 pt-4">
        <div class="col-11">
          <p class="right">Choose your ride</p>
        </div>
        <div class="col-1">
          <a href="{{route('website.add',2)}}" class="btn d-flex align-items-center justify-content-center" style="width: 100%;background-color: #F8F9FA;">
            <i class="bi bi-plus" style="color: #9098A5; "></i>

            </i>
          </a>
        </div>
      </div>
      <div class="row w-100 d-flex align-items-center py-3">
        <div class="col ">
          <a href="" style="text-decoration: none;cursor: pointer;" class="type" data-id="1">
            <div class="d-flex carcontainer align-items-center justify-content-center activetype">
              <img src="{{asset('image/car.png')}}">
              <p>Car</p>
            </div>
          </a>
        </div>
        <div class="col"><a href="" style="text-decoration: none;cursor: pointer;" class="type" data-id="2">
            <div class="d-flex bikecontainer align-items-center justify-content-center">

              <img src="{{asset('image/ri_motorbike-fill.png')}}">
              <p>Bike</p>
            </div>
          </a>
        </div>
      </div>
      <div class="row w-100  justify-content-center pb-4 h-90  user_vichles" style="  min-height: 30rem;  overflow-y: scroll; max-height: 30rem;">
        <div class="col-6 ">
          <a href="{{route('website.add',1)}}" class="btn d-flex align-items-center justify-content-center  " style="width: 100%;background-color: #F8F9FA;height: 10rem;">
            <i class="bi bi-plus" style="color: #9098A5; font-size: -webkit-xxx-large;">

            </i>
          </a>
        </div>
      </div>
    </div>
    <div class="col-lg-5 col-md-12 mx-auto mt-3" style="background-color: white; border-radius:2.25rem;  padding: 1.5rem;">
      <div class="row w-100 pt-4">
        <div class="col-12">
          <p class="right">Select the right service</p>
        </div>

      </div>



      <div class="row w-100" id="bat">



      </div>
    </div>
  </div>
</div>

<!-- <div class="row w-100 d-flex align-items-end justify-content-end pt-5 ">
  <div class="col-4 greenbutton">
    <a class="btn next " href="{{route('website.addresses.two')}}" role="button">Next</a>
  </div>
</div> -->

<div class="container">
    <div  class="row w-100 d-flex align-items-center justify-content-center pt-5">
    <div class="col-5">
            <form method="POST" action="{{route('website.storeProductInSession')}}">
                @csrf
                <div class="col-lg-5 col-md-12 mt-3 mx-auto ">
                <input type="text" id="parent_id"  name="parent_id"  value="2"  hidden>
        <input type="text" id="car_id"  name="car_id"  value="1" hidden >
        <input type="text" id="size"  name="size"   value="" hidden>
        <input type="text" id="manufacturer_id"  name="manufacturer_id"   value="" hidden >
        <input type="text" id="product_id"  name="product_id"   value="" hidden >
        <input type="text" id="price"  name="price"   value=""  hidden>
        <input type="text" id="qty"  name="qty"   value="1"  hidden>
        </div>
        <div class="row w-100 d-flex align-items-center justify-content-center  pb-4" style="padding-right:4rem;padding-left:4rem">
        <button type="submit" class="addBtn btn next w-100 " style="border:none;">Next</button>
        </div>   </form>
        </div>
            <!-- <a class="btn  next" st href="{{route('website.addresses.two')}}" role="button">Next</a> -->
       
    </div>
</div>

@endsection
@section('additional_scripts')
<script>
  $(document).ready(function() {


    $.ajax({
      url: '{{route('website.get.all.cars')}}',
      type: "get",
      data: {
        type: 1,
      },
      // processData: false,
      // contentType: false,
      success: function(data) {

        if (data.success == true) {
          $('.user_vichles').empty()

          var element = ``;
          for (var i = 0; i < data.data.length; i++) {

            element += `<div class="col-lg-5 col-md-12 carmarkone" >
            <div class="form-check">
                <input onclick="handleClick(` + data.data[i].id + `);"  class="form-check-input choose_car" type="radio" name="flexRadioDefaultthree" id="flexRadioDefaultone` + data.data[i].id + `" value="` + data.data[i].id + `" data-check="0">
                <label class="form-check-label check" for="flexRadioDefaultone` + data.data[i].id + `">
                    <img src="` + data.data[i].model_image + `">
                    <p class="cartype">` + data.data[i].manufacturer + ' ' + data.data[i].model + ` </p>
                    <p  class="carstyle">` + data.data[i].plate_num + `<br>` + data.data[i].color_name + `</p>
                </label>
            </div>
        </div>`
          }


          $('.user_vichles').append(element)
        } else {


        }


      },
    });

    $.get('{{ route("website.sub_category1")}}', {
      parent_id: 2
    }, function(response) {
      // Log the returned response to inspect its structure
      console.log("Returned response:", response);

      // Check if the response has the expected 'data' property
      if (response.data && Array.isArray(response.data)) {
        var htmlContent = '';

        response.data.forEach(function(category) {
          category.products.forEach(function(product) {
            htmlContent += `
          <div class="col-lg-6 col-md-12 pt-4">
            <div class="container country">
              <div class="form-check">
                <input onclick="handleClick12(`+product.product_id+`,`+product.products_price+`);" class="form-check-input flexRadioDefault" type="radio" name="productRadioGroup" id="product${product.product_id}">
                <label class="form-check-label check" for="product${product.product_id}">
                  ${product.product_name}
                </label>
              </div>
              <div class="d-flex align-content-end justify-content-end">
                <p class="available">${product.products_price} AED</p>
              </div>
            </div>
          </div>
        `;
          });
        });

        // Insert the HTML content into the div with ID 'bat'
        $('#bat').html(htmlContent);

      } else {
        console.error("Returned data is not an array:", response);
        $('#bat').html('<p>Invalid data format.</p>');
      }

    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
      // Handle AJAX request failure
      console.error("AJAX request failed: " + textStatus + ", " + errorThrown);
      $('#bat').html('<p>Failed to load products.</p>');
    });



  });
  $("#flexRadioDefault7").on("click", function() {
    if ($(".flexRadioDefault7").is(':checked')) {

      $('#flexRadioDefault8 ').removeAttr("disabled");
      $('#flexRadioDefault9 ').removeAttr("disabled");

    }

  });
  $("#flexRadioDefault4").on("click", function() {
    if ($("#flexRadioDefault4").is(":checked")) {

      $('#flexRadioDefault8').attr('disabled', true);
      $('#flexRadioDefault9 ').attr('disabled', true);
    }
  });

  $(document).on('click', '.type', function(event) {
    event.preventDefault();
    let id = $(this).data("id");

    if (id == 2) {
      $(".carcontainer").removeClass("activetype");
      $(".bikecontainer").addClass("activetype");

    } else if (id == 1) {
      $(".bikecontainer").removeClass("activetype");
      $(".carcontainer").addClass("activetype");
    }
    $.ajax({
      url: '{{route('website.get.all.cars')}}',
      type: "get",
      data: {
        type: id,
      },
      // processData: false,
      // contentType: false,
      success: function(data) {

        if (data.success == true) {
          $('.user_vichles').empty()

          var element = ``;
          for (var i = 0; i < data.data.length; i++) {

            element += `<div class="col-lg-5 col-md-12 carmarkone" >
            <div class="form-check">
                <input onclick="handleClick(` + data.data[i].id + `);"  class="form-check-input choose_car" type="radio" name="flexRadioDefaultthree" id="flexRadioDefaultone` + data.data[i].id + `" value="` + data.data[i].id + `" data-check="0">
                <label class="form-check-label check" for="flexRadioDefaultone` + data.data[i].id + `">
                    <img src="` + data.data[i].model_image + `">
                    <p class="cartype">` + data.data[i].manufacturer + ' ' + data.data[i].model + ` </p>
                    <p  class="carstyle">` + data.data[i].plate_num + `<br>` + data.data[i].color_name + `</p>
                </label>
            </div>
        </div>`
          }


          $('.user_vichles').append(element)
        } else {


        }


      },
    });
  });


  function handleClick(car_id) {
    $('#car_id').val(car_id)
    $('.size_input').val('');
    $('#size').val('')
    $('#manufacturer_id').val('')
    $('#product_id').val('')
    $('.amountbottom').text(0+`AED`)
    $('.amountbottom').attr('data-price', 0)
    $('#bathroom_id_m').val(1);
    $('#qty').val(1);
    $('#price').val(0)
    
 }
 
function handleClick12(product_id,price) {
//  alert(product_id);
 
    $('#product_id').val(product_id)
   
    $('#price').val(price)
   
}
 

</script>
@endsection