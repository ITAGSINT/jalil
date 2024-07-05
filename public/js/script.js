function clear_fun(input_id,canvase_id,plus_id,close_id){
    $('#'+input_id).val('');
 
    var canvas = document.getElementById(canvase_id);
   const context = canvas.getContext('2d');
 context.clearRect(0, 0, canvas.width, canvas.height);
     $('#'+plus_id).show();
     $('#'+close_id).hide();
 }

 
 function upload_fun(input_id,canvase_id,plus_id,close_id){
                           
    if(isVideo($("#"+input_id).val())){
    let file = document.getElementById(input_id).files[0];
    let blobURL = URL.createObjectURL(file);
  
    document.getElementById("video1").src = blobURL;    
           setTimeout(function(){
      var v = document.getElementById("video1");
  var c = document.getElementById(canvase_id);
  var ctx = c.getContext("2d");
  
  ctx.drawImage(v,0,0,c.width,c.height);
    } , 1000); 
     document.getElementById(plus_id).style.display="none";
     document.getElementById(close_id).style.display="block";
    }
    if(isImage($("#"+input_id).val())){
        var imgcanvas6 = document.getElementById(canvase_id);
  var fileinput6 = document.getElementById(input_id);
  var image6 = new SimpleImage(fileinput6);
  image6.drawTo(imgcanvas6);
  document.getElementById(plus_id).style.display="none";
   document.getElementById(close_id).style.display="block";
    }
 
}


