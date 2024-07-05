function filter_function(r,category,products_id,m_image,products_name,products_description,products_price,like1,arr_length,c){
 var sub="";   
if((c%2)==0){
         //data1[i1].like1+'-->'+r+'--->'+ data1[i1].category[0].description[0]['categories_name']+"--->"+m_image+"--->"+products_id+"--->"+data1[i1].categories_id+"--->"+products_price+"--->"+products_name+" <br>";

           sub +='<div class="col-6  sec-two">'+
            '<div class="row  flip">'+
                '<div class="col-md-6">'+
                 
                   `<a  href="/product?id=`+products_id+`">`+
                    
                        '<img src="'+m_image+'">'+
                    '</a>'+
                '</div>'+
               '<div class="col-md-6 text">'+
                    '<span>   '+
                   '<h2>'+products_name+'</h2>'+
                    '<p>'+products_description+'</p>'+
                    
                    ' <div class="rate"><span>'+products_price+'<span class="currency_span">AED</span></span> ';
                   if(r==0){
                    sub += `<i class="fa  fa-star hide_element "  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                   }
                  
                    if(r==1){
                    sub += `<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)" ></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    
                    if(r==2){
                   sub += ` <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)" ></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r==3){
                   sub += ` <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                     }
                    if(r==4){
                    sub += `<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r==5){
                    sub += `<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>0 &&  r<1){
                     sub +=`<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                      <i class="fa  fa-star-half hide_element  fill_star "  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>1 &&  r<2){
                     sub +=`<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star-half hide_element  fill_star "  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>2 &&  r<3){
                     sub +=`<i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element" onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element" onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>3 &&  r<4){
                    sub += `<i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element " onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element" onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>4 &&  r<5){
                    sub += `<i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(5,`+products_id+`)"></i>
                    <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    sub+= '</div>'+
                    '<div class="price">';
                      if(like1==0) {    
                      sub+=`<form method="POST" action="{{ route('add.to.like') }}" >`+
                        ' @csrf'+
                        '<input type="hidden" name="product_id" value="'+products_id+'" >'+
                         '<button type="submit" style="    background: white;border: 0px;display: flex;">'+
                           '<i class="fa fa-heart-o " style="font-size: 25px;margin-top: -4px;color: #7e7c7d;"></i>'+
                           '<p>Add to favorites   </p>'+
                         '</button>'+
                        '</form>';}
                        if(like1==1) { 
                         sub+=`<form method="POST" action="{{ route('destroy.like') }}" >`+
                         '@csrf'+
                        '<input type="hidden" name="product_id" value="'+products_id+'" >'+
                         '<button type="submit" style="    background: white;border: 0px;display: flex;">'+
                            '<i class="fa fa-heart " style="font-size: 25px;margin-top: -4px;color: red"></i>'+
                            '<p>Is favorite  </p>'+
                        '</button>'+
                        '</form>';}
                   sub+= '</div>'+
                    
                   '</span>'+
               ' </div>'+
           ' </div>'+
           
       ' </div>';
                

            }
            else{
                if(c==arr_length){
                
                    sub +='<div class="col-md-6  sec-one" >'+
                          '</div>'+
                          '<div class="col-6  sec-two alone">'+
                          '<div class="row  flip">'+
                                '<div class="col-md-6">'+
                                 `<a  href="/product?id=`+products_id+`">`+
                                       '<img src="'+m_image+'">'+
                                '</a>'+
                                '</div>'+
                            '<div class="col-md-6 text">'+
                                '<span>  '+ 
                                '<h2>'+products_name+'</h2>'+
                                '<p>'+products_description+'</p>'+
                                ' <div class="rate"><span>'+products_price+'<span class="currency_span">AED</span></span> ';
                     if(r==0){
                    sub += `<i class="fa  fa-star hide_element "  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                   }
                  
                    if(r==1){
                    sub += `<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)" ></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    
                    if(r==2){
                   sub += ` <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)" ></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r==3){
                   sub += ` <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                     }
                    if(r==4){
                    sub += `<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r==5){
                    sub += `<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>0 &&  r<1){
                     sub +=`<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                      <i class="fa  fa-star-half hide_element  fill_star "  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>1 &&  r<2){
                     sub +=`<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star-half hide_element  fill_star "  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>2 &&  r<3){
                     sub +=`<i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element" onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element" onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>3 &&  r<4){
                    sub += `<i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element " onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element" onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>4 &&  r<5){
                    sub += `<i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(5,`+products_id+`)"></i>
                    <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                                sub+=' </div>'+
                                '<div class="price">';
                                  if(like1==0) {    
                      sub+=`<form method="POST" action="{{ route('add.to.like') }}" >`+
                        ' @csrf'+
                        '<input type="hidden" name="product_id" value="'+products_id+'" >'+
                         '<button type="submit" style="    background: white;border: 0px;display: flex;">'+
                           '<i class="fa fa-heart-o " style="font-size: 25px;margin-top: -4px;color: #7e7c7d;"></i>'+
                           '<p>Add to favorites   </p>'+
                         '</button>'+
                        '</form>';}
                        if(like1==1) { 
                         sub+=`<form method="POST" action="{{ route('destroy.like') }}" >`+
                         '@csrf'+
                        '<input type="hidden" name="product_id" value="'+products_id+'" >'+
                         '<button type="submit" style="    background: white;border: 0px;display: flex;">'+
                            '<i class="fa fa-heart " style="font-size: 25px;margin-top: -4px;color: red"></i>'+
                            '<p>Is favorite  </p>'+
                        '</button>'+
                        '</form>';}
                                    
                           sub+= '</div>'+
                            
                           '</span>'+
                        '</div>'+
                    '</div>'+
                   
                '</div>';
        
       }
                else{                  
  sub +='<div class="col-6  sec-one">'+
            '<div class="row" >'+
               ' <div class="col-md-6 text">'+
                   
                    '<span>'+
                    '<h2>'+products_name+'</h2>'+
                    '<p>'+products_description+'</p>'+
                    
                   
                     '<div class="rate">';
        if(r==0){
                    sub += `<i class="fa  fa-star hide_element "  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                   }
                  
                    if(r==1){
                    sub += `<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)" ></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    
                    if(r==2){
                   sub += ` <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)" ></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r==3){
                   sub += ` <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                     }
                    if(r==4){
                    sub += `<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r==5){
                    sub += `<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>0 &&  r<1){
                     sub +=`<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                      <i class="fa  fa-star-half hide_element  fill_star "  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>1 &&  r<2){
                     sub +=`<i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star"  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star-half hide_element  fill_star "  onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element "  onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element"  onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>2 &&  r<3){
                     sub +=`<i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element" onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element" onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>3 &&  r<4){
                    sub += `<i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element " onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element" onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                    if(r>4 &&  r<5){
                    sub += `<i class="fa  fa-star hide_element fill_star" onclick="rating_fun(1,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(2,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(3,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(4,`+products_id+`)"></i>
                    <i class="fa  fa-star hide_element fill_star" onclick="rating_fun(5,`+products_id+`)"></i>
                    <i class="fa  fa-star-half hide_element  fill_star " onclick="rating_fun(5,`+products_id+`)"></i>`;
                    }
                   sub+= ' <span>'+products_price+'<span class="currency_span">AED</span></span> </div>'+
                   
                    '<div class="price">';
                     if(like1==0) {    
                      sub+=`<form method="POST" action="{{ route('add.to.like') }}" >`+
                        ' @csrf'+
                        '<input type="hidden" name="product_id" value="'+products_id+'" >'+
                         '<button type="submit" style="    background: white;border: 0px;display: flex;">'+
                           '<i class="fa fa-heart-o " style="font-size: 25px;margin-top: -4px;color: #7e7c7d;"></i>'+
                           '<p>Add to favorites   </p>'+
                         '</button>'+
                        '</form>';}
                        if(like1==1) { 
                         sub+=`<form method="POST" action="{{ route('destroy.like') }}" >`+
                         '@csrf'+
                        '<input type="hidden" name="product_id" value="'+products_id+'" >'+
                         '<button type="submit" style="    background: white;border: 0px;display: flex;">'+
                            '<i class="fa fa-heart " style="font-size: 25px;margin-top: -4px;color: red"></i>'+
                            '<p>Is favorite  </p>'+
                        '</button>'+
                        '</form>';}
                    sub+='</div>'+
                   ' </span>'+
                '</div>'+
               '<div class="col-md-6">'+
                 
                    `<a  href="/product?id=`+products_id+`">`+
                        '<img src="'+m_image+'">'+
                    '</a>'+
                '</div>'+
            '</div>'+
       ' </div>  ';
                                 }
                }
    
   return  sub;
}