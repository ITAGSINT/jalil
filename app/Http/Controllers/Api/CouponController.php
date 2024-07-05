<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
class CouponController extends Controller
{
    //
    
    
    
        
    public static function couponApplay($data,$cart){
        
        $coupon = Coupon::where('code',$data['code']);
        if(!$coupon->clone()->exists())
            return [false,"NO COUPON FOUND !"];
        $coupon=$coupon->first();
        
        $discount_type=$coupon->discount_type;
        $discount_amount=$coupon->amount;
        $discount_border=$coupon->minimum_amount;
        $expire_date=$coupon->expiry_date;
        $x_item_limit=$coupon->limit_usage_to_x_items;
        $free_shipping=$coupon->free_shipping;
       
        $final_price = $data['total'];
        
        

        if($final_price>($discount_border)  and (now()->lt($expire_date))){
             /*
              ($coupon->usage_count > $coupon->used_by)
             */
        
    	 if($discount_type=='fixed_cart'){
            
        
             $data['discount'] += $discount_amount;
             
             
          }elseif($discount_type=='fixed_product'){
            
            $coupon_products = $coupon->product_ids;
          
            foreach($cart as $product){ 
                         //return $product;
                        if(array_search($product->products_id,$coupon_products)!== false){
                           if($product->customers_basket_quantity >= $x_item_limit){
                              $data['discount']+= $discount_amount*$product->customers_basket_quantity;
                           }
                        }
                    }
             }
            
           elseif($discount_type=='percent'){
            
              
             
             $data['discount'] += $data['total']*$discount_amount/100;
               
        }
        elseif($discount_type=='percent_product'){
            
            $coupon_products = $coupon->product_ids;
            foreach($cart as $product){ 
                       
                       
                       if(array_search($product->products_id,$coupon_products)!== false){
                           if($product->customers_basket_quantity>= $x_item_limit){
                              $data['discount']+= $product->customers_basket_quantity*$discount_amount*$product->final_price/100;
                           }
                        }
                       
                        
                    }
             
         }
            
               
         }
        else
        {
             return [false,"coupon cant't be applied !"];
        
        }
        
     
        if($free_shipping==1){
           
            $data['shipping_cost']=0;
            
        }
        
        return [true,$data];

        
    }
    
}
