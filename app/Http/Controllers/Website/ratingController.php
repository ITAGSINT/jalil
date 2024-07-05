<?php

namespace App\Http\Controllers\website;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use App\Models\Product;
use App\Models\LikedProducts;
use App\Models\User;
use App\Models\ProductDesc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ProductOption;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use App\Http\Auth\RegisterController;
use App\Models\OrderStatus;


class ratingController extends Controller
{
     
  public function rating(Request $request){
       
      if(!Auth::check()){
           return response()->json(['code'=>0,'error'=>'You Must Be LoggedIn To Rate The Product !']);
      }
      else{
          //get products ids for this customer orders
          $order_products = DB::table('orders')
            ->join('orders_products','orders_products.orders_id','orders.orders_id')
            ->select('products_id')
            ->where('orders.customers_id',Auth::user()->id)->get();
            
            
         //   $product_id=Product::select('products_id')->where('products_id',726)->first();// $request->id
            
               $found=false;
             if(!($order_products->isEmpty()))
           {
               foreach ($order_products as $ids) {
                    if($request->id==$ids->products_id){// $request->id
                     $found=true;
                     break;
                    }
                }
            }
            if($found==true){
                 $validator = Validator::make($request->all(),[
            'name'=>'required',
             
               
        ]);
        if($validator->fails()){
            return response()->json(['code'=>0,'error'=>'please enter your name !']);
        }
         else{
              $review_id=  DB::table('reviews')->insertGetId([
                'products_id' => $request->id,
                'customers_id' => Auth::user()->id,
                'customers_name' =>  $request->name,
                'reviews_rating' =>$request->rate,
                'reviews_status' =>0,
                'reviews_read' => 0,
                'created_at' => Carbon::now()
                 
            ]);
            
             DB::table('reviews_description')->insert([
                'review_id' => $review_id,
                'language_id' => '1',
                'reviews_text' =>$request->review,
                
            ]);
            return response()->json(['code'=>1,'msg'=>'thank you For Rating !']);
         }
                
            }
            else{
                 return response()->json(['code'=>0,'error'=>'This Product Must Be Ordered Before Rating !!']);
            }
            
      }
             
  }
}