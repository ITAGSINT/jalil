@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/yes.css') }}" rel="stylesheet">
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
  <p class="toptext">Battery Change</p>
</div>





<div class="container">
  <div class="row w-100">
    <div class="col-lg-6 col-md-12" style="border-radius:2.25rem">
      <div class="row w-100 topone">
        <div class="col-12">
          <div class="row w-100 d-grid align-items-center justify-content-center">
            <div class="col-12">
              <img src="{{asset('image/Icon.png')}}">


            </div>


          </div>
          <div class="row w-100 d-grid align-items-start choosesize">
            <div class="col-12">
              <p>Choose The battery size</p>


            </div>


          </div>
          <div class="row w-100 mx-auto">
            <div class="col-7 p-1">
              <div id="one" class="tabcontent">
                <h1>10</h1>
              </div>

              <div id="two" class="tabcontent">
                <h1>15</h1>
              </div>

              <div id="three" class="tabcontent">
                <h1>20</h1>
              </div>

              <div id="four" class="tabcontent">
                <h1>25</h1>
              </div>

              <div id="five" class="tabcontent">
                <h1>30</h1>
              </div>

              <div id="six" class="tabcontent">
                <h1>35</h1>
              </div>

              <div id="seven" class="tabcontent">
                <h1>40</h1>
              </div>

              <div id="eight" class="tabcontent">
                <h1>45</h1>
              </div>

              <div id="nine" class="tabcontent">
                <h1>50</h1>
              </div>

              <div id="ten" class="tabcontent">
                <h1>55</h1>
              </div>

              <div id="eleven" class="tabcontent">
                <h1>60</h1>
              </div>

              <div id="twelve" class="tabcontent">
                <h1>65</h1>
              </div>

              <div id="thirteen" class="tabcontent">
                <h1>70</h1>
              </div>
            </div>
            <div class="col-3 p-1">
              <div class="ah">
                <h1>AH</h1>
              </div>
            </div>
            <div class="col-2 p-1">
              <div value="R" class="r tabcontentone" id="letterone">
                <h1>R</h1>
              </div>
              <div value="L" class="r tabcontentone" id="lettertwo">
                <h1>L</h1>
              </div>
            </div>
          </div>
        </div>
      </div>






      <div class="row w-100 toptwo pt-2 p-0">
        <div class="col-7">
          <div class="tab container d-grid align-items-center   cotainenumber pt-3 pb-3" style="overflow-y: scroll;height: 18rem;">
            <button class="tablink" value="10" onclick="openCity(event, 'one')" id="defaultOpen">10</button>
            <button class="tablink active" value="15" onclick="openCity(event, 'two')">15</button>
            <button class="tablink" value="20" onclick="openCity(event, 'three')">20</button>
            <button class="tablink" value="25" onclick="openCity(event, 'four')">25</button>
            <button class="tablink" value="30" onclick="openCity(event, 'five')">30</button>
            <button class="tablink" value="35" onclick="openCity(event, 'six')">35</button>
            <button class="tablink" value="40" onclick="openCity(event, 'seven')">40</button>
            <button class="tablink" value="45" onclick="openCity(event, 'eight')">45</button>
            <button class="tablink" value="50" onclick="openCity(event, 'nine')">50</button>
            <button class="tablink " value="55" onclick="openCity(event, 'ten')">55</button>
            <button class="tablink" value="60" onclick="openCity(event, 'eleven')">60</button>
            <button class="tablink" value="65" onclick="openCity(event, 'twelve')">65</button>
            <button class="tablink" value="70" onclick="openCity(event, 'thirteen')">70</button>
          </div>
        </div>
        <div class="col-4">
          <div class="container d-grid align-items-center   cotaineletter pt-3 pb-3">
            <button class="tablinkone" value="R" onclick="openLetter(event, 'letterone')" id="defaultOpenOne">R</button>
            <button class="tablinkone" value="L" onclick="openLetter(event, 'lettertwo')">L</button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-12" style="background-color: white; border-radius:2.25rem;padding: 1.5rem;">
      <div class="row w-100 pt-4">
        <div class="col-12">
          <p class="right">Choose the right battery for you !</p>
        </div>
        {{-- <div class="col-1">
                <a href="{{route('website.add',1)}}" class="btn d-flex align-items-center justify-content-center" style="width: 100%;background-color: #F8F9FA;">
        <i class="bi bi-plus" style="color: #9098A5; "></i>

        </i>
        </a>
      </div>--}}
        </div>


     <div class="row w-100" id="bat">

     </div>

    </div>

</div>
<!-- <div class="row w-100 d-flex align-items-center justify-content-center pt-5">
  <div class="col-4">
    <a class="btn next" href="{{route('website.addresses')}}" role="button">Next</a>
  </div>
</div> -->

<div class="container">
    <div  class="row w-100 d-flex align-items-center justify-content-center pt-5">
    <div class="col-5">
            <form method="POST" action="{{route('website.storeProductInSession')}}">
                @csrf
                <div class="col-lg-5 col-md-12 mt-3 mx-auto ">
                <input type="text" id="parent_id"  name="parent_id"  value="1"  hidden>
        <input type="text" id="car_id"  name="car_id"  value="1" hidden>
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

</div>
@endsection
@section('additional_scripts')
<script>
  $(document).ready(function() {

    const activeButton = document.querySelector('.tablink.active');

    // Get the value of the active button
    const value1 = activeButton ? activeButton.value : null;


    const activeButton1 = document.querySelector('.tablinkone.active');

    // Get the value of the active button
    const value2 = activeButton1 ? activeButton1.value : null;
    const concatenatedValue = value1 + value2;
    //alert(concatenatedValue);

    $.get('{{ route("website.sub_category1")}}', {
      parent_id: 1,
      size: concatenatedValue
    }, function(response) {
      // Log the returned response to inspect its structure
      console.log("Returned response:", response);

      // Check if the response has the expected 'data' property
      if (response.data && Array.isArray(response.data)) {
        var htmlContent = '';

        response.data.forEach(function(category) {
          var productsHtml = '';
          category.products.forEach(function(product) {
            productsHtml += `
                    <div class="form-check brand-radio my-3">
                        <input class="form-check-input check-location" type="radio" name="productRadioGroup${category.cat_id}" onclick="handleClick(`+product.product_id+`,`+product.products_price+`);" id="product${product.product_id}" data-price="`+product.products_price+`" >
                        <label class="form-check-label" for="product${product.product_id}">
                            ${product.product_name}
                        </label>
                    </div>
                `;
          });

          htmlContent += `
                <div class="col-lg-6 col-md-12 p-4">
                    <div class="container country">
                        <div class="form-check">
                            <input  class="form-check-input flexRadioDefault" type="radio" name="categoryRadioGroup" id="category${category.cat_id}">
                            <label class="form-check-label check" for="category${category.cat_id}">
                                ${category.name}
                            </label>
                        </div>
                        <p class="brand">Brands:</p>
                        <div style="overflow-y: scroll; height: 5rem;">
                            ${productsHtml}
                        </div>
                        <div class="d-flex align-content-end justify-content-end">
                            <p class="available">${category.price} AED</p>
                        </div>
                    </div>
                </div>
            `;
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





  function openCity(evt, cityName) {

    // Declare all variables
    var i, tabcontent, tablink;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablink = document.getElementsByClassName("tablink");
    for (i = 0; i < tablink.length; i++) {
      tablink[i].className = tablink[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
    const activeButton = document.querySelector('.tablink.active');

    // Get the value of the active button
    const value1 = activeButton ? activeButton.value : null;


    const activeButton1 = document.querySelector('.tablinkone.active');

    // Get the value of the active button
    const value2 = activeButton1 ? activeButton1.value : null;
    const concatenatedValue = value1 + value2;
    //alert(concatenatedValue);

    $.get('{{ route("website.sub_category1")}}', {
      parent_id: 1,
      size: concatenatedValue
    }, function(response) {
      // Log the returned response to inspect its structure
      console.log("Returned response:", response);

      // Check if the response has the expected 'data' property
      if (response.data && Array.isArray(response.data)) {
        var htmlContent = '';

        response.data.forEach(function(category) {
          var productsHtml = '';
          category.products.forEach(function(product) {
            productsHtml += `
                <div class="form-check brand-radio my-3">
                    <input class="form-check-input check-location" type="radio" name="productRadioGroup${category.cat_id}" onclick="handleClick(`+product.product_id+`,`+product.products_price+`);" id="product${product.product_id}" data-price="`+product.products_price+`"  >
                    <label class="form-check-label" for="product${product.product_id}">
                        ${product.product_name}
                    </label>
                </div>
            `;
          });

          htmlContent += `
            <div class="col-lg-6 col-md-12 p-4">
                <div class="container country">
                    <div class="form-check">
                        <input class="form-check-input flexRadioDefault" type="radio" name="categoryRadioGroup" id="category${category.cat_id}">
                        <label class="form-check-label check" for="category${category.cat_id}">
                            ${category.name}
                        </label>
                    </div>
                    <p class="brand">Brands:</p>
                    <div style="overflow-y: scroll; height: 5rem;">
                        ${productsHtml}
                    </div>
                    <div class="d-flex align-content-end justify-content-end">
                        <p class="available">${category.price} AED</p>
                    </div>
                </div>
            </div>
        `;
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
  }

  document.getElementById("defaultOpen").click();
</script>
<script>
  function openLetter(evt, letterName) {
    // Declare all variables
    var i, tabcontentone, tablinkone;

    // Get all elements with class="tabcontent" and hide them
    tabcontentone = document.getElementsByClassName("tabcontentone");
    for (i = 0; i < tabcontentone.length; i++) {
      tabcontentone[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinkone = document.getElementsByClassName("tablinkone");
    for (i = 0; i < tablinkone.length; i++) {
      tablinkone[i].className = tablinkone[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(letterName).style.display = "block";
    evt.currentTarget.className += " active";
    const activeButton = document.querySelector('.tablink.active');

    // Get the value of the active button
    const value1 = activeButton ? activeButton.value : null;


    const activeButton1 = document.querySelector('.tablinkone.active');

    // Get the value of the active button
    const value2 = activeButton1 ? activeButton1.value : null;
    const concatenatedValue = value1 + value2;
    //alert(concatenatedValue);

    $.get('{{ route("website.sub_category1")}}', {
      parent_id: 1,
      size: concatenatedValue
    }, function(response) {
      // Log the returned response to inspect its structure
      console.log("Returned response:", response);

      // Check if the response has the expected 'data' property
      if (response.data && Array.isArray(response.data)) {
        var htmlContent = '';

        response.data.forEach(function(category) {
          var productsHtml = '';
          category.products.forEach(function(product) {
            productsHtml += `
                <div class="form-check brand-radio my-3">
                    <input class="form-check-input check-location" type="radio" name="productRadioGroup${category.cat_id}" onclick="handleClick(`+product.product_id+`,`+product.products_price+`);" data-price="`+product.products_price+`"  id="product${product.product_id}">
                    <label class="form-check-label" for="product${product.product_id}">
                        ${product.product_name}
                    </label>
                </div>
            `;
          });

          htmlContent += `
            <div class="col-lg-6 col-md-12 p-4">
                <div class="container country">
                    <div class="form-check">
                        <input class="form-check-input flexRadioDefault" type="radio" name="categoryRadioGroup" id="category${category.cat_id}">
                        <label class="form-check-label check" for="category${category.cat_id}">
                            ${category.name}
                        </label>
                    </div>
                    <p class="brand">Brands:</p>
                    <div style="overflow-y: scroll; height: 5rem;">
                        ${productsHtml}
                    </div>
                    <div class="d-flex align-content-end justify-content-end">
                        <p class="available">${category.price} AED</p>
                    </div>
                </div>
            </div>
        `;
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
  }

  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpenOne").click();

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


  function handleClick(product_id,price) {
 //alert(product_id);
   // $('#car_id').val()
    $('.size_input').val('');
    $('#size').val('')
    $('#manufacturer_id').val('')
    $('#product_id').val(product_id)
    $('.amountbottom').text(0+`AED`)
    //$('.amountbottom').attr('data-price', 0)
    $('#bathroom_id_m').val(1);
   // $('#qty').val(1);
    $('#price').val(price)
    // product_manufacturer();
    // get_product();
   
}
</script>
@endsection