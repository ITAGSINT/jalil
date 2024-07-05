@extends('layouts.Dashboard.main')
@section('content')
<div class="content-wrapper  tab-one "  >
       
           
    <form>
        <div class="row" style="margin-bottom: 1em;">
        
                    <div class="col-12">
                        <div class="card" style="background-color: white;">
                            
                           
                            <div class="card-body">
                            
                            
                            <label >النوع</label>
                            <select class="custom-select" name="cars" id="cars"  style="margin-bottom: 2em;">
                                <option value="volvo">internal</option>
                                <option value="saab">external</option>
                                
                                <option value="audi">...</option>
                            </select><br>
                                
                            <label >الحالة</label>
                            <select class="custom-select" name="cars" id="cars"  style="margin-bottom: 2em;">
                                <option value="volvo">inactive</option>
                                <option value="saab">active</option>
                                
                            </select><br>

                            

                                <label >الفئة</label>
                                <select class="custom-select" name="cars" id="cars"  style="margin-bottom: 2em;">
                                <option value="volvo">mobiles</option>
                                <option value="saab">laptops</option>
                                <option value="mercedes">accessories</option>
                                <option value="audi">...</option>
                                </select><br>
                            </div>
                            
                            
                            
                        </div>
                    </div>
    
        </div>

        <div class="row" >
            
            <div class="col-12 grid-margin">
            <div class="card" style="background-color: white;">
            <div class="card-body">
                
                    <label for="lname">الوزن</label>
                    <input type="number" id="lname" name="lname">


                
                <div style="margin-top:20px;">
                    <label for="myfile">  صورة المنتج</label>
                    <input type="file" id="myfile" name="myfile" style="margin-bottom: 2em;"><br>
                </div>

                <label for="myfile">فيديو للمنتج</label>
                <input type="file" id="myfile" name="myfile" style="margin-bottom: 2em;"><br>

            </div>
            </div>
            </div>

        </div>

        <div class="row" >
            
            <div class="col-12 grid-margin">
            <div class="card" style="background-color: white;">
            <div class="card-body">
                
                <label for="fname">السعر</label>
                <input type="number" id="fname" name="fname">
                <label for="lname">الكمية</label>
                <input type="number" id="lname" name="lname">

            </div>
            </div>
            </div>

        </div>

        <div class="row">
        
            <div class="col-12">
                <div class="card" style="background-color: white;">
                    <div class="card-body">
                    
                    
                        <label > اسم المنتج</label>
                        <input type="text" style="margin-bottom: 2em;"><br>

                        <label > رابط </label>
                        <input type="text" style="margin-bottom: 2em;"><br>

                        <label for="user_name">الوصف  </label>
                            
                        <textarea name="editor2"></textarea>
                        <script>
                                CKEDITOR.replace( 'editor2' );
                        </script>


                    <div style="margin:2em 0">
                         <button type="submit" class="btn btn-warning btn-fw " >تعديل  </button>
                       
                    </div>

                    </div>
                </div>
            </div>

        </div>

    </form>
        
   </div>

  @endsection
  @section('additional_scripts')
  <script>
   $(function() {
        
        $('#add-client-btn').click(function(){
            $('.add-client').slideDown(800);
            });
            $('#exit-client-btn').click(function(){
                $('.add-client').slideUp(800);
            });

        
      });
  </script>
<script language="javascript" type="text/javascript">
     
    tinyMCE.init({
      theme : "advanced",
      mode: "exact",
      elements : "elm1",
      theme_advanced_toolbar_location : "top",
      theme_advanced_buttons1 : "bold,italic,underline,strikethrough,separator,"
      + "justifyleft,justifycenter,justifyright,justifyfull,formatselect,"
      + "bullist,numlist,outdent,indent",
      theme_advanced_buttons2 : "link,unlink,anchor,image,separator,"
      +"undo,redo,cleanup,code,separator,sub,sup,charmap",
      theme_advanced_buttons3 : "",
      height:"350px",
      width:"600px"
  });

</script>


  @endsection