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
use Illuminate\Support\Str;
use App\Http\Auth\RegisterController;
class LikedProductsControllers extends Controller
{
    
    public function storee(Request $request){
        $client_id=Auth::id();
       
        if($client_id==null){
            if(request()->cookie('user_id')==null){
                $randomString= Str::random(10);
            $user=User::create([
                'first_name'=>"user_name",
                'role_id' => 2,
                 'email'=>$randomString.'@gmail.com'
            ]);
            
            $client_id=$user->id;
          }
          else{
          $client_id=request()->cookie('user_id');}
        
            }
        $product = Product::find($request->product_id);
        
       
        
        $LikedProducts=LikedProducts::create(
            [
            'liked_customers_id'=>$client_id, 
            'liked_products_id'=>$request->product_id,
            'date_liked'=>now()
            
            ]);
            
        $expire = time () + 60 * 60 * 24 * 30;
        $cookie=cookie('user_id',  $client_id ,$expire);   
         return redirect()->back()->withCookie($cookie);
            
    }
     public function destroy(Request $request){
         $client_id=Auth::id();
       
        if($client_id==null){
            if(request()->cookie('user_id')==null){
         
          }
          else{
          $client_id=request()->cookie('user_id');}
        
            }
                $like=  LikedProducts::
        where('liked_products_id','=',$request->product_id)
        ->where('liked_customers_id','=',$client_id)
        ->get()->first();
     
        if($like->exists()){
          LikedProducts:: where('liked_products_id','=',$request->product_id)
        ->where('liked_customers_id','=',$client_id)->delete();
            //$like->delete('like_id',$like->like_id);
             // DB::delete('delete from liked_products where like_id = ?',$like->like_id);
             return redirect()->back();}
        else{
            $response['success']=false;
            $response['messages']=['failedMessage'=>"No data found"];
            return response()->json([$response],200);
        }
        
    }
    
}