<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\customers_basket;
use App\Models\Product;
use App\Models\ProductDesc;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class productscontroller extends Controller
{
  public function addToCard(Request $request)
  {

    $find = false;
    $id = $request->product_id;
    $product = Product::find($id);

    $cart = session()->get('cart', []);
    // return $cart;

    if (!empty($cart)) {

      $req_option = $request->option_value;

      for ($i = 0; $i < count($cart); $i++) {
        if ($cart[$i]['id'] == $id) {

          if (isset($req_option)) {
            foreach ($cart[$i]['option_value'] as $key => $value) {

              if ($value == $req_option["اللون"]) {
                $cart[$i]['quantity'] += $request->quantity;
                $find = true;
                break;
              }

              /* elseif($value==$req_option["color"]){
                       $cart[$i]['quantity']+=$request->quantity;
                       $find=true;
                       break;
                   } 
               */
            }
          } else {
            $cart[$i]['quantity'] += $request->quantity;
            $find = true;
            break;
          }
        }
      }
      if ($find != true) {
        array_push($cart, [
          "id" => $product->products_id,
          "name" => $product->description->products_name,
          "image" => $product->mainImage->path(),
          "price" => $request->price,
          "quantity" => $request->quantity,
          "option_value" => $request->option_value,
          "discount_amount" => $request->discount_amount,
          "discount_quantity" => $request->discount_quantity


        ]);
      }
    } else {

      array_push($cart, [
        "id" => $product->products_id,
        "name" => $product->description->products_name,
        "image" => $product->mainImage->path(),
        "price" => $request->price,
        "quantity" => $request->quantity,
        "option_value" => $request->option_value,
        "discount_amount" => $request->discount_amount,
        "discount_quantity" => $request->discount_quantity

      ]);
    }
    session()->put('cart', $cart);
    session()->forget('total');
    session()->forget('discount');
    session()->forget('shipping_cost');
    session()->forget('coupon');

    return redirect()->back()->with('success', 'تمت الإضافة الى السلة بنجاح');

    // dd($cart);
    // return $cart;
    //return response()->json(['code'=>1,'msg'=>'تمت إضافة المنتج الى السلة بنجاح']);
  }

  public function removeFromCard(Request $request)
  {
    $id = $request->id;
    $cart = session()->get('cart');
    if ($id < 0 || $id > count($cart) - 1)
      return redirect()->back()->with('success', 'خطأ غير متوقع');;
    array_splice($cart, $id, 1);

    session()->put('cart', $cart);
    /*
        $id= $request->id;
        $opt=$request->option;
         
         $cart = session()->get('cart');
         for($i=0;$i<count($cart);$i++){
              
              if($cart[$i]['id']==$id) {
                 if(isset($opt)){
                   foreach($cart[$i]['option_value'] as $key=>$value){
                   if($value==$opt){
                      
                      unset($cart[$i]);
                      break;
               
                 
                } 
                       
                   }  }
             else{
                  unset($cart[$i]);
 
             }
          }   
              
      }
        session()->put('cart', $cart);
       
           // session()->flash('success', 'تم حذف المنتج من السلة ..   ');
        */
    return redirect()->back()->with('success', 'تم حذف المنتج من السلة !');
  }


  public function autocomplete(Request $request)
  {


    $search = $request->query->get('query');

    $data = ProductDesc::where('products_name', 'LIKE', '%' . $search . '%')->get(['products_id', 'products_name']);

    $response = [
      'success' => true,
      'data' => $data
    ];

    return response()->json($response, 200);
  }
  public function changeQuantity(Request $request)
  {
    // $this->validate($request, ['product_option' => 'sometimes',]);

    $id = $request->product_id;
    $option = $request->product_option;

    $quantity = DB::table('products_attributes')
      ->join('products_options_values_descriptions', 'products_attributes.options_values_id', '=', 'products_options_values_descriptions.products_options_values_id')
      ->where('products_options_values_descriptions.options_values_name', $option)
      ->where('products_attributes.products_id', $id)
      ->select('products_attributes.attribute_quantity');


    if ($quantity->clone()->exists()) {
      $quantity = $quantity->first();


      if ($quantity->attribute_quantity == 0) {
        $content = '<button class="add-to-cart-btn " style="margin-top:15px;" type="button">  المنتج غير متوفر حاليا !    </button>';
        return response()->json(['content' => $content, 'quantity' => $quantity->attribute_quantity]);
        // return $content."  ".$quantity->attribute_quantity;
      } else {
        $content = '<button class="add-to-cart-btn" style="margin-top:15px;" type="submit">
                 <h3 style="font-size: 18px;color: #b1afb0;font-weight: lighter;padding: 11px;text-align: center;">
                  Add to bag
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                  </svg>
                </h3>
                 </button>';
        return response()->json(['content' => $content, 'quantity' => $quantity->attribute_quantity]);
      }
    } else {
      $quantity = Product::select('products_quantity')->where('products_id', $id)->first();

      if ($quantity->products_quantity == 0) {
        $content = '<button class="add-to-cart-btn " style="margin-top:15px;" type="button">  المنتج غير متوفر حاليا !    </button>';
        return response()->json(['content' => $content, 'quantity' => $quantity->products_quantity]);
      } else {
        $content = '<button class="add-to-cart-btn" style="margin-top:15px;" type="submit">
                 <h3 style="font-size: 18px;color: #b1afb0;font-weight: lighter;padding: 11px;text-align: center;">
                  Add to bag
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                  </svg>
                </h3>
                 </button>';
        return response()->json(['content' => $content, 'quantity' => $quantity->products_quantity]);
      }
    }
  }


  public function addReview(Request $request)
  {


    $rules = [
      'Name' => ['required', 'string'],
      'rating' => ['required', 'numeric'],
      'Message' => ['required', 'string'],

    ];
    foreach ($rules as $key => $value) {
      $attributes_name[$key] = __('attribute.' . $key);
    }

    $validator = Validator::make($request->all(), $rules, [], $attributes_name);
    if ($validator->fails()) {
      return redirect()->back()->withInput()->withErrors($validator->errors());
    }

    $review_id =  DB::table('reviews')->insertGetId([
      'products_id' =>  $request->id,
      'customers_id' => Auth::user()->id,
      'customers_name' => $request->Name,
      'reviews_rating' => $request->rating,
      'reviews_status' => 0,
      'reviews_read' => 0,
      'created_at' => Carbon::now()

    ]);

    DB::table('reviews_description')->insert([
      'review_id' => $review_id,
      'language_id' => '1',
      'reviews_text' => $request->Message,

    ]);


    return redirect()->back()->with('success', 'تم إضافة التقييم بنجاح .. شكرا لك..');
  }
}
