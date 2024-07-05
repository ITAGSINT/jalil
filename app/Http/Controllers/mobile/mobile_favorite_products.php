<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryDesc;
use App\Models\LikedProducts;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\UImage;
use App\Scopes\LangScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Carbon;

use App\Models\Offer;


class mobile_favorite_products extends Controller
{    
    
    
    public function getFavoritesByCustomerId(Request $request){
        
        $validator = Validator::make($request->all(),[
            'user_id'=>['required','exists:users,id']
            ]);
        
         if($validator->fails()){
                
                 $response=[
                'success'=>false,
                'message'=>'Error : Validation error',
                'errors'=> $validator->errors()
                ];
        
             return response()->json($response,404);
                
            }
        $id=$request->user_id;
            
        $liked_products=LikedProducts::select('*')->where('liked_customers_id',$id)->get()->pluck('liked_products_id')->all();
       return $liked_products;

       $products = Product::whereIn('products_id',$liked_products)->select('products_id','products_image','products_price')->with(['description:products_id,products_name,products_description','mainImage:id,name','category:categories_id'])->get()
                ->map(function($row){
                    $row->mainImage->name=URL::asset($row->mainImage->path());
                return $row;
       }); 
        if(empty($liked_products)){
            $response=[
                'success'=>false,
                'message'=>'Error : no data found',
                
                ];
         return response()->json($response,404);
    
        }else{
            
         return response()->json($products,200);
    
        }
                 
        
    }
    
     public function addToFavorites(Request $request){
            
            $validator = Validator::make($request->all(),[
                'product_id'=>['required','exists:products,products_id'],
                'user_id'=>['required','exists:users,id']
                ]);
            if($validator->fails()){
                
                 $response=[
                'success'=>false,
                'message'=>'Error : Validation error',
                'errors'=> $validator->errors()
                ];
        
             return response()->json($response,404);
                
            }
            
            if(LikedProducts::where('liked_products_id',$request->product_id)->where('liked_customers_id',$request->user_id)->exists()){
                  $response=[
                'success'=>false,
                'message'=>'Product already in favourite',
                ];
        
             return response()->json($response,404);
            }
            
              
           $date= Carbon\Carbon::now()->format('Y-m-d');
                //insert new blog in the database
                $liked_products= new LikedProducts();
                $liked_products->liked_products_id=$request->product_id;
                $liked_products->liked_customers_id=$request->user_id;
                $liked_products->date_liked=$date;
                $query=$liked_products->save();
                
               
                if($query){
                     $response=[
                        'success'=>true,
                        'message'=>'Product added to favourite successfully',
                        
                        ];
        
                        return response()->json($response,200);
                    
                  }else{
                       $response=[
                        'success'=>false,
                        'message'=>'Something went rong',
                        
                        ];
                    return response()->json($response,400);
                }
         }
          public function deleteFromFavorites(Request $request){
             $user_id=$request->user_id;
             $product_id=$request->product_id;
             $query=LikedProducts::where('liked_products_id',$product_id)->where('liked_customers_id',$user_id)->delete();
        
 
                if($query){
                    return response()->json(['code'=>1, 'msg'=>'done']);
                }else{
                    return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
                }
    }   
    
    
    public function getOffers(){
        
        $data = Offer::select('image_path as image')->get()->map(function ($row){$row->image=URL::asset($row->image);return $row;});
        
        return response()->json($data,200);
        
    }
   
}