
$(document).on('click',".myli",function (event) {
  event.preventDefault();
    if ($(this).hasClass('active')) {
      $(".myli").removeClass('active');
  }
  else {
  $(".myli").removeClass('active');
    $(this).addClass('active');
  }
  });
      $(document).on('click',".range",function (event) {
        event.preventDefault();
          if ($(this).hasClass('active')) {
            $(".range").removeClass('active');
            
        }
        else {
        $(".range").removeClass('active');
          $(this).addClass('active');
        }
         });
         $(function(){
          //WHEN YOU CLICK THE ELEMENT..
          $(document).on('click',".myli",function (event){
          //GET THE TEXT INSIDE THAT SPECIFIC LI
          var content= $(this).text();
         $('#myInputone').css("display","block")
          //PLACE THE TEXT INSIDE THE INPUT FIELD, YOU CAN CHANGE YOUR SELECTOR TO TARGET THE RIGHT INPUT
          $('input[class="myInputone"]').val(content);
          //HERE YOU CAN DO SOMETHING ELSE LIKE SIBMITING THE FORM, OR CLICK A BUTTON.. OR SOMETHING ELSE
          $('#manfname').val(content)
            });
          });
          $(function(){
           //WHEN YOU CLICK THE ELEMENT..
           $(document).on('click',".range",function (event){
           //GET THE TEXT INSIDE THAT SPECIFIC LI
           var content= $(this).text();
          $('#myInputtwo').css("display","block")
           //PLACE THE TEXT INSIDE THE INPUT FIELD, YOU CAN CHANGE YOUR SELECTOR TO TARGET THE RIGHT INPUT
           $('input[class="myInputtwo"]').val(content);
           $('#modelname').val(content)
           //HERE YOU CAN DO SOMETHING ELSE LIKE SIBMITING THE FORM, OR CLICK A BUTTON.. OR SOMETHING ELSE
             });
           });
         
      