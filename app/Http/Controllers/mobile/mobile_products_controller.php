<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryDesc;
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

class mobile_products_controller extends Controller
{
    
   
    public function getAllProducts(Request $request)
    {        //return all products
        
        /*  
        $page = $request->has('page')?$request->page:1;
        
        $product_counts=Product::where('products_status', 1)->count();
       // return $product_counts/10;
        if($page>ceil($product_counts/10))
            return response()->json(["message"=>"No data found"],404);
        
        $product = Product::where('products_status', 1)->skip(($page-1)*10)->take(10)->with(['category', 'description'])->get()->map(function ($row) {
                if ($row->mainImage) $row->mainImage->name=URL::asset( '/'. $row->mainImage->path());
             //$row->reviews =0;  
             $count=0;
             $r=0;
             foreach($row->reviews as $reviews){
             $r =$r +$reviews->reviews_rating;
             $count++;
         }
         if($count!=0){
               $row->rating =$r/$count;
         }
         else{ $row->rating=0;}
               //
                return $row;
            });*/
             $product = Product::where('products_status', 1)->with(['category', 'description'])->get()->map(function ($row) {
                if ($row->mainImage) $row->mainImage->name=URL::asset( '/'. $row->mainImage->path());
             //$row->reviews =0;  
             $count=0;
             $r=0;
             foreach($row->reviews as $reviews){
             $r =$r +$reviews->reviews_rating;
             $count++;
         }
         if($count!=0){
               $row->rating =$r/$count;
         }
         else{ $row->rating=0;}
               //
                return $row;
            });
        return ($product) ;
    }
    
    

     public function getAllCategories()
    {
        //return all categories
        $categories = Category::with(['desc', 'image'])->get()->map(function ($row) {
                if ($row->image) $row->image->name=URL::asset($row->image->path());
                //$row['name']=$row->description->categories_name;
                return $row;
            });
        
        return   $categories;
        
        
    }
        
        public function getAllCategories_game()
    {
        //return all categories
        $categories = Category::with(['desc', 'image'])->whereIn('categories_id',[158,159,160,161,162,163,164,165])->get()->map(function ($row) {
                if ($row->image) $row->image->name=URL::asset($row->image->path());
                //$row['name']=$row->description->categories_name;
                return $row;
            });
        
        return   $categories;
        
        
    }  
        public function getProductsByCategoryId(Request $request){
        $id=$request->categories_id;
        $products=DB::table('products_to_categories')->where('categories_id',$id);
        
        if(!$products->clone()->exists())
            return [];
        
        $products_ids = $products->get()->pluck('products_id')->all();
        
       // return $products_ids;
        $product = Product::where('products_status', 1)->whereIn('products_id',$products_ids)->with(['category', 'description'])->get()->map(function ($row) {
                if ($row->mainImage) $row->mainImage->name=URL::asset( '/'. $row->mainImage->path());
                 $count=0;
             $r=0;
             foreach($row->reviews as $reviews){
             $r = $r+$reviews->reviews_rating;
             $count++;
         }
         if($count!=0){
               $row->rating =$r/$count;
         }
         else{ $row->rating=0;}
                return $row;
            });
        return ($product) ;
    }
    
    
    
         public function getProductsByPrice(Request $request){
        $min_product_price=$request->min_product_price;
        $max_product_price=$request->max_product_price;

        $products_by_price=Product::select('products_id', 'products_model as model', 'products_price as price', 'products_quantity as quantity', 'products_image', 'products_weight as weight')
            ->with(['description:id,products_id,products_name', 'category.description', 'mainImage'])
            ->orderBy('products_id', 'Desc')->where('products_price','>',$min_product_price)->where('products_price','<',$max_product_price)->get()
            ->map(function ($row) {
                if ($row->mainImage) $row->mainImage->name = URL::asset('assets/uploads/images/products/' . $row->mainImage->name);
                  $count=0;
             $r=0;
             foreach($row->reviews as $reviews){
             $r = $r+$reviews->reviews_rating;
             $count++;
         }
         if($count!=0){
               $row->rating =$r/$count;
         }
         else{ $row->rating=0;}
                return $row;
            });
    
       // return $category_products;
        return $products_by_price;
    }
    
    
    
    //show product 
    
    
    public function show($id){
        
      
        
        $product = Product::where('products_id',$id);
        if(!$product->clone()->exists() || $product->clone()->first()->products_status!=1){
              $response=[
                'success'=>false,
                'message'=>'Error : no data found',
                ];
        
             return response()->json($response,404);
        }
        
         $product = $product
         ->select('products_id','products_image','products_price','product_video','original_price')
         ->with(
             [  
                 'category:categories_id',
                 'category.description:categories_id,categories_name',
                 'description:products_id,products_name,products_description',
                 'mainImage:id,name',
                 'images:id,name'
            ])
         ->first();
         $product->mainImage->name=URL::asset($product->mainImage->path());
         foreach($product->images as $image){
             $image->name = URL::asset($image->path());
         }
         
         $product->mainImage->name=URL::asset($product->mainImage->path());
         foreach($product->images as $image){
             $image->name = URL::asset($image->path());
         }
           $count=0;
             $r=0;
             foreach($product->reviews as $reviews){
             $r = $r+$reviews->reviews_rating;
             $count++;
         }
         if($count!=0){
               $product->rating =$r/$count;
         }
         else{ $product->rating=0;}
         
        if(!is_null($product['product_video']) && $product['product_video'])
        $product['product_video']=URL::asset('images/media/product_videos/'.$product->product_video);
        $data = [];
        
        $has_attribute=false;
        
        
        
        if ($product->has('attributes')){
            
        
            foreach ($product->attributes as $option) {
                $data[] = [
                    'option_id' => $option->products_options_id,
                    'option_name' => $option->name(),
                    'option_value' => [
                        'value_id' => $option->pivot->options_values_id,
                        'value_name' => $option->valueName($option->pivot->options_values_id),
                        'option_act_value'=>$option->name1($option->pivot->options_values_id),
                    ],
                    'option_quantity'=>$option->pivot->attribute_quantity
                ];
            }
        }
        
        if(!empty($data))$has_attribute=true;
        $product->makeHidden('attributes');
        $product['has_attribute']=$has_attribute;
        $product['attribute']=$data;
       
       return response()->json([$product],200);
        
    }
    
    
    
    
    
    
    
    
    
}