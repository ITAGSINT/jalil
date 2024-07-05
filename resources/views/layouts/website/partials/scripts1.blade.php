
<!-- Start Script -->


<!-- sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{asset('assets/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/templatemo.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="{{asset('assets/js/blowup.min.js')}}"></script>
      <script src="{{asset('assets/js/jquery.magnify.js')}}"></script>
     <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js') }}"></script>
    
    
     <!-- Google Map -->
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
       <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
        $("#categories_id").click(function(){
            
            $("#cat_0").slideToggle();
            $(this).find($(".fa")).toggleClass('fa-angle-right').toggleClass('fa-angle-down');
          });
         if( {{$user_id_Cookie}} != null){
       $.get('{{ route("view.cart.website")}}',{user_id: {{$user_id_Cookie}}},function(data){
              
       var div_con="";
            if(data.length != 0)
                { 
                    div_con +=   '<a class="nav-icon position-relative text-decoration-none" href="/bag">'
                           +' <img  style="width: 21px;"  src="/assets/img/bag icon.png">'
                          +' <div class="cart_div show" >'+data.length +'</div>'
                       +' </a>';
                }
                else{
                    div_con +=   '<a class="nav-icon position-relative text-decoration-none" href="/empty-bag">'
                           +' <img  style="width: 21px;"  src="/assets/img/bag icon.png">'
                       +' </a>';
                }
                $('#cart_div_id').html(div_con);
            },'json');
         }
         function toggle_fun(id){
               $("#a_id_"+id).find($(".fa")).toggleClass('fa-angle-right').toggleClass('fa-angle-down');
              $("#cat_"+id).slideToggle();
              
              
         }
            $.get('<?= route("website.categoriers_menue")?>',function(data1){
                var sub1= "";
                for (var i1 = 0; i1 < data1.length; i1++) {
                    sub1 += "<a style='padding: 8px 8px 8px 50px;' id='a_id_"+data1[i1].categories_id+"' onclick='toggle_fun("+data1[i1].categories_id+")'>"+data1[i1].categories_name+" <i class='fa fa-angle-right menu-anngle'></i><div style='display:none' id='cat_"+data1[i1].categories_id+"'></div></a>";
                    
                                      }
                
                $('#cat_0').html(sub1);
                $.get('<?= route("website.categoriers_sub_menue")?>',function(data){
                var sub="";
                 for (var i = 0; i < data.length; i++) {

                    sub = "<a  href='/categories/"+data[i].categories_id+"'>"+data[i].categories_name+" <div id='cat_"+data[i].categories_id+"'></div></a>";
                     $('#cat_'+data[i].parent_id).append(sub);
                  }
                
               
            },'json');
               
            },'json');
            
    $(document).mouseup(function (e) {
            var container1 = $(".menu");
            var container = $(".sidenav");
            if(!container.is(e.target) && container1.has(e.target).length === 0) {
                container.width('0');
              
            }
        });
            
           
            
            
            
       
            
</script>
       <script>
  AOS.init();
</script>
@yield('additional_scripts')
<script>
  toastr.options.preventDuplicates=true;
        toastr.options.rtl = true;
        toastr.options.showEasing = 'swing';
        toastr.options.hideEasing = 'linear';
        toastr.options.closeEasing = 'linear';
        toastr.options.closeDuration = 300;
         
       function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
    
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
   
}




//* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}


function star_fun(){
    var star="";
   var starr= document.getElementById('swal-input2').value;
    if(starr==1){
    star+='<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i>';
    }if(starr==2){
    star+='<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i>';
    }if(starr==3){    
    star+='<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i>';
    }if(starr==4){
    star+='<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i>';
    }if(starr==5){
    star+='<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i>';
    }
    $('#stars_id').html(star);}               
function rating_fun(rate,product_id){
    var id=product_id;
    var star=""
    var htmlcode='<form id="rate-form" method="post"  >'+
    '<input name="_token" type="hidden" value="{{ csrf_token() }}"/>'+
    '<div class="row">'+
    ' <div class="rate1" id="stars_id"></div>'+
    '<div class="col-4"><lable>Your name</lable></div><div class="col-8"><input id="swal-input1" class="swal2-input" name="name" required ></div>' +
     '<span class="error-text name_error" ></span>'+
    '<div class="col-4"><lable>Your rating</lable></div><div class="col-8"><select required  id="swal-input2" class="swal2-input" onchange="star_fun()" name="rate"></div>';
    if(rate==1){
    star+='<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i>';
    htmlcode+='<option value="1" selected>1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>';
    }if(rate==2){
    star+='<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i>';
    htmlcode+='<option value="1">1</option><option value="2" selected>2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>';
    }if(rate==3){    
    star+='<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i>';
    htmlcode+='<option value="1">1</option><option value="2" >2</option><option value="3" selected>3</option><option value="4">4</option><option value="5">5</option>';
    }if(rate==4){
    star+='<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i>';
    htmlcode+='<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4" selected>4</option><option value="5">5</option>';
    }if(rate==5){
    star+='<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i>';
    htmlcode+='<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5" selected>5</option>';
    }
    htmlcode+='</select></div>'+
    '<div class="col-4"><lable>Your review</lable></div><div class="col-8"><textarea required id="swal-input3" class="swal2-textarea" name="review" ></textarea></div>'+
    '</div>     </form>';
    
(async () => {

  await Swal.fire({
  title: 'Rating & Reviews',
  html: htmlcode,
  focusConfirm: false,
     
  preConfirm: () => {
    return [
      document.getElementById('swal-input1').value,
      document.getElementById('swal-input2').value,
      document.getElementById('swal-input3').value
      ]

  }
}).then((result) => {
  if (result.isConfirmed) {
      var name =document.getElementById('swal-input1').value;
     var rate =  document.getElementById('swal-input2').value;
     var review = document.getElementById('swal-input3').value;
     

                     $.post('<?= route("rating")?>',{name:name,rate:rate,review:review,id:id,_token: "{{ csrf_token() }}"},function(data){
                          
                         
                           if(data.code == 0){
                                
                
               toastr.warning(data.error);
            }else{
              // console.log(data)
                toastr.success(data.msg);
               location.reload();
                    
            }
                    },'json');
   /*  Swal.fire(
      'Thank you!',
      '<p style="    text-align: center !important;font-size: 14px !important;">we appreciate your rating</p>',
      'success'
    )*/
  // For more information about handling dismissals please visit
  // https://sweetalert2.github.io/#handling-dismissals
  }  
})
/*
if (formValues) {
  //Swal.fire(JSON.stringify(formValues))
 $('#rate-form').submit();
 
}*/

})()
$('#stars_id').html(star);
}
   </script>