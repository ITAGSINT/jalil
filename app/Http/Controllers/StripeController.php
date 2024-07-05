<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;
use App\Models\customers_basket;
use App\Models\Product;
use App\Models\Order;
use App\Models\orders_products_attribute;
use App\Models\User;
use App\Models\Coupon;
use App\Models\coupon_product;
use App\Models\OrderStatusHistory;
use App\Models\Cart;
use App\Models\store_product;
use Carbon\Carbon;
use App\Models\orders_products;
use App\Models\product_quantity_stock;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;



use Stripe;
use Session;

class StripeController extends Controller
{
    /**
     * payment view
     */
    public function handleGet()
    {
        return view('Stripe');
    }

    /**
     * handling payment with POST
     */
    public function order_payment(Request $request)
    {

    }
    public function handlePost(Request $request)
    {
           /////////////////// order db //////////////////////////
             $validator = Validator::make($request->all(),[
            'f_name' =>['required','string','min:3'],
            'l_name' =>['required','string'],
            'email' =>['required','email'],
            'address' =>['required','string'],
            'city' =>['required','string'],
            'country' =>['required','string'],
            'street' =>['required'],
            'state' => ['required','string'],
            'phone'=>['required','min:8'],
            ]);

            $user_id=Auth::id();
            if($user_id==null){
                if(request()->cookie('user_id')==null){
              }
            else{
                $user_id=request()->cookie('user_id');
                $user=User::find($user_id);
                // $user->name=$request->f_name.'-'.$request->l_name;
                // $user->phone=$request->phone;
                $user->save();
              }
            }
            else{
                $user=User::find($user_id);
                // $user->name=$request->f_name.'-'.$request->l_name;
                // $user->phone=$request->phone;
                $user->save();
            }

            //Get Cart and Linked With Order
            $cart = Cart::with(['cartAttributes'])->where('customers_basket.store_id',1)->where('customers_basket.customers_id',$user_id)->get();

            foreach($cart as $details){
                $arr=array();
                foreach($details->cartAttributes()->get('products_options_values_id') as $cart_attributes){
                    array_push($arr,$cart_attributes->products_options_values_id);
                    }
                $d=product_quantity_stock::where('product_id',$details->products_id)->where('is_active',1)->get() ->map(function ($row)use($arr){
                      $row->d=$row->product_variations_group2($arr) ;
                      if($row->d===0){ return 0;}
                      else
                      return $row; });
                $final=0;
                foreach($d as $d1){
                if($d1===0){}
                else
                { $final1 = store_product::where('product_quantity_stock_id', $d1->id)->where('store_id', 1)->first();
                    $final = $final1->quantity;}
                }
                if($final==0){
                    $cart1=DB::table('customers_basket')->where('customers_basket_id',$details->customers_basket_id);
                    $cart_att=DB::table('customers_basket_attributes')->where('customers_basket_id',$details->customers_basket_id);
                    if($cart1->exists()){

                    $cart1->delete();
                    $cart_att->delete();
                        FacadesSession::flash('error', 'Product is out of stock !!');
                        return back();
                    }
                }
                 if ($final < $details->customers_basket_quantity) {
           //   return $final.'<'.$details->customers_basket_quantity;
            $cart1 = DB::table('customers_basket')->where('customers_basket_id', $details->customers_basket_id);
            //$cart_att = DB::table('customers_basket_attributes')->where('customers_basket_id', $details->customers_basket_id);
            if ($cart1->exists()) {
             $cart1->update([
                    'customers_basket_quantity' => $final
                ]);
                // $cart1->delete();

                // $response['success'] = false;
                // $response['messages'] = $validator->errors();
                 $product=Product::where('products_id',$details->products_id)->first();

            FacadesSession::flash('error','Max quantity of '.$product->description->products_name.'  is '. $final . '!!');
               return back();
               // return response()->json(['code' => 0, 'error' => 'Max quantity of this product is ' . $final . ' !!', 'data' => ['stock_quantity'=>$final]]);
            }
        }
            }


            $order_total =0;
             foreach($cart as $details){
                $pro_id=$details->products_id;
                $product=Product::where('products_id',$pro_id)->first();
                 $price=$product->products_price;
                 $quantity=$details->customers_basket_quantity;
                 $order_total+=$price*$quantity;
             }
            ////creat orer
                 $order=new Order();
                 $order->customers_id=$user_id;
                 $order->email=$user->email;
                   $order->store_id=1;
                 $order->address='address';
                 $order->customers_name=$user->name;
                 $order->customers_telephone='00000000';
                 $order->customers_state='state';
                 $order->customers_street_address='street';
                 $order->customers_city='city';
                 $order->customers_country='country';
                 $order->date_purchased=Carbon::now()->toDateTimeString();
                 $order->delivery_name=$user->name;
                 $order->delivery_state='state';
                 $order->delivery_street_address='street';
                 $order->delivery_city='city';
                 $order->delivery_country='country';
                 $order->billing_name=$user->name;
                 $order->billing_state='state';
                 $order->billing_street_address='street';
                 $order->billing_city='city';
                 $order->billing_country='country';
                 $order->payment_method='Cash';
                 $order->currency='$';
                 $order->delivery_phone='00000000';
                 $order->billing_phone='00000000';
                 $order_final_value=20;

                 $order->order_price=$order_total;
                 $order->save();
                 $order_id=$order->orders_id;
                 foreach($cart as $details){
                 //add order product
                 $pro_id=$details->products_id;
                 $order_product= new orders_products();
                 $order_product->orders_id=$order_id;
                 $order_product->products_id=$details->products_id;
                 $pro_id=$details->products_id;
                 $product=Product::where('products_id',$pro_id)->first();
                 $order_product->products_name=$product->description->products_name;
                 $order_product->products_price=$product->products_price;
                 $order_product->final_price=$details->final_price;
                 $order_product->original_price=$product->original_price;
                 $order_product->products_quantity=$details->customers_basket_quantity;
                 $order_product->save();
                // add order product attribute
                $arr=array();
                foreach($details->cartAttributes()->get('products_options_values_id') as $cart_attributes){
                    array_push($arr,$cart_attributes->products_options_values_id);
                    }
                $d=product_quantity_stock::where('product_id',$details->products_id)->where('is_active',1)->get() ->map(function ($row)use($arr){
                      $row->d=$row->product_variations_group2($arr) ;
                      if($row->d===0){ return 0;}
                      else
                      return $row; });
                $final=0;
                foreach($d as $d1){
                if($d1===0){}
                else
                $final=$d1->id;
                }
               // return $final;
          $quantity_upate_in_stock=  product_quantity_stock::find($final);

            $store_product=store_product::where('product_quantity_stock_id',$final)->where('store_id',1)->first();

          $store_product->update([
                    'quantity' => $store_product->quantity -$details->customers_basket_quantity
                ]);
            $pro_id=$details->products_id;
         $product=Product::where('products_id',$pro_id)->first();
                 $product->update([
                    'products_quantity' => $product->products_quantity -$details->customers_basket_quantity
                ]);
          foreach($details->cartAttributes()->get() as $cart_attributes){
          $product_attr=new orders_products_attribute();
          $product_attr->orders_id=$order->orders_id;
          $product_attr->orders_products_id=$order_product->orders_products_id;
          $product_attr->products_id=$details->products_id;
          $product_attr->products_options=$cart_attributes->products_options_id;
          $product_attr->products_options_values=$cart_attributes->products_options_values_id;
         // $product_attr->options_values_price=
          $product_attr->save();
          }
          //////////////////////////////////////////////
          $cart1=DB::table('customers_basket')->where('customers_basket_id',$details->customers_basket_id);
        $cart_att=DB::table('customers_basket_attributes')->where('customers_basket_id',$details->customers_basket_id);

                if($cart1->exists()){
            $cart1->delete();
            $cart_att->delete();}
           }



         // $cart->->delete();
           $history=new OrderStatusHistory();
           $history->orders_id=$order_id;
           $history->orders_status_id=1;
           $history->date_added=Carbon::now()->toDateTimeString();
           $history->save();


   // return redirect()->back()->with(['success'=>'Your Order Sent Successfully']);




        try {
            // Use Stripe's library to make requests...
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            Stripe\Charge::create([
                "amount" => $request->amount,
                "currency" => "AED",
                "source" => $request->stripeToken,
                "description" => "payment from belucci customer."
            ]);
            FacadesSession::flash('success', 'Payment has been successfully processed.');
        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            // echo 'Status is:' . $e->getHttpStatus() . '\n';
            // echo 'Type is:' . $e->getError()->type . '\n';
            // echo 'Code is:' . $e->getError()->code . '\n';
            // // param is '' in this case
            // echo 'Param is:' . $e->getError()->param . '\n';
            // echo 'Message is:' . $e->getError()->message . '\n';

            FacadesSession::flash('error', $e->getError()->message);
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly

            FacadesSession::flash('error', 'RateLimitException');
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API

            FacadesSession::flash('error', 'InvalidRequestException');
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            FacadesSession::flash('error', 'AuthenticationException');
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed

            FacadesSession::flash('error', 'ApiConnectionException');
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email

            FacadesSession::flash('error', 'ApiErrorException');
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe

            FacadesSession::flash('error', 'Error');
        }
        return back();
    }
    public function handleOrdersCash(Request $request)
    {
           /////////////////// order db //////////////////////////
             $validator = Validator::make($request->all(),[
            'store_id' =>['required'],
            'discount_amount' =>['required'],
            'opiration_type' =>['required'],

            ]);

            if($validator->fails()){
                return redirect()->back()->with('error',"Please check required fileds");
            }
            $user_id=Auth::id();
            if($user_id==null){
                if(request()->cookie('user_id')==null){
              }
            else{
                $user_id=request()->cookie('user_id');
                $user=User::find($user_id);
                // $user->name=$request->f_name.'-'.$request->l_name;
                // $user->phone=$request->phone;
                $user->save();
              }
            }
            else{
                $user=User::find($user_id);
                // $user->name=$request->f_name.'-'.$request->l_name;
                // $user->phone=$request->phone;
                $user->save();
            }

            //Get Cart and Linked With Order
            $cart = Cart::with(['cartAttributes'])->where('customers_basket.store_id',$request->store_id)->where('customers_basket.customers_id',$user_id)->get();

            foreach($cart as $details){
                $arr=array();
                foreach($details->cartAttributes()->get('products_options_values_id') as $cart_attributes){
                    array_push($arr,$cart_attributes->products_options_values_id);
                    }
                $d=product_quantity_stock::where('product_id',$details->products_id)->where('is_active',1)->get() ->map(function ($row)use($arr){
                      $row->d=$row->product_variations_group2($arr) ;
                      if($row->d===0){ return 0;}
                      else
                      return $row; });
                $final=0;
                foreach($d as $d1){
                if($d1===0){}
                else{
                 $final1 = store_product::where('product_quantity_stock_id', $d1->id)->where('store_id', $request->store_id)->first();
                 $final = $final1->quantity;}
                }
                if($final==0){
                    $cart1=DB::table('customers_basket')->where('customers_basket_id',$details->customers_basket_id);
                    $cart_att=DB::table('customers_basket_attributes')->where('customers_basket_id',$details->customers_basket_id);
                    if($cart1->exists()){

                    $cart1->delete();
                    $cart_att->delete();
                    return redirect()->back()->with(['error'=> 'Product is out of stock !!']);
                       // FacadesSession::flash('error', 'Product is out of stock !!');
                       // return back();
                    }
                }
                 if ($final < $details->customers_basket_quantity) {
           //   return $final.'<'.$details->customers_basket_quantity;
            $cart1 = DB::table('customers_basket')->where('customers_basket_id', $details->customers_basket_id);
            //$cart_att = DB::table('customers_basket_attributes')->where('customers_basket_id', $details->customers_basket_id);
            if ($cart1->exists()) {
             $cart1->update([
                    'customers_basket_quantity' => $final
                ]);
                // $cart1->delete();

                // $response['success'] = false;
                // $response['messages'] = $validator->errors();
                 $product=Product::where('products_id',$details->products_id)->first();
          return redirect()->back()->with(['error'=>'Max quantity of '.$product->description->products_name.'  is '. $final . '!!']);
            //FacadesSession::flash('error',);
               //return back();
               // return response()->json(['code' => 0, 'error' => 'Max quantity of this product is ' . $final . ' !!', 'data' => ['stock_quantity'=>$final]]);
            }
        }
            }


      //return $request->discount_amount.'--'.$cart->sum('customers_basket_quantity');
            $order_total =0;
            $dis=($request->discount_amount)/$cart->sum('customers_basket_quantity');
            if($request->discount_amount!=0){

                if($request->opiration_type==0){
                    foreach($cart as $details){
                $pro_id=$details->products_id;
                $product=Product::where('products_id',$pro_id)->first();
                 $price=$product->products_price;
                 $quantity=$details->customers_basket_quantity;
                 $order_total+=($price-(  $price  *  ($request->discount_amount/100)  )  )*$quantity;
                 //parseFloat($('#cart_subtotal_card').html())-(parseFloat($('#cart_subtotal_card').html())*(discount/100));
             }
                }
                else{

                    foreach($cart as $details){
                $pro_id=$details->products_id;
                $product=Product::where('products_id',$pro_id)->first();
                 $price=$product->products_price;
                 $quantity=$details->customers_basket_quantity;
                 $order_total+=($price-$dis)*$quantity;
             }
                }
            }
            else{
                foreach($cart as $details){
                $pro_id=$details->products_id;
                $product=Product::where('products_id',$pro_id)->first();
                 $price=$product->products_price;
                 $quantity=$details->customers_basket_quantity;
                 $order_total+=$price*$quantity;
             }
            }

            ////creat orer
                 $order=new Order();
                 $order->customers_id=$user_id;
                 $order->email=$user->email;
                   $order->store_id=$request->store_id;
                 $order->address='address';
                 $order->customers_name=$user->name;
                 $order->customers_telephone='00000000';
                 $order->customers_state='state';
                 $order->customers_street_address='street';
                 $order->customers_city='city';
                 $order->customers_country='country';
                 $order->date_purchased=Carbon::now()->toDateTimeString();
                 $order->delivery_name=$user->name;
                 $order->delivery_state='state';
                 $order->delivery_street_address='street';
                 $order->delivery_city='city';
                 $order->delivery_country='country';
                 $order->billing_name=$user->name;
                 $order->billing_state='state';
                 $order->billing_street_address='street';
                 $order->billing_city='city';
                 $order->billing_country='country';
                 $order->payment_method='Cash';
                 $order->currency='$';
                 $order->delivery_phone='00000000';
                 $order->billing_phone='00000000';
                 $order_final_value=20;

                 $order->order_price=$order_total;
                 $order->save();
                 $order_id=$order->orders_id;
                 foreach($cart as $details){
                 //add order product
                 $pro_id=$details->products_id;
                 $order_product= new orders_products();
                 $order_product->orders_id=$order_id;
                 $order_product->products_id=$details->products_id;
                 $pro_id=$details->products_id;
                 $product=Product::where('products_id',$pro_id)->first();
                 $order_product->products_name=$product->description->products_name;
                 $order_product->products_price=$product->products_price;
                 if($request->discount_amount!=0){
                if($request->opiration_type==0){
                    $order_product->final_price=($details->final_price-(  $details->final_price  *  ($request->discount_amount/100)  )  );
                }
                else{
                    //$dis=($request->discount_amount)/$cart->sum('customers_basket_quantity');
                    $order_product->final_price=($details->final_price-$dis);
                }
            }
            else{
                $order_product->final_price=$details->final_price;
            }

                 $order_product->original_price=$product->original_price;
                 $order_product->products_quantity=$details->customers_basket_quantity;
                 $order_product->save();
                // add order product attribute
                $arr=array();
                foreach($details->cartAttributes()->get('products_options_values_id') as $cart_attributes){
                    array_push($arr,$cart_attributes->products_options_values_id);
                    }
                $d=product_quantity_stock::where('product_id',$details->products_id)->where('is_active',1)->get() ->map(function ($row)use($arr){
                      $row->d=$row->product_variations_group2($arr) ;
                      if($row->d===0){ return 0;}
                      else
                      return $row; });
                $final=0;
                foreach($d as $d1){
                if($d1===0){}
                else
                $final=$d1->id;
                }
               // return $final;
          $quantity_upate_in_stock=  product_quantity_stock::find($final);

            $store_product=store_product::where('product_quantity_stock_id',$final)->where('store_id',$request->store_id)->first();

          $store_product->update([
                    'quantity' => $store_product->quantity -$details->customers_basket_quantity
                ]);
            $pro_id=$details->products_id;
         $product=Product::where('products_id',$pro_id)->first();
                 $product->update([
                    'products_quantity' => $product->products_quantity -$details->customers_basket_quantity
                ]);
          foreach($details->cartAttributes()->get() as $cart_attributes){
          $product_attr=new orders_products_attribute();
          $product_attr->orders_id=$order->orders_id;
          $product_attr->orders_products_id=$order_product->orders_products_id;
          $product_attr->products_id=$details->products_id;
          $product_attr->products_options=$cart_attributes->products_options_id;
          $product_attr->products_options_values=$cart_attributes->products_options_values_id;
         // $product_attr->options_values_price=
          $product_attr->save();
          }
          //////////////////////////////////////////////
          $cart1=DB::table('customers_basket')->where('customers_basket_id',$details->customers_basket_id);
        $cart_att=DB::table('customers_basket_attributes')->where('customers_basket_id',$details->customers_basket_id);

                if($cart1->exists()){
            $cart1->delete();
            $cart_att->delete();}
           }



         // $cart->->delete();
           $history=new OrderStatusHistory();
           $history->orders_id=$order_id;
           $history->orders_status_id=1;
           $history->date_added=Carbon::now()->toDateTimeString();
           $history->save();


           return redirect()->back()->with(['success'=>'Your Order Sent Successfully','order_id'=>$order_id]);




        return back();
    }
    public function handleOrdersCard(Request $request)
    {
           /////////////////// order db //////////////////////////
             $validator = Validator::make($request->all(),[
            'store_id' =>['required'],

            ]);

            if($validator->fails()){
                return redirect()->back()->with('error',"Please check required fileds");
            }
            $user_id=Auth::id();
            if($user_id==null){
                if(request()->cookie('user_id')==null){
              }
            else{
                $user_id=request()->cookie('user_id');
                $user=User::find($user_id);
                // $user->name=$request->f_name.'-'.$request->l_name;
                // $user->phone=$request->phone;
                $user->save();
              }
            }
            else{
                $user=User::find($user_id);
                // $user->name=$request->f_name.'-'.$request->l_name;
                // $user->phone=$request->phone;
                $user->save();
            }

            //Get Cart and Linked With Order
            $cart = Cart::with(['cartAttributes'])->where('customers_basket.store_id',$request->store_id)->where('customers_basket.customers_id',$user_id)->get();

            foreach($cart as $details){
                $arr=array();
                foreach($details->cartAttributes()->get('products_options_values_id') as $cart_attributes){
                    array_push($arr,$cart_attributes->products_options_values_id);
                    }
                $d=product_quantity_stock::where('product_id',$details->products_id)->where('is_active',1)->get() ->map(function ($row)use($arr){
                      $row->d=$row->product_variations_group2($arr) ;
                      if($row->d===0){ return 0;}
                      else
                      return $row; });
                $final=0;
                foreach($d as $d1){
                if($d1===0){}
                else
               {
                 $final1 = store_product::where('product_quantity_stock_id', $d1->id)->where('store_id', $request->store_id)->first();
                 $final = $final1->quantity;}
                }
                }
               if($final==0){
                    $cart1=DB::table('customers_basket')->where('customers_basket_id',$details->customers_basket_id);
                    $cart_att=DB::table('customers_basket_attributes')->where('customers_basket_id',$details->customers_basket_id);
                    if($cart1->exists()){

                    $cart1->delete();
                    $cart_att->delete();
                     return redirect()->back()->with(['error'=> 'Product is out of stock !!']);
                        //FacadesSession::flash('error', 'Product is out of stock !!');
                        //return back();
                    }
                }
                 if ($final < $details->customers_basket_quantity) {
           //   return $final.'<'.$details->customers_basket_quantity;
            $cart1 = DB::table('customers_basket')->where('customers_basket_id', $details->customers_basket_id);
            //$cart_att = DB::table('customers_basket_attributes')->where('customers_basket_id', $details->customers_basket_id);
            if ($cart1->exists()) {
             $cart1->update([
                    'customers_basket_quantity' => $final
                ]);
                // $cart1->delete();

                // $response['success'] = false;
                // $response['messages'] = $validator->errors();
                 $product=Product::where('products_id',$details->products_id)->first();
                   return redirect()->back()->with(['error'=>'Max quantity of '.$product->description->products_name.'  is '. $final . '!!']);

            //FacadesSession::flash('error','Max quantity of '.$product->description->products_name.'  is '. $final . '!!');
            //   return back();
               // return response()->json(['code' => 0, 'error' => 'Max quantity of this product is ' . $final . ' !!', 'data' => ['stock_quantity'=>$final]]);
            }
        }



            $order_total =0;
             foreach($cart as $details){
                $pro_id=$details->products_id;
                $product=Product::where('products_id',$pro_id)->first();
                 $price=$product->products_price;
                 $quantity=$details->customers_basket_quantity;
                 $order_total+=$price*$quantity;
             }
            ////creat orer
                 $order=new Order();
                 $order->customers_id=$user_id;
                 $order->email=$user->email;
                   $order->store_id=$request->store_id;
                 $order->address='address';
                 $order->customers_name=$user->name;
                 $order->customers_telephone='00000000';
                 $order->customers_state='state';
                 $order->customers_street_address='street';
                 $order->customers_city='city';
                 $order->customers_country='country';
                 $order->date_purchased=Carbon::now()->toDateTimeString();
                 $order->delivery_name=$user->name;
                 $order->delivery_state='state';
                 $order->delivery_street_address='street';
                 $order->delivery_city='city';
                 $order->delivery_country='country';
                 $order->billing_name=$user->name;
                 $order->billing_state='state';
                 $order->billing_street_address='street';
                 $order->billing_city='city';
                 $order->billing_country='country';
                 $order->payment_method='Credit Card';
                 $order->currency='$';
                 $order->delivery_phone='00000000';
                 $order->billing_phone='00000000';
                 $order_final_value=20;

                 $order->order_price=$order_total;
                 $order->save();
                 $order_id=$order->orders_id;
                 foreach($cart as $details){
                 //add order product
                 $pro_id=$details->products_id;
                 $order_product= new orders_products();
                 $order_product->orders_id=$order_id;
                 $order_product->products_id=$details->products_id;
                 $pro_id=$details->products_id;
                 $product=Product::where('products_id',$pro_id)->first();
                 $order_product->products_name=$product->description->products_name;
                 $order_product->products_price=$product->products_price;
                 $order_product->final_price=$details->final_price;
                 $order_product->original_price=$product->original_price;
                 $order_product->products_quantity=$details->customers_basket_quantity;
                 $order_product->save();
                // add order product attribute
                $arr=array();
                foreach($details->cartAttributes()->get('products_options_values_id') as $cart_attributes){
                    array_push($arr,$cart_attributes->products_options_values_id);
                    }
                $d=product_quantity_stock::where('product_id',$details->products_id)->where('is_active',1)->get() ->map(function ($row)use($arr){
                      $row->d=$row->product_variations_group2($arr) ;
                      if($row->d===0){ return 0;}
                      else
                      return $row; });
                $final=0;
                foreach($d as $d1){
                if($d1===0){}
                else
                $final=$d1->id;
                }
               // return $final;
          $quantity_upate_in_stock=  product_quantity_stock::find($final);

            $store_product=store_product::where('product_quantity_stock_id',$final)->where('store_id',$request->store_id)->first();

          $store_product->update([
                    'quantity' => $store_product->quantity -$details->customers_basket_quantity
                ]);
            $pro_id=$details->products_id;
         $product=Product::where('products_id',$pro_id)->first();
                 $product->update([
                    'products_quantity' => $product->products_quantity -$details->customers_basket_quantity
                ]);
          foreach($details->cartAttributes()->get() as $cart_attributes){
          $product_attr=new orders_products_attribute();
          $product_attr->orders_id=$order->orders_id;
          $product_attr->orders_products_id=$order_product->orders_products_id;
          $product_attr->products_id=$details->products_id;
          $product_attr->products_options=$cart_attributes->products_options_id;
          $product_attr->products_options_values=$cart_attributes->products_options_values_id;
         // $product_attr->options_values_price=
          $product_attr->save();
          }
          //////////////////////////////////////////////
          $cart1=DB::table('customers_basket')->where('customers_basket_id',$details->customers_basket_id);
        $cart_att=DB::table('customers_basket_attributes')->where('customers_basket_id',$details->customers_basket_id);

                if($cart1->exists()){
            $cart1->delete();
            $cart_att->delete();}
           }



         // $cart->->delete();
           $history=new OrderStatusHistory();
           $history->orders_id=$order_id;
           $history->orders_status_id=1;
           $history->date_added=Carbon::now()->toDateTimeString();
           $history->save();


           return redirect()->back()->with(['success'=>'Your Order Sent Successfully','order_id'=>$order_id]);




    }
     public function handlePostDashboard(Request $request)
    {

        try {
            // Use Stripe's library to make requests...
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            Stripe\Charge::create([
                "amount" => $request->amount,
                "currency" => "AED",
                "source" => $request->stripeToken,
                "description" => "payment from belucci customer."
            ]);
            /////////////////// order db //////////////////////////
             $validator = Validator::make($request->all(),[
            'f_name' =>['required','string','min:3'],
            'l_name' =>['required','string'],
            'email' =>['required','email'],
            'address' =>['required','string'],
            'city' =>['required','string'],
            'country' =>['required','string'],
            'street' =>['required'],
            'state' => ['required','string'],
            'phone'=>['required','min:8'],
           //  'log_email' =>['required','email'],
           // 'password' =>['required'],
        ]);

        if($validator->fails()){
            return redirect()->back()->with('error',"Please check required fileds");
        }
         else{




          $user_id=Auth::id();

        if($user_id==null){
            if(request()->cookie('user_id')==null){

          }
          else{
          $user_id=request()->cookie('user_id');
                 $user=User::find($user_id);
          }

            }
            else{
                  $user=User::find($user_id);
         // dd($user);
          $user->name=$request->f_name.'-'.$request->l_name;

          $user->phone=$request->phone;
          $user->save();
            }
         // $user_id =Auth::User()->id;


             //Get Cart and Linked With Order
        $cart = Cart::with(['cartAttributes'])->where('customers_basket.customers_id',$user_id)
                //->leftjoin('customers_basket_attributes','customers_basket_attributes.customers_basket_id','customers_basket.customers_basket_id')
                ->get();
             //  return $cart;

       $order_total =0;
             foreach($cart as $details){
                 $pro_id=$details->products_id;
         $product=Product::where('products_id',$pro_id)->first();
                 $product->update([
                    'products_quantity' => $product->products_quantity -$details->customers_basket_quantity
                ]);
                 $price=$product->products_price;
                 $quantity=$details->customers_basket_quantity;
                 $order_total+=$price*$quantity;
             }


         //  return $order_total;
         $order=new Order();
         $order->customers_id=$user_id;
         //if($user->email==null)
         $order->email=$request->email;
        // else
         //$order->email=$user->email;

         $order->address=$request->address;
         $order->customers_name=$user->name;
         $order->customers_telephone=$request->phone;


         $order->customers_state=$request->state;
         $order->customers_street_address=$request->street;
         $order->customers_city=$request->city;
         $order->customers_country=$request->country;

         $order->date_purchased=Carbon::now()->toDateTimeString();

         $order->delivery_name=$user->name;
         $order->delivery_state=$request->state;
         $order->delivery_street_address=$request->street;
         $order->delivery_city=$request->city;
         $order->delivery_country=$request->country;
         $order->billing_name=$user->name;
         $order->billing_state=$request->state;
         $order->billing_street_address=$request->street;
         $order->billing_city=$request->city;
         $order->billing_country=$request->country;
         $order->payment_method='Credit Card';
       //  $order->shipping_method='';
         $order->currency='AED';

         $order->delivery_phone=$request->phone;
         $order->billing_phone=$request->phone;
        // $order->coupon_code=$coupon;
        // $order->customer_comment=$request->comment;
         //$order->shipping_cost = session()->get('shipping_cost');
        $order_final_value=20;

        $order->order_price=$order_total;
        $order->save();

         $order_id=$order->orders_id;


           foreach($cart as $details){
               //add order product
                $pro_id=$details->products_id;

         $order_product= new orders_products();
         $order_product->orders_id=$order_id;
         $order_product->products_id=$details->products_id;
         $pro_id=$details->products_id;
         $product=Product::where('products_id',$pro_id)->first();

         $order_product->products_name=$product->description->products_name;
         $order_product->products_price=$product->products_price;
          $order_product->original_price=$product->original_price;
         $order_product->final_price=$details->final_price;
         $order_product->products_quantity=$details->customers_basket_quantity;
         $order_product->save();
         ///////////////////////////////////////
         // add order product attribute
         //dd($details->cartAttributes()->get());
          foreach($details->cartAttributes()->get() as $cart_attributes){
          $product_attr=new orders_products_attribute();
          $product_attr->orders_id=$order->orders_id;
          $product_attr->orders_products_id=$order_product->orders_products_id;
          $product_attr->products_id=$details->products_id;
          $product_attr->products_options=$cart_attributes->products_options_id;
          $product_attr->products_options_values=$cart_attributes->products_options_values_id;
         // $product_attr->options_values_price=
          $product_attr->save();
          }
          //////////////////////////////////////////////
          $cart1=DB::table('customers_basket')->where('customers_basket_id',$details->customers_basket_id);
        $cart_att=DB::table('customers_basket_attributes')->where('customers_basket_id',$details->customers_basket_id);

                if($cart1->exists()){
            $cart1->delete();
            $cart_att->delete();}
           }



         // $cart->->delete();
           $history=new OrderStatusHistory();
           $history->orders_id=$order_id;
           $history->orders_status_id=1;
           $history->date_added=Carbon::now()->toDateTimeString();
           $history->save();


       // return redirect()->back()->with(['success'=>'Your Order Sent Successfully']);



        }
            ///////////////////end order //////////////////
            FacadesSession::flash('success', 'Payment has been successfully processed.');
        } catch (\Stripe\Exception\CardException $e) {
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            // echo 'Status is:' . $e->getHttpStatus() . '\n';
            // echo 'Type is:' . $e->getError()->type . '\n';
            // echo 'Code is:' . $e->getError()->code . '\n';
            // // param is '' in this case
            // echo 'Param is:' . $e->getError()->param . '\n';
            // echo 'Message is:' . $e->getError()->message . '\n';

            FacadesSession::flash('error', $e->getError()->message);
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly

            FacadesSession::flash('error', 'RateLimitException');
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API

            FacadesSession::flash('error', 'InvalidRequestException');
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            FacadesSession::flash('error', 'AuthenticationException');
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed

            FacadesSession::flash('error', 'ApiConnectionException');
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email

            FacadesSession::flash('error', 'ApiErrorException');
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe

            FacadesSession::flash('error', 'Error');
        }
        return back();
    }
    private function handlePaymentToDb(){

    }
}
