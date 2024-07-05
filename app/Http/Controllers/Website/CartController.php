<?php

namespace App\Http\Controllers\website;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;

use App\Models\store_product;
use App\Models\product_variations_group;
use App\Models\CustomersBasketAttributes;
use App\Models\customers_basket;
use App\Models\ProductDesc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ProductOption;
use Illuminate\Support\Facades\URL;
use App\Models\product_quantity_stock;
use Illuminate\Support\Str;
use App\Http\Auth\RegisterController;

class CartController extends Controller
{
    public function i(Request $request)
    {
    }
    public function index3(Request $request)
    {
        return $request->all();

        $client_id = Auth::id();

        $validator = Validator::make($request->all(), [
            //'user_id'=>['required','exists:users,id'],
            'product_id' => ['required', 'exists:products,products_id'],
            //'product_quantity'=>['required','numeric','min:1'],
            'color_Att' => ['required'],
            'color_Att1' => ['required']
            //SIZE ATT
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('error', 'SomeThing Went Wrong !!    ');
        }
        if ($client_id == null) {
            if (request()->cookie('user_id') == null) {
                $randomString = Str::random(10);
                $user = User::create([
                    'first_name' => "user_name",
                    'role_id' => 2,
                    'email' => $randomString . '@gmail.com'
                ]);
                $client_id = $user->id;
            } else {
                $client_id = request()->cookie('user_id');
            }
        }
        $product = Product::find($request->product_id);

        $cart = DB::table('customers_basket')->where('customers_basket.customers_id', $client_id)
            ->leftjoin('customers_basket_attributes', 'customers_basket_attributes.customers_basket_id', 'customers_basket.customers_basket_id')
            ->where('customers_basket.products_id', $request->product_id)
            ->where('customers_basket_attributes.products_options_values_id', $request->color_Att)->first();

        $cart2 = DB::table('customers_basket')->where('customers_basket.customers_id', $client_id)
            ->leftjoin('customers_basket_attributes', 'customers_basket_attributes.customers_basket_id', 'customers_basket.customers_basket_id')
            ->where('customers_basket.products_id', $request->product_id)
            ->where('customers_basket_attributes.products_options_values_id', $request->color_Att1)->first();

        $updated_cart = DB::table('customers_basket')->where('customers_basket.customers_id', $client_id)
            ->leftjoin('customers_basket_attributes', 'customers_basket_attributes.customers_basket_id', 'customers_basket.customers_basket_id')
            ->where('customers_basket.products_id', $request->product_id)
            ->whereIn('customers_basket_attributes.products_options_values_id', [$request->color_Att, $request->color_Att1]);
        //  return $updated_cart;

        $updated_cart2 = DB::table('customers_basket')->where('customers_basket.customers_id', $client_id)
            ->leftjoin('customers_basket_attributes', 'customers_basket_attributes.customers_basket_id', 'customers_basket.customers_basket_id')
            ->where('customers_basket.products_id', $request->product_id)
            ->where('customers_basket_attributes.products_options_values_id', $request->color_Att1);

        if ($updated_cart->exists() && $updated_cart2->exists()) {

            $attr1 = $cart->products_options_values_id;
            $attr2 = $cart2->products_options_values_id;

            $req_attr1 = $request->color_Att;
            $req_attr2 = $request->color_Att1;

            if ($attr1 == $req_attr1 && $attr1 == $req_attr1) {


                $updated_cart->update(['customers_basket.customers_basket_quantity' => DB::raw('customers_basket.customers_basket_quantity + 1')]);
                //   $updated_cart2->update(['customers_basket.customers_basket_quantity'=>DB::raw('customers_basket.customers_basket_quantity + 1')]);

                $response['success'] = true;
                $response['messages'] = ['successMessage' => "record updated successfully"];
                $expire = time() + 60 * 60 * 24 * 30;
                $cookie = cookie('user_id',  $client_id, $expire);
                return redirect()->back()->withCookie($cookie);
            }
        } else {

            $cart = Cart::create(
                [
                    'customers_id' => $client_id,
                    'products_id' => $request->product_id,
                    'customers_basket_quantity' => 1,
                    'final_price' => $product->products_price
                ]
            );

            DB::table('customers_basket_attributes')->insert([
                'customers_id' => $client_id,
                'products_id' => $request->product_id,
                'customers_basket_id' => $cart->customers_basket_id,
                'products_options_id' => 1,
                'products_options_values_id' => $request->color_Att
            ]);
            DB::table('customers_basket_attributes')->insert([
                'customers_id' => $client_id,
                'products_id' => $request->product_id,
                'customers_basket_id' => $cart->customers_basket_id,
                'products_options_id' => 3,
                'products_options_values_id' => $request->color_Att1
            ]);
            $expire = time() + 60 * 60 * 24 * 30;
            $cookie = cookie('user_id',  $client_id, $expire);
            return redirect()->back()->withCookie($cookie);
        }
    }


    public function index(Request $request)
    {

        //LaravelLocalization::setLocale('en');
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id']
        ]);

        if ($validator->fails()) {

            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }


        $cart = Cart::where('customers_basket.customers_id', $request->user_id);
        // ->get() ->map(function ($row){


        //  return $row; });
        // dd($cart);

        if ($cart->exists()) {
            $items = $cart->get()->map(function ($row) {
                $CustomersBasketAttributes = CustomersBasketAttributes::where('customers_basket_id', $row->customers_basket_id)
                    ->leftjoin('products_options_values', 'customers_basket_attributes.products_options_values_id', 'products_options_values.products_options_values_id')
                    ->get();
                //dd($CustomersBasketAttributes);
                foreach ($CustomersBasketAttributes as $value) {
                    if ($value->products_options_id == 1) {
                        $row->color = $value->product_act_val;
                        $row->color_id = $value->products_options_values_id;
                    } else {
                        $row->size = $value->products_options_values_name;
                        $row->size_id = $value->products_options_values_id;
                    }
                }

                $product = Product::where('products_id', $row->products_id);
                $product1 = Product::find($row->products_id);
                $data = [];
                if ($product1->has('attributes'))
                    foreach ($product1->attributes as $option)
                        $data[$option->name()] = array();

                foreach ($product1->attributes as $option) {
                    array_push($data[$option->name()], [
                        'option_id' => $option->products_options_id,
                        'option_name' => $option->name(),
                        'option_value' => [
                            'value_id' => $option->pivot->options_values_id,
                            'value_name' => $option->valueName($option->pivot->options_values_id)
                        ]
                    ]);
                }
                $row->product_att = $data;
                if (LaravelLocalization::getCurrentLocale() == 'ar')
                    $lang = 4;
                else
                    $lang = 1;

                if ($product->exists()) {
                    //dd($product);
                    $product = $product->first();
                    $row->price = $row->final_price;
                    $row->quantity = $row->customers_basket_quantity;
                    $row->name = $product->description->products_name;
                    $row->image = URL::asset($product->mainImage->path());
                    $row->description = $product->description->products_description;
                    // $row->option_att=$optionatt;
                    return $row;
                } else {
                    $row->quantity = 0;
                    $row->name = '';
                    $row->image = '';
                    $row->description = '';
                    $row->option_att = '';
                    return $row;
                }
            });

            return response()->json($items);
        } else {
            $response['success'] = false;
            $response['messages'] = ["failedMessage" => 'No data found with this id=' . $request->user_id];
            return response()->json([], 200);
        }
    }
    public function bag()
    {
        $client_id = Auth::id();

        if ($client_id == null) {
            if (request()->cookie('user_id') == null) {
            } else {
                $client_id = request()->cookie('user_id');
            }
        }
        $cart = Cart::where('customers_basket.customers_id', $client_id);

        if ($cart->exists()) {
            $items = $cart->get()->map(function ($row) {
                $CustomersBasketAttributes = CustomersBasketAttributes::with(['products_options_values'])->where('customers_basket_id', $row->customers_basket_id)
                    ->get();
                // dd ($CustomersBasketAttributes);
                $option = array();
                $option_name = array();
                foreach ($CustomersBasketAttributes as $value) {

                    array_push($option, [$value->products_options_descriptions->options_name, $value->products_options_values->products_options_values_name, $value->products_options_id, $value->products_options_values_id]);
                    array_push($option_name, $value->products_options_values_id);
                }

                //$row->option_name=$option_name;
                $d = product_quantity_stock::where('product_id', $row->products_id)->where('is_active', 1)->get()->map(function ($row) use ($option_name) {
                    $row->d = $row->product_variations_group2($option_name);
                    if ($row->d === 0) {
                        return 0;
                    } else
                        return $row;
                });
                $final = "";
                foreach ($d as $d1) {
                    if ($d1 === 0) {
                    } else {
                        $final1 = store_product::where('product_quantity_stock_id', $d1->id)->where('store_id', 1)->first();
                        $final = $final1->quantity;
                    }
                    //$final=$d1->quantity;
                }
                $row->max_quantity = $final;
                $row->option = $option;

                $product = Product::where('products_id', $row->products_id);
                $product1 = Product::find($row->products_id);
                $data = [];

                if (LaravelLocalization::getCurrentLocale() == 'ar')
                    $lang = 4;
                else
                    $lang = 1;

                if ($product->exists()) {
                    //dd($product);
                    $product = $product->first();
                    $row->price = $row->final_price;
                    $row->quantity = $row->customers_basket_quantity;
                    $row->name = $product->description->products_name;
                    $row->image = URL::asset($product->mainImage->path());
                    $row->description = $product->description->products_description;
                    // $row->option_att=$optionatt;
                    return $row;
                } else {
                    $row->quantity = 0;
                    $row->name = '';
                    $row->image = '';
                    $row->description = '';
                    $row->option_att = '';
                    return $row;
                }
            });
            //return $items;
            return view('website.bag')->with(
                ['items' => $items]
            );
        } else {
            return view('website.empty-bag');
        }
    }
    public function index2(Request $request)
    {

        //LaravelLocalization::setLocale('en');
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id']
        ]);

        if ($validator->fails()) {

            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }


        $cart = Cart::where('customers_basket.customers_id', $request->user_id)
            ->leftjoin('customers_basket_attributes', 'customers_basket_attributes.customers_basket_id', 'customers_basket.customers_basket_id')
            ->select('customers_basket.customers_id as user_id', 'customers_basket.products_id as product_id', 'customers_basket.final_price as price', 'customers_basket.customers_basket_quantity as quantity', 'customers_basket_attributes.products_options_values_id as option_value_id', 'customers_basket_attributes.products_options_id as option_id');


        if ($cart->exists()) {
            $items = $cart->get()->map(function ($row) {
                $product = Product::where('products_id', $row->product_id);
                if (LaravelLocalization::getCurrentLocale() == 'ar')
                    $lang = 4;
                else
                    $lang = 1;
                $optionatt = DB::table('products_options_values')
                    ->join('products_options_values_descriptions', 'products_options_values.products_options_values_id', 'products_options_values_descriptions.products_options_values_id')
                    ->where('products_options_values.products_options_id', $row->option_id)
                    ->where('language_id', $lang)
                    ->where('products_options_values.products_options_values_id', $row->option_value_id)
                    ->get(['products_options_values_descriptions.options_values_name as value_name', 'products_options_values_descriptions.products_options_values_id as value_id'])->first()->value_name;

                if ($product->exists()) {
                    //dd($product);
                    $product = $product->first();
                    $row->name = $product->description->products_name;
                    $row->image = URL::asset($product->mainImage->path());
                    $row->description = $product->description->products_description;
                    $row->option_att = $optionatt;
                    return $row;
                } else {
                    $row->name = '';
                    $row->image = '';
                    $row->description = '';
                    $row->option_att = '';
                    return $row;
                }
            });

            return response()->json($items);
        } else {
            $response['success'] = false;
            $response['messages'] = ["failedMessage" => 'No data found with this id=' . $request->user_id];
            return response()->json([], 200);
        }
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $client_id = Auth::id();
        //product_variations_group
        $validator = Validator::make($request->all(), [
            //'user_id'=>['required','exists:users,id'],
            'product_id' => ['required', 'exists:products,products_id'],

        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('error', 'جدث خطا ما    ');
        }
        if ($client_id == null) {
            if (request()->cookie('user_id') == null) {
                $randomString = Str::random(10);
                $user = User::create([
                    'first_name' => "user_name",
                    'role_id' => 2,
                    'email' => $randomString . '@gmail.com'
                ]);
                $client_id = $user->id;
            } else {
                $client_id = request()->cookie('user_id');
            }
        }
        //////////check if availabl///////
        $option = $request->option;
        $product_quantity_stock = product_quantity_stock::where('product_quantity_stock.product_id', $request->product_id)
            ->join('store_product', 'product_quantity_stock.id', '=', 'store_product.product_quantity_stock_id')
            ->where('is_active', 1)->where('store_product.store_id', 1)->pluck('product_quantity_stock.id')->all();
        foreach ($product_quantity_stock as $product_q_s) {
            $optionarray[$product_q_s] = array();
            $product_variations_group = product_variations_group::where('product_quantity_stock_id', $product_q_s)->select('options_id', 'options_values_id')->orderBy('options_id', 'ASC')->get();

            foreach ($product_variations_group as $product_variations_group1) {


                array_push($optionarray[$product_q_s], $product_variations_group1);
            }
            $only_val = array();
            $optionarray12 = array();
            foreach ($option as $id => $details) {

                array_push($only_val, $details);
                array_push($optionarray12, [$id, (int)$details]);
            }
            $d = product_quantity_stock::where('product_id', $request->product_id)->where('is_active', 1)->get()->map(function ($row) use ($only_val) {
                $row->d = $row->product_variations_group2($only_val);
                if ($row->d === 0) {
                    return 0;
                } else
                    return $row;
            });
            $final = "";
            // return $d;
            foreach ($d as $d1) {
                if ($d1 === 0) {
                } else {
                    $final1 = store_product::where('product_quantity_stock_id', $d1->id)->where('store_id', 1)->first();
                    $final = $final1->quantity;
                }
            }
            // return response()->json(['code'=>1,'msg'=>$final]); 
            $optionarray11 = array();
            foreach ($optionarray as $id1 => $details1) {
                $optionarray111 = array();
                foreach ($details1 as $value1) {
                    array_push($optionarray111, [$value1->options_id, $value1->options_values_id]);
                }
                array_push($optionarray11, $optionarray111);
            }
            if (in_array($optionarray12, $optionarray11)) {
                //return response()->json(['code'=>1,'msg'=>'done']);
            } else
                return response()->json(['code' => 0, 'error' => 'check available products !!']);

            //////////////end check if availabl/////////////////




            $product = Product::find($request->product_id);
            $cart = DB::table('customers_basket')->where('customers_id', $client_id)->where('products_id', $request->product_id)->get();
            // return response()->json(['code'=>1,'msg'=>$cart]);
            $checkcart = 0;
            foreach ($cart as $ca) {
                $customers_basket_attributes = CustomersBasketAttributes::where('customers_basket_id', $ca->customers_basket_id)->whereIn('products_options_values_id', $only_val);

                if ($customers_basket_attributes->exists()) {
                    if ($customers_basket_attributes->count() == Count($only_val)) {
                        $checkcart = 1;
                        $cart_id = $ca->customers_basket_id;
                    }
                };
            }
            // $cart = DB::table('customers_basket')->where('customers_basket.customers_id',$client_id)
            //     ->leftjoin('customers_basket_attributes as color','color.customers_basket_id','customers_basket.customers_basket_id')
            //     ->where('customers_basket.products_id',$request->product_id)
            //     ->where('color.products_options_values_id',$request->color_Att)
            //     ->where('color.products_options_id',1)
            //     ->leftjoin('customers_basket_attributes as size','size.customers_basket_id','customers_basket.customers_basket_id')
            //     ->where('customers_basket.products_id',$request->product_id)
            //     ->where('size.products_options_values_id',$request->color_Att1)
            //     ->where('size.products_options_id',3);
            //  ->get();




            // dd($cart);
            if ($checkcart == 1) {
                $cart = DB::table('customers_basket')->where('customers_basket_id', $cart_id);

                if ($cart->first()->customers_basket_quantity < $final) {
                    $cart->update(['customers_basket.customers_basket_quantity' => DB::raw('customers_basket.customers_basket_quantity + 1')]);
                    $response['success'] = true;
                    $response['messages'] = ['successMessage' => "record updated successfully"];
                    $expire = time() + 60 * 60 * 24 * 30;
                    $cookie = cookie('user_id',  $client_id, $expire);
                    return redirect()->back()->withCookie($cookie);
                } else  return response()->json(['code' => 0, 'error' => 'You added all available to your cart!!']);
            } else {

                $cart = Cart::create(
                    [
                        'customers_id' => $client_id,
                        'products_id' => $request->product_id,
                        'customers_basket_quantity' => 1,
                        'final_price' => $product->products_price
                    ]
                );



                foreach ($option as $id => $details) {
                    DB::table('customers_basket_attributes')->insert([
                        'customers_id' => $client_id,
                        'products_id' => $request->product_id,
                        'customers_basket_id' => $cart->customers_basket_id,
                        'products_options_id' => $id,
                        'products_options_values_id' => $details
                    ]);
                }
                $expire = time() + 60 * 60 * 24 * 30;
                $cookie = cookie('user_id',  $client_id, $expire);
                return response()->json(['code' => 1, 'msg' => 'done'])->withCookie($cookie);
            }
        }
    }
    public function store2(Request $request)
    {
        //dd($request->all());
        $client_id = $request->id;

        $product = Product::find($request->product_id);
        if ($request->color_Att1 == "") {
            $cart = DB::table('customers_basket')->where('customers_basket.customers_id', $client_id)
                ->leftjoin('customers_basket_attributes as color', 'color.customers_basket_id', 'customers_basket.customers_basket_id')
                ->where('customers_basket.products_id', $request->product_id)
                ->where('color.products_options_values_id', $request->color_Att)
                ->where('color.products_options_id', 1);
            // ->get();
        } else {
            $cart = DB::table('customers_basket')->where('customers_basket.customers_id', $client_id)
                ->leftjoin('customers_basket_attributes as color', 'color.customers_basket_id', 'customers_basket.customers_basket_id')
                ->where('customers_basket.products_id', $request->product_id)
                ->where('color.products_options_values_id', $request->color_Att)
                ->where('color.products_options_id', 1)
                ->leftjoin('customers_basket_attributes as size', 'size.customers_basket_id', 'customers_basket.customers_basket_id')
                ->where('customers_basket.products_id', $request->product_id)
                ->where('size.products_options_values_id', $request->color_Att1)
                ->where('size.products_options_id', 3);
            //  ->get();
        }

        if ($cart->exists()) {
            $cart->update(['customers_basket.customers_basket_quantity' => DB::raw('customers_basket.customers_basket_quantity + 1')]);
            $response['success'] = true;
            $response['messages'] = ['successMessage' => "record updated successfully"];
            $expire = time() + 60 * 60 * 24 * 30;
            $cookie = cookie('user_id',  $client_id, $expire);
            return response()->json(['r' => 1])->withCookie($cookie);
        } else {

            $cart = Cart::create(
                [
                    'customers_id' => $client_id,
                    'products_id' => $request->product_id,
                    'customers_basket_quantity' => 1,
                    'final_price' => $product->products_price
                ]
            );




            if ($request->color_Att != "") {
                DB::table('customers_basket_attributes')->insert([
                    'customers_id' => $client_id,
                    'products_id' => $request->product_id,
                    'customers_basket_id' => $cart->customers_basket_id,
                    'products_options_id' => 1,
                    'products_options_values_id' => $request->color_Att
                ]);
            }
            if ($request->color_Att1 != "") {
                DB::table('customers_basket_attributes')->insert([
                    'customers_id' => $client_id,
                    'products_id' => $request->product_id,
                    'customers_basket_id' => $cart->customers_basket_id,
                    'products_options_id' => 3,
                    'products_options_values_id' => $request->color_Att1
                ]);
            }
            $expire = time() + 60 * 60 * 24 * 30;
            $cookie = cookie('user_id',  $client_id, $expire);
            return response()->json(['r' => 1])->withCookie($cookie);
            // return back()->withCookie($cookie);
        }
    }
    public function check_user()
    {
        $client_id = Auth::id();
        if ($client_id == null) {
            if (request()->cookie('user_id') == null) {
                $randomString = Str::random(10);
                $user = User::create([
                    'first_name' => "user_name",
                    'role_id' => 2,
                    'email' => $randomString . '@gmail.com'
                ]);
                $client_id = $user->id;
            } else {
                $client_id = request()->cookie('user_id');
            }
        }
        $expire = time() + 60 * 60 * 24 * 30;
        $cookie = cookie('user_id',  $client_id, $expire);

        return response()->json($client_id)->withCookie($cookie);
    }
    public function update_quantity(Request $request)
    {
        //dd($request->all());
        $client_id = Auth::id();

        if ($client_id == null) {
            if (request()->cookie('user_id') == null) {
                $randomString = Str::random(10);
                $user = User::create([
                    'first_name' => "user_name",
                    'role_id' => 2,
                    'email' => $randomString . '@gmail.com'
                ]);
                $client_id = $user->id;
            } else {
                $client_id = request()->cookie('user_id');
            }
        }
        // $product = Product::find($request->product_id);

        $cart = DB::table('customers_basket')->where('customers_basket_id', $request->customers_basket_id);
        //dd($cart->exists());
        if ($cart->exists()) {
            $cart->update(['customers_basket.customers_basket_quantity' => DB::raw('customers_basket.customers_basket_quantity ' . $request->opration . ' 1')]);
            $response['success'] = true;
            $response['messages'] = ['successMessage' => "record updated successfully"];
            return redirect()->back()->with('success', 'تم التعديل بنجاح      ');
        }
    }
    public function update_color(Request $request)
    {
        $cart_att = DB::table('customers_basket_attributes')->where('customers_basket_id', $request->customers_basket_id)->where('products_options_id', 1);
        if ($cart_att->exists()) {
            $cart_att->update([
                'products_options_values_id' => $request->color
            ]);
            $response['success'] = true;
            $response['messages'] = ['successMessage' => "record updated successfully"];
            return redirect()->back()->with('success', 'تم التعديل بنجاح      ');
        }
    }
    public function update_size(Request $request)
    {
        $cart_att = DB::table('customers_basket_attributes')->where('customers_basket_id', $request->customers_basket_id)->where('products_options_id', 3);
        if ($cart_att->exists()) {
            $cart_att->update([
                'products_options_values_id' => $request->size
            ]);
            $response['success'] = true;
            $response['messages'] = ['successMessage' => "record updated successfully"];
            return redirect()->back()->with('success', 'تم التعديل بنجاح      ');
        }
    }
    public function destroy(Request $request)
    {
        $client_id = Auth::id();

        $validator = Validator::make($request->all(), [
            'customers_basket_id' => ['required'],

        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('error', 'جدث خطا ما    ');
        }
        if ($client_id == null) {
            if (request()->cookie('user_id') == null) {
            } else {
                $client_id = request()->cookie('user_id');
            }
        }

        $cart = DB::table('customers_basket')->where('customers_basket_id', $request->customers_basket_id);
        $cart_att = DB::table('customers_basket_attributes')->where('customers_basket_id', $request->customers_basket_id);

        if ($cart->exists()) {
            $cart->delete();
            $cart_att->delete();

            return redirect()->back()->with('success', 'تم الحذف بنجاح      ');
        } else {

            return redirect()->back()->with('error', ' لم يتم الحذف      ');
        }
    }
    //////////////////
    public function storeInDashboard(Request $request)
    {
        //dd($request->all());
        $client_id = Auth::id();

        $validator = Validator::make($request->all(), [
            //'user_id'=>['required','exists:users,id'],
            'product_id' => ['required', 'exists:products,products_id'],
            //'product_quantity'=>['required','numeric','min:1'],
            // 'color_Att'=>['required'],
            // 'color_Att1'=>['required']
            //SIZE ATT
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('error', 'جدث خطا ما    ');
        }
        if ($client_id == null) {
            if (request()->cookie('user_id') == null) {
                $randomString = Str::random(10);
                $user = User::create([
                    'first_name' => "user_name",
                    'role_id' => 2,
                    'email' => $randomString . '@gmail.com'
                ]);
                $client_id = $user->id;
            } else {
                $client_id = request()->cookie('user_id');
            }
        }
        $product = Product::find($request->product_id);
        $color_id = 'color_Att' . ($request->product_id);
        if ($request->color_Att1 == "") {
            $cart = DB::table('customers_basket')->where('customers_basket.customers_id', $client_id)
                ->leftjoin('customers_basket_attributes as color', 'color.customers_basket_id', 'customers_basket.customers_basket_id')
                ->where('customers_basket.products_id', $request->product_id)
                ->where('color.products_options_values_id', $request->$color_id)
                ->where('color.products_options_id', 1);
            // ->get();
        } else {
            $cart = DB::table('customers_basket')->where('customers_basket.customers_id', $client_id)
                ->leftjoin('customers_basket_attributes as color', 'color.customers_basket_id', 'customers_basket.customers_basket_id')
                ->where('customers_basket.products_id', $request->product_id)
                ->where('color.products_options_values_id', $request->$color_id)
                ->where('color.products_options_id', 1)
                ->leftjoin('customers_basket_attributes as size', 'size.customers_basket_id', 'customers_basket.customers_basket_id')
                ->where('customers_basket.products_id', $request->product_id)
                ->where('size.products_options_values_id', $request->color_Att1)
                ->where('size.products_options_id', 3);
            //  ->get();
        }



        // dd($cart);
        if ($cart->exists()) {
            $cart->update(['customers_basket.customers_basket_quantity' => DB::raw('customers_basket.customers_basket_quantity + 1')]);
            $response['success'] = true;
            $response['messages'] = ['successMessage' => "record updated successfully"];
            $expire = time() + 60 * 60 * 24 * 30;
            $cookie = cookie('user_id',  $client_id, $expire);
            return redirect()->back()->withCookie($cookie);
        } else {

            $cart = Cart::create(
                [
                    'customers_id' => $client_id,
                    'products_id' => $request->product_id,
                    'customers_basket_quantity' => 1,
                    'final_price' => $product->products_price
                ]
            );


            if ($request->$color_id != "") {
                DB::table('customers_basket_attributes')->insert([
                    'customers_id' => $client_id,
                    'products_id' => $request->product_id,
                    'customers_basket_id' => $cart->customers_basket_id,
                    'products_options_id' => 1,
                    'products_options_values_id' => $request->$color_id
                ]);
            }
            if ($request->color_Att1 != "") {
                DB::table('customers_basket_attributes')->insert([
                    'customers_id' => $client_id,
                    'products_id' => $request->product_id,
                    'customers_basket_id' => $cart->customers_basket_id,
                    'products_options_id' => 3,
                    'products_options_values_id' => $request->color_Att1
                ]);
            }
            $expire = time() + 60 * 60 * 24 * 30;
            $cookie = cookie('user_id',  $client_id, $expire);
            return redirect()->back()->withCookie($cookie);
        }
    }
}
