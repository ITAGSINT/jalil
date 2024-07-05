@extends('layouts.website.main')
@section('additional_styles')
<link href="{{ URL::asset('css/no.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/change.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/tyre.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/yes.css') }}" rel="stylesheet">
<style>
  .containtyre.active {
    background-color: #16330014;
    color: #163300;
}
  .containtyremobile.active {
    background-color: #16330014;
    color: #163300;
  }
</style>
@endsection
@section('content')

<div class="container" >
        <p class="toptext">Tire Change 
</p>
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
          <a href="{{route('website.add',3)}}" class="btn d-flex align-items-center justify-content-center" style="width: 100%;background-color: #F8F9FA;">
            <i class="bi bi-plus" style="color: #9098A5; "></i>
               
            </i>
          </a>
        </div>
       </div>
       <div class="row w-100 d-flex align-items-center py-3">
        <div class="col">
          <a href="" style="text-decoration: none;cursor: pointer;" class="type" data-id="1">
          <div class="d-flex carcontainer align-items-center justify-content-center ">
           <img src="{{asset('image/car.png')}}">
           <p>Car</p>
          </div></a>
        </div>
        <div class="col"><a href="" style="text-decoration: none;cursor: pointer;" class="type" data-id="2">
          <div class="d-flex bikecontainer align-items-center justify-content-center">
            
           <img src="{{asset('image/ri_motorbike-fill.png')}}">
           <p>Bike</p>
          </div></a>
        </div>
       </div> 
       <div class="row w-100  align-items-center justify-content-center  h-75 user_vichles" style="  min-height: 20rem;  overflow-y: scroll; max-height: 20rem;">
        
      
       </div>
        
    </div>
    <div class="col-lg-6 col-md-12 mx-auto mt-3" style="background-color: white; border-radius:2.25rem;">
      <div class="row w-100 pt-4">
       <div class="col-12">
         <p class="tyre">Enter tyre details</p>
       </div>
      
      </div>  
    
  
   <div class="row w-100 ">
    <div class="col-6">
        <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label enter">Enter your tyre size</label>
            <input type="text" class="form-control size_input" id="formGroupExampleInput " placeholder="225 / 55 R 17">
          </div>
            
        </div>
    
    <div class="col-6">
      <div class="w-100 h-100" style="background-image: url({{asset('image/Block.png')}});background-size:100%;background-repeat: no-repeat;"></div>
   </div>
</div>
<div class="row w-100">
<div class=" col-12">
    <div class="topnav product_manufacturer">
       {{-- <a  href="#">All</a>
        <a class="active" href="#">Maxxis</a>
        <a href="#">Bridgestone</a>
        <a href="#">Falken</a>
        <a href="#">Goodyear</a>
        <a href="#">Goodyear</a>
        <a href="#">Goodyear</a>
        <a href="#">Goodyear</a>--}}
      </div>
</div>
</div>
<div class="row w-100 pt-3 for-lap products" >
   
</div>

<div class="row for-mobile py-2 products2">
    
</div>



     </div>
</div>
</div>
<div class="container">
<div class="row w-100 d-flex align-items-end justify-content-end pt-5 ">
  <div class="col-lg-5 col-md-12  mx-auto"></div>
  <div class="col-lg-6 col-md-12  mx-auto"  style="background-color: white; border-radius:2.25rem;">
    <div class="row w-100">
      <div class="col-lg-3 col-md-12 mx-auto">
   
    <div class="form-group">
        <label class="control-label"></label>
        <input class="numberstyle form-control"  id="bathroom_id_m" name="bathroom_id_m" type="number" min="1" step="1" value="1">
      </div></div>
      <div class="col-lg-3 col-md-12 amount p-0 pt-3 mx-auto ">
        <p class="amounttop mx-2">Total Amount</p>
        <p class="amountbottom" data-price="0">0 AED</p>
      </div>
  <!-- <div class="col-lg-5 col-md-12 mt-3 nextcontainer mx-auto">
  <form method="POST" >
        @csrf
        <input type="text" id="parent_id"  name="parent_id"  value="3"  hidden>
        <input type="text" id="car_id"  name="car_id"  value="" hidden>
        <input type="text" id="size"  name="size"   value="" hidden>
        <input type="text" id="manufacturer_id"  name="manufacturer_id"   value="" hidden >
        <input type="text" id="product_id"  name="product_id"   value="" hidden >
        <input type="text" id="price"  name="price"   value=""  hidden>
        <input type="text" id="qty"  name="qty"   value=""  hidden>
        <button type="submit" class="addBtn" style="border:none;background:transparent">Next</button>
        
     
      </form>
   {{-- <a class="btn " href="{{route('website.addresses.two')}}" role="button">Next</a>--}}
  </div> -->
  <div class="container">
    <div class="row">
      
            <form method="POST" action="{{route('website.storeProductInSession')}}">
                @csrf
                <div class="col-lg-5 col-md-12 mt-3 mx-auto ">
                <input type="text" id="parent_id"  name="parent_id"  value="3"  hidden>
        <input type="text" id="car_id"  name="car_id"  value="" hidden>
        <input type="text" id="size"  name="size"   value="" hidden>
        <input type="text" id="manufacturer_id"  name="manufacturer_id"   value="" hidden >
        <input type="text" id="product_id"  name="product_id"   value="" hidden >
        <input type="text" id="price"  name="price"   value=""  hidden>
        <input type="text" id="qty"  name="qty"   value=""  hidden>
        </div>
        <div class="row w-100 d-flex align-items-center justify-content-center  pb-4" style="padding-right:4rem;padding-left:4rem">
        <button type="submit" class="addBtn btn next w-100 " style="border:none;">Next</button>
        </div>   </form>
         
            <!-- <a class="btn  next" st href="{{route('website.addresses.two')}}" role="button">Next</a> -->
       
    </div>
</div>
</div>
  </div>
</div>
</div>
@endsection
@section('additional_scripts')
<script>
  $(document).ready(function() {
    product_manufacturer()
  });
  $(document).on('click','.manufacturer_element',function (event) {
     event.preventDefault();
     let id = $(this).data("id");
     $(".manufacturer_element").removeClass("active");
     $(this).addClass("active");
     
     if(id==0)
     $('#manufacturer_id').val("")
    else 
    $('#manufacturer_id').val(id)
    get_product();
     
  });
  $(document).on('click','.type',function (event) {
    event.preventDefault();
     let id = $(this).data("id");
    
     if(id==2)  {
        $(".carcontainer").removeClass("activetype");
        $(".bikecontainer").addClass("activetype");
        
     }
     else if(id==1)  {
      $(".bikecontainer").removeClass("activetype");
      $(".carcontainer").addClass("activetype");
     }
     $.ajax({
        url:'{{ route('website.get.all.cars') }}',
        type: "get",
        data:{type:id,},
        // processData: false,
        // contentType: false,
        success: function (data) {
          
         if(data.success==true){
          $('.user_vichles').empty()
          
           var element=``;
           for(var i=0;i<data.data.length;i++) {
            
            element+=`<div class="col-lg-5 col-md-12 carmarkone" >
            <div class="form-check">
                <input onclick="handleClick(`+data.data[i].id+`);"  class="form-check-input choose_car" type="radio" name="flexRadioDefaultthree" id="flexRadioDefaultone`+data.data[i].id+`" value="`+data.data[i].id+`" data-check="0">
                <label class="form-check-label check" for="flexRadioDefaultone`+data.data[i].id+`">
                    <img src="`+data.data[i].model_image+`">
                    <p class="cartype">`+data.data[i].manufacturer+' '+data.data[i].model+` </p>
                    <p  class="carstyle">`+data.data[i].plate_num+`<br>`+data.data[i].color_name+`</p>
                </label>
            </div>
        </div>`
           }
           
           
           $('.user_vichles').append(element)
         }
         else {
             
             
         }
     
        
      },
    });
    });
</script>  
<script src="{{URL::asset('js/tyre.js')}}"></script>
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



});
$(document).on('change','.size_input',function(event) {
  content=$(this).val();
  $('#size').val(content)
  get_product();
});
function handleClick(myRadio) {
    $('#car_id').val(myRadio)
    $('.size_input').val('');
    $('#size').val('')
    $('#manufacturer_id').val('')
    $('#product_id').val('')
    $('.amountbottom').text(0+`AED`)
    $('.amountbottom').attr('data-price', 0)
    $('#bathroom_id_m').val(1);
    $('#qty').val(1);
    $('#price').val(0)
    product_manufacturer();
    get_product();
   
}
function get_product() {
  var parent_id=$('#parent_id').val();
  var size=$('#size').val();
  var manufacturer_id=$('#manufacturer_id').val();
  var car_id=$('#car_id').val();
  
  $.ajax({
        url:'{{ route('website.sub_category') }}',
        type: "get",
        data:{parent_id:parent_id,size:size,manufacturer_id:manufacturer_id,car_id:car_id,},
        // processData: false,
        // contentType: false,
        success: function (data) {
         
          
          var element=``;
          var element2=``;
          $('.products').empty();
          $('.products2').empty();
          for(var i=0;i<data.data.length;i++) {
            
            for(var j=0;j<data.data[i].products.length;j++) {
              
    //           element+=`<div class="col-lg-6 col-md-12 ">
    //     <div class="card mb-3  containtyre " id="containtyre`+data.data[i].products[j].id+`" style="cursor:pointer;" data-id="`+data.data[i].products[j].id+`" data-price="`+data.data[i].products[j].products_price+`">
    //         <div class="row g-0">
    //           <div class="col-md-3 g-4">
    //             <img src="`+data.data[i].products[j].main_image+`" class="rounded-start" alt="..." >
    //           </div>
    //           <div class="col-md-9 g-2">
    //             <div class="card-body">
    //               <h5 class="card-title maxxis">`+data.data[i].products[j].product_name+`</h5>
    //               <p class="card-text double">`+data.data[i].products[j].size+`<br> `+data.data[i].products[j].description+`</p>
    //               <p class="card-text small"><small class="text-body-secondary">`+data.data[i].products[j].products_price+` AED</small></p>
    //             </div>
    //           </div>
    //         </div>
    //       </div>
    // </div>`
    
    element+=`

    <!-- First Item -->
    <div class="col-lg-6 col-md-6 mb-3">
      <div class="card containtyre" id="containtyre`+data.data[i].products[j].id+`" style="cursor:pointer;" data-id="`+data.data[i].products[j].id+`" data-price="`+data.data[i].products[j].products_price+`">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="`+data.data[i].products[j].main_image+`" class="img-fluid rounded-start" alt="...">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title maxxis">`+data.data[i].products[j].product_name+`</h5>
              <p class="card-text double">`+data.data[i].products[j].size+`<br>`+data.data[i].products[j].description+`</p>
              <p class="card-text small"><small class="text-muted">`+data.data[i].products[j].products_price+` AED</small></p>
            </div>
          </div>
        </div>
      </div>
    </div>`
    element2+=`<div class="col-12">
        <div class="card containtyremobile" id="containtyremobile`+data.data[i].products[j].id+`" style="cursor:pointer;" data-id="`+data.data[i].products[j].id+`" data-price="`+data.data[i].products[j].products_price+`">
            <img src="`+data.data[i].products[j].main_image+`" class="card-img-top mx-auto" alt="...">
            <div class="card-body">
              <h5 class="card-title maxxis">`+data.data[i].products[j].product_name+`</h5>
              <p class="card-text double">`+data.data[i].products[j].size+` <br>`+data.data[i].products[j].description+`</p>
              <p class="card-text small"><small class="text-body-secondary">`+data.data[i].products[j].products_price+` AED</small></p>
            </div>
          </div>
    </div>`
            
            
           }
           
           
           $('.products').append(element)
           $('.products2').append(element2)
         }
        
     
        
      },
    });
}
function product_manufacturer() {
  $.ajax({
        url:'{{ route('api.product.manufacturer') }}',
        type: "get",
        data:{'category_id':3},
        // processData: false,
        // contentType: false,
        success: function (data) {
          
         if(data.success==true){
          $('.product_manufacturer').empty()
          
           var element=`<a  href="#" class="active manufacturer_element" data-id="0">All</a>`;
           for(var i=0;i<data.data.length;i++) {
            
            element+=`<a  href="#" class="manufacturer_element" data-id=`+data.data[i].id+`>`+data.data[i].name+`</a>`
           }
           
           
           $('.product_manufacturer').append(element)
         }
         else {
             
             
         }
     
        
      },
    });
}
$(document).on('click','.containtyre',function(event) {
    event.preventDefault();
     let id = $(this).data("id");
     $('#product_id').val(id)
     let price=$(this).data("price");
     $('.amountbottom').text(price+`AED`)
     $('.amountbottom').attr('data-price', price)
     $('#bathroom_id_m').val(1);
     $('#qty').val(1);
     $('#price').val(price)
     let mobile='#containtyremobile'+id
        $(".containtyre").removeClass("active");
        $(this).addClass("active");
        $(".containtyremobile").removeClass("active");
        $(mobile).addClass("active");
})
$(document).on('click','.containtyremobile',function(event) {
    event.preventDefault();
     let id = $(this).data("id");
     $('#product_id').val(id)
     let lap='#containtyre'+id
     let price=$(this).data("price");
     $('.amountbottom').text(price+`AED`)
     $('.amountbottom').attr('data-price', price)
     $('#price').val(price)
     $('#bathroom_id_m').val(1);
     $('#qty').val(1);
        $(".containtyremobile").removeClass("active");
        $(this).addClass("active");
        $(".containtyre").removeClass("active");
        $(lap).addClass("active");
})
$(document).on('change','#bathroom_id_m',function() {
  var qty=$('#bathroom_id_m').val();
  $('#qty').val(qty);
  var price=$('.amountbottom').attr('data-price');
  var final=qty*price;
  $('.amountbottom').text(final+`AED`)
  $('#price').val(final)
})
</script>
@endsection