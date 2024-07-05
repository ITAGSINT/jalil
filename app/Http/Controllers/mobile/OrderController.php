<?php

namespace App\Http\Controllers\mobile;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\ProductOption;
use App\Models\Order;
use App\Models\orders_products;
use App\Models\orders_products_attribute;
use App\Models\OrderStatusHistory;
use App\Models\ProductDesc;
use Illuminate\Support\Facades\Validator;
use App\classes\OrderScope;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Coupon;
use App\Models\product_quantity_stock;
use App\Models\store_product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Stripe\Price;

class OrderController extends Controller
{
    //use Session;

    public function handleOrdersCash(Request $request)
    {
        /////////////////// order db //////////////////////////
        $validator = Validator::make($request->all(), [
            'store_id' => ['required'],
            'user_id' => ['required', 'exists:users,id'],
            'f_name' => ['required', 'string', 'min:3'],
            'l_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'min:8'],
            'city' => ['required', 'string'],
            'street' => ['required'],
            'address' => ['required', 'string'],



        ]);
        // 'country' => ['required', 'string'],
        //             'state' => ['required', 'string'],
        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }

        $user = User::find($request->user_id);
        //Get Cart and Linked With Order
        $cart = Cart::with(['cartAttributes'])->where('customers_basket.store_id', $request->store_id)->where('customers_basket.customers_id', $request->user_id)->get();

        foreach ($cart as $details) {
            $arr = array();

            foreach ($details->cartAttributes()->get('products_options_values_id') as $cart_attributes) {
                array_push($arr, $cart_attributes->products_options_values_id);
            }

            $d = product_quantity_stock::where('product_id', $details->products_id)->where('is_active', 1)->get()->map(function ($row) use ($arr) {
                $row->d = $row->product_variations_group2($arr);
                if ($row->d === 0) {
                    return 0;
                } else
                    return $row;
            });

            $final = 0;
            foreach ($d as $d1) {
                if ($d1 === 0) {
                } else {

                    $final1 = store_product::where('product_quantity_stock_id', $d1->id)->where('store_id', $request->store_id)->first();
                    $final = $final1->quantity;
                }
            }
            //   return  $details->customers_basket_quantity;
            if ($final == 0) {
                //  return $final;
                $cart1 = DB::table('customers_basket')->where('customers_basket_id', $details->customers_basket_id);
                // $cart_att = DB::table('customers_basket_attributes')->where('customers_basket_id', $details->customers_basket_id);
                if ($cart1->exists()) {
                    // $cart1->cart_attribute()->delete();
                    // $cart1->delete();

                    // $response['success'] = false;
                    // $response['messages'] = $validator->errors();

                    return response()->json(['code' => 0, 'error' => 'Product is out of stock !!']);
                }
            }
            if ($final < $details->customers_basket_quantity) {
                //  return $final;
                $cart1 = DB::table('customers_basket')->where('customers_basket_id', $details->customers_basket_id);
                // $cart_att = DB::table('customers_basket_attributes')->where('customers_basket_id', $details->customers_basket_id);
                if ($cart1->exists()) {
                    // $cart1->cart_attribute()->delete();
                    // $cart1->delete();

                    // $response['success'] = false;
                    // $response['messages'] = $validator->errors();

                    return response()->json(['code' => 0, 'error' => 'Max quantity of this product is ' . $final . ' !!', 'data' => ['stock_quantity' => $final]]);
                }
            }
        }


        $order_total = 0;
        foreach ($cart as $details) {
            $pro_id = $details->products_id;
            $product = Product::where('products_id', $pro_id)->first();
            $price = $product->products_price;
            $discount = $product->discount_price;
            if ($discount < $price)
                $price = $discount;
            $quantity = $details->customers_basket_quantity;
            $order_total += $price * $quantity;
        }
        //return $order_total;

        ////create order 
        $order = new Order();
        $order->customers_id = $request->user_id;
        $order->email = $user->email;
        $order->store_id = $request->store_id;
        $order->address = $request->address;
        $order->customers_name = $user->name;
        $order->customers_telephone = $request->phone;
        $order->customers_state = 'state';
        $order->customers_street_address = $request->street;
        $order->customers_city = $request->city;
        $order->customers_country = 'country';
        $order->date_purchased = Carbon::now()->toDateTimeString();
        $order->delivery_name = $user->name;
        $order->delivery_state = 'state';
        $order->delivery_street_address = $request->street;
        $order->delivery_city = $request->city;
        $order->delivery_country = 'country';
        $order->billing_name = $user->name;
        $order->billing_state = 'state';
        $order->billing_street_address = $request->street;
        $order->billing_city = $request->city;
        $order->billing_country = 'country';
        $order->payment_method = 'Cash';
        $order->currency = '$';
        $order->delivery_phone = $request->phone;
        $order->billing_phone = $request->phone;
        $order_final_value = 20;

        $order->order_price = $order_total;
        $order->save();
        $order_id = $order->orders_id;
        foreach ($cart as $details) {
            //add order product
            $pro_id = $details->products_id;
            $order_product = new orders_products();
            $order_product->orders_id = $order_id;
            $order_product->products_id = $details->products_id;
            $pro_id = $details->products_id;
            $product = Product::where('products_id', $pro_id)->first();
            $order_product->products_name = $product->description->products_name;
            $order_product->products_price = $product->products_price;
            $order_product->final_price = $details->final_price;
            $order_product->original_price = $product->original_price;
            $order_product->products_quantity = $details->customers_basket_quantity;
            $order_product->save();
            // add order product attribute
            $arr = array();
            foreach ($details->cartAttributes()->get('products_options_values_id') as $cart_attributes) {
                array_push($arr, $cart_attributes->products_options_values_id);
            }
            $d = product_quantity_stock::where('product_id', $details->products_id)->where('is_active', 1)->get()->map(function ($row) use ($arr) {
                $row->d = $row->product_variations_group2($arr);
                if ($row->d === 0) {
                    return 0;
                } else
                    return $row;
            });
            $final = 0;
            foreach ($d as $d1) {
                if ($d1 === 0) {
                } else
                    $final = $d1->id;
            }
            // return $final;
            //$quantity_update_in_stock =  product_quantity_stock::find($final);

            $store_product = store_product::where('product_quantity_stock_id', $final)->where('store_id', $request->store_id)->first();

            $store_product->update([
                'quantity' => $store_product->quantity - $details->customers_basket_quantity
            ]);
            $pro_id = $details->products_id;
            $product = Product::where('products_id', $pro_id)->first();
            $product->update([
                'products_quantity' => $product->products_quantity - $details->customers_basket_quantity
            ]);
            foreach ($details->cartAttributes()->get() as $cart_attributes) {
                $product_attr = new orders_products_attribute();
                $product_attr->orders_id = $order->orders_id;
                $product_attr->orders_products_id = $order_product->orders_products_id;
                $product_attr->products_id = $details->products_id;
                $product_attr->products_options = $cart_attributes->products_options_id;
                $product_attr->products_options_values = $cart_attributes->products_options_values_id;
                // $product_attr->options_values_price=
                $product_attr->save();
            }
            //////////////////////////////////////////////   
            $cart1 = DB::table('customers_basket')->where('customers_basket_id', $details->customers_basket_id);
            $cart_att = DB::table('customers_basket_attributes')->where('customers_basket_id', $details->customers_basket_id);

            if ($cart1->exists()) {
                $cart1->delete();
                $cart_att->delete();
            }
        }



        // $cart->->delete();
        $history = new OrderStatusHistory();
        $history->orders_id = $order_id;
        $history->orders_status_id = 1;
        $history->date_added = Carbon::now()->toDateTimeString();
        $history->save();


        $response['success'] = true;
        $response['messages'] = ['successMessage' => "order created successfully"];
        $response['data'] =  $order;
        return response()->json([$response], 200);
    }
    public function handleOrdersCard(Request $request)
    {
        /////////////////// order db //////////////////////////
        $validator = Validator::make($request->all(), [
            'store_id' => ['required'],

        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', "Please check required fileds");
        }
        $user_id = Auth::id();
        if ($user_id == null) {
            if (request()->cookie('user_id') == null) {
            } else {
                $user_id = request()->cookie('user_id');
                $user = User::find($user_id);
                // $user->name=$request->f_name.'-'.$request->l_name;
                // $user->phone=$request->phone;
                $user->save();
            }
        } else {
            $user = User::find($user_id);
            // $user->name=$request->f_name.'-'.$request->l_name;
            // $user->phone=$request->phone;
            $user->save();
        }

        //Get Cart and Linked With Order
        $cart = Cart::with(['cartAttributes'])->where('customers_basket.store_id', $request->store_id)->where('customers_basket.customers_id', $user_id)->get();

        foreach ($cart as $details) {
            $arr = array();
            foreach ($details->cartAttributes()->get('products_options_values_id') as $cart_attributes) {
                array_push($arr, $cart_attributes->products_options_values_id);
            }
            $d = product_quantity_stock::where('product_id', $details->products_id)->where('is_active', 1)->get()->map(function ($row) use ($arr) {
                $row->d = $row->product_variations_group2($arr);
                if ($row->d === 0) {
                    return 0;
                } else
                    return $row;
            });
            $final = 0;
            foreach ($d as $d1) {
                if ($d1 === 0) {
                } else
                    $final = $d1->id;
            }
            if ($final == 0) {
                $cart1 = DB::table('customers_basket')->where('customers_basket_id', $details->customers_basket_id);
                $cart_att = DB::table('customers_basket_attributes')->where('customers_basket_id', $details->customers_basket_id);
                if ($cart1->exists()) {

                    $cart1->delete();
                    $cart_att->delete();
                    FacadesSession::flash('error', 'Product is out of stock !!');
                    return back();
                }
            }
        }


        $order_total = 0;
        foreach ($cart as $details) {
            $pro_id = $details->products_id;
            $product = Product::where('products_id', $pro_id)->first();
            $price = $product->products_price;
            $quantity = $details->customers_basket_quantity;
            $order_total += $price * $quantity;
        }
        ////creat orer 
        $order = new Order();
        $order->customers_id = $user_id;
        $order->email = $user->email;
        $order->store_id = $request->store_id;
        $order->address = 'address';
        $order->customers_name = $user->name;
        $order->customers_telephone = '00000000';
        $order->customers_state = 'state';
        $order->customers_street_address = 'street';
        $order->customers_city = 'city';
        $order->customers_country = 'country';
        $order->date_purchased = Carbon::now()->toDateTimeString();
        $order->delivery_name = $user->name;
        $order->delivery_state = 'state';
        $order->delivery_street_address = 'street';
        $order->delivery_city = 'city';
        $order->delivery_country = 'country';
        $order->billing_name = $user->name;
        $order->billing_state = 'state';
        $order->billing_street_address = 'street';
        $order->billing_city = 'city';
        $order->billing_country = 'country';
        $order->payment_method = 'Credit Card';
        $order->currency = '$';
        $order->delivery_phone = '00000000';
        $order->billing_phone = '00000000';
        $order_final_value = 20;

        $order->order_price = $order_total;
        $order->save();
        $order_id = $order->orders_id;
        foreach ($cart as $details) {
            //add order product
            $pro_id = $details->products_id;
            $order_product = new orders_products();
            $order_product->orders_id = $order_id;
            $order_product->products_id = $details->products_id;
            $pro_id = $details->products_id;
            $product = Product::where('products_id', $pro_id)->first();
            $order_product->products_name = $product->description->products_name;
            $order_product->products_price = $product->products_price;
            $order_product->final_price = $details->final_price;
            $order_product->original_price = $product->original_price;
            $order_product->products_quantity = $details->customers_basket_quantity;
            $order_product->save();
            // add order product attribute
            $arr = array();
            foreach ($details->cartAttributes()->get('products_options_values_id') as $cart_attributes) {
                array_push($arr, $cart_attributes->products_options_values_id);
            }
            $d = product_quantity_stock::where('product_id', $details->products_id)->where('is_active', 1)->get()->map(function ($row) use ($arr) {
                $row->d = $row->product_variations_group2($arr);
                if ($row->d === 0) {
                    return 0;
                } else
                    return $row;
            });
            $final = 0;
            foreach ($d as $d1) {
                if ($d1 === 0) {
                } else
                    $final = $d1->id;
            }
            // return $final;
            $quantity_upate_in_stock =  product_quantity_stock::find($final);

            $store_product = store_product::where('product_quantity_stock_id', $final)->where('store_id', $request->store_id)->first();

            $store_product->update([
                'quantity' => $store_product->quantity - $details->customers_basket_quantity
            ]);
            $pro_id = $details->products_id;
            $product = Product::where('products_id', $pro_id)->first();
            $product->update([
                'products_quantity' => $product->products_quantity - $details->customers_basket_quantity
            ]);
            foreach ($details->cartAttributes()->get() as $cart_attributes) {
                $product_attr = new orders_products_attribute();
                $product_attr->orders_id = $order->orders_id;
                $product_attr->orders_products_id = $order_product->orders_products_id;
                $product_attr->products_id = $details->products_id;
                $product_attr->products_options = $cart_attributes->products_options_id;
                $product_attr->products_options_values = $cart_attributes->products_options_values_id;
                // $product_attr->options_values_price=
                $product_attr->save();
            }
            //////////////////////////////////////////////   
            $cart1 = DB::table('customers_basket')->where('customers_basket_id', $details->customers_basket_id);
            $cart_att = DB::table('customers_basket_attributes')->where('customers_basket_id', $details->customers_basket_id);

            if ($cart1->exists()) {
                $cart1->delete();
                $cart_att->delete();
            }
        }



        // $cart->->delete();
        $history = new OrderStatusHistory();
        $history->orders_id = $order_id;
        $history->orders_status_id = 1;
        $history->date_added = Carbon::now()->toDateTimeString();
        $history->save();


        return redirect()->back()->with(['success' => 'Your Order Sent Successfully']);




        return back();
    }
}
