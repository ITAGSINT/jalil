<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\customers_basket;
use App\Models\Product;
use App\Models\product_quantity_stock;
use App\Models\product_variations_group;
use App\Models\ProductOption;
use App\Models\store_product;
use App\Scopes\LangScope;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;


class CartController extends Controller
{
    //
    public $lang = 4;


    public  function  __construct(Request $request)
    {
        if ($request->lang)
            $this->lang = $request->lang;
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


        $cart = Cart::where('customers_basket.customers_id', $request->user_id)
            ->select('customers_basket.customers_basket_id as cart_id', 'customers_basket.customers_id as user_id', 'customers_basket.products_id as product_id', 'customers_basket.final_price as price', 'customers_basket.customers_basket_quantity as quantity');

        // ->leftjoin('customers_basket_attributes', 'customers_basket_attributes.customers_basket_id', 'customers_basket.customers_basket_id')
        //     ->select('customers_basket.customers_id as user_id', 'customers_basket.products_id as product_id', 'customers_basket.final_price as price', 'customers_basket.customers_basket_quantity as quantity', 'customers_basket_attributes.products_options_values_id as option_value_id', 'customers_basket_attributes.products_options_id as option_id');

        //return $cart->get();
        if ($cart->exists()) {
            $items = $cart->get()->map(function ($row) {
                // return $row->cart_id;
                $product = Product::where('products_id', $row->product_id);
                if ($product->exists()) {
                    $product = $product->first();
                    $row->name = $product->descriptionFE->where('language_id', $this->lang)->first()->products_name;
                    $row->image = URL::asset($product->mainImage->path());




                    //return all the options values id like gold for color and xl for size
                    $product_option_values = DB::table('customers_basket_attributes')
                        // ->join('products_options', 'products_options.products_options_id', '=', 'customers_basket_attributes.products_options_id')
                        ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'customers_basket_attributes.products_options_id')

                        // ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'customers_basket_attributes.products_options_values_id')
                        ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'customers_basket_attributes.products_options_values_id')

                        ->select('customers_basket_attributes.products_options_values_id', 'products_options_descriptions.*',  'products_options_values_descriptions.options_values_name')
                        ->where('customers_basket_attributes.customers_basket_id', $row->cart_id)
                        ->where('products_options_descriptions.language_id', $this->lang)
                        ->where('products_options_values_descriptions.language_id', $this->lang)
                        // ->where('customers_basket_attributes.products_id', $row->product_id)
                        ->get();
                    // return $product_option_values;
                    $attributes = [];
                    foreach ($product_option_values as $option) {
                        $product_options = DB::table('products_attributes')
                            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
                            ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_attributes.options_values_id')
                            ->select('products_attributes.options_values_id as option_id', 'products_options_values_descriptions.options_values_name')
                            ->where('products_attributes.products_id', $row->product_id)
                            ->where('products_attributes.options_id', $option->products_options_id)
                            ->where('language_id', $this->lang)
                            ->get();



                        $at['attr_id'] = $option->products_options_id;
                       // $at['attr_name'] = $option->options_name;
                       // $at['attr_options'] = $product_options;
                        $at['selected_attr_name'] = $option->options_name;
                        $at['selected_value_id'] = $option->products_options_values_id;
                        $at['selected_value_name'] = $option->options_values_name;
                        array_push($attributes, $at);
                        //  return $product_options;

                    }


                    $product_quantity_stock = product_quantity_stock::where('product_quantity_stock.product_id', $row->product_id)
                        ->join('store_product', 'product_quantity_stock.id', '=', 'store_product.product_quantity_stock_id')

                        ->where('is_active', 1)->where('store_product.quantity', '>', 0)->where('store_product.store_id', 1)->select('product_quantity_stock.id', 'store_product.quantity')->get();

                    //foreach product variation get the varaiton values and store in array
                    foreach ($product_quantity_stock as $product_q_s) {

                        $attrbuite_array[$product_q_s->id] = array();
                        $product_variations_group = product_variations_group::join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'product_variations_group.options_id')


                            ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'product_variations_group.options_values_id')
                            ->where('products_options_values_descriptions.language_id', $this->lang)
                            ->where('products_options_descriptions.language_id', $this->lang)
                            ->where('product_quantity_stock_id', $product_q_s->id)->select('options_id', 'options_values_id', 'options_name', 'options_values_name')->orderBy('options_id', 'ASC')->get();
                        //  array_push($attrbuite_quantity_array, $product_q_s->quantity);
                        foreach ($product_variations_group as $product_variations_group1) {


                            array_push($attrbuite_array[$product_q_s->id], $product_variations_group1);
                        }
                    }
                    // return $attrbuite_array;
                    $row->attributes = $attributes;
                    $row->other_attributes = $attrbuite_array;
                    return $row;
                } else {
                    $row->name = '';
                    $row->image = '';
                    return $row;
                }
            });


            $response['success'] = true;
            $response['data'] = $items;

            return response()->json([$response], 200);
        } else {
            $response['success'] = false;
            $response['messages'] = ["failedMessage" => 'No data found with this id=' . $request->user_id];
            return response()->json([], 200);
        }
    }

    public function store(Request $request)
    {

        //*************vaildation*************
        {  //basic rules for all products
            $rules = [
                'user_id' => ['required', 'exists:users,id'],
                'product_id' => ['required', 'exists:products,products_id'],
                'product_quantity' => ['required', 'numeric', 'min:1'],

            ];
            $messages = [];
            //return all the available options id like color and size
            $product_options = DB::table('products_attributes')
                ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                ->select('products_attributes.options_id', 'products_options.products_options_name')
                ->where('products_attributes.products_id', $request->product_id)
                ->distinct('products_attributes.options_id')
                ->get();

            //return all the options values id like gold for color and xl for size
            // $product_option_values = DB::table('products_attributes')
            //     ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            //     ->select('products_attributes.options_values_id')
            //     ->where('products_attributes.products_id', $request->product_id)
            //     ->get();

            //add rules for all options where it is required and the value of option exists for this product and this option
            foreach ($product_options as $option) {
                $rules["attr"] = ["required", "array", "min:1"];
                $rules['attr.' . $option->options_id . ''] = [
                    'required',
                    Rule::exists('products_attributes', 'options_values_id')
                        ->where('products_id', $request->product_id)
                        ->where('options_id', $option->options_id),
                    // 'exists:products_options_values,products_options_values_id,products_options_id,'
                ];

                $messages['attr.' . $option->options_id . '.required'] = '' . strtolower($option->products_options_name) . ' attribute is required.';
                $messages['attr.' . $option->options_id . '.exists'] = 'The selected ' . strtolower($option->products_options_name) . ' value is invalid.';
            }

            //return $rules;
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {

                $response['success'] = false;
                $response['messages'] = $validator->errors();

                return response()->json([$response], 400);
            }
        }
        //end vaildation


        //*****check product varations avallabilty***********
        {
            $attrbuite = $request->attr;
            $attrbuite_quantity_array = [];
            //return product varaitions ids that are greater than 0 in quantity
            $product_quantity_stock = product_quantity_stock::where('product_quantity_stock.product_id', $request->product_id)
                ->join('store_product', 'product_quantity_stock.id', '=', 'store_product.product_quantity_stock_id')
                ->where('is_active', 1)->where('store_product.quantity', '>', 0)->where('store_product.store_id', 1)->select('product_quantity_stock.id', 'store_product.quantity')->get();

            //foreach product variation get the varaiton values and store in array
            foreach ($product_quantity_stock as $product_q_s) {

                $attrbuite_array[$product_q_s->id] = array();
                $product_variations_group = product_variations_group::where('product_quantity_stock_id', $product_q_s->id)->select('options_id', 'options_values_id')->orderBy('options_id', 'ASC')->get();
                array_push($attrbuite_quantity_array, $product_q_s->quantity);
                foreach ($product_variations_group as $product_variations_group1) {


                    array_push($attrbuite_array[$product_q_s->id], $product_variations_group1);
                }
            }
            //return $attrbuite_quantity_array[0];

            //put request attrbuite values in array
            $only_val = array();
            $attrbuite_array12 = array();
            foreach ($attrbuite as $id => $details) {

                array_push($only_val, $details);
                array_push($attrbuite_array12, [$id, (int)$details]);
            }

            //return $attrbuite_array12;
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
            //return response()->json(['code'=>1,'msg'=>$final1]); 
            //push available product attributes in array
            $attrbuite_array11 = array();
            foreach ($attrbuite_array as $id1 => $details1) {
                $attrbuite_array111 = array();
                foreach ($details1 as $value1) {
                    array_push($attrbuite_array111, [$value1->options_id, $value1->options_values_id]);
                }
                array_push($attrbuite_array11, $attrbuite_array111);
            }
            //return $attrbuite_array;
            //check if request attributes are in avaliable  attributes
            if (in_array($attrbuite_array12, $attrbuite_array11)) {

                //if requested variation is available check if requested quantity is available too
                $selected_varation_key = array_search($attrbuite_array12, $attrbuite_array11);
                if ($attrbuite_quantity_array[$selected_varation_key] >= $request->product_quantity) {
                    //   return response()->json(['code'=>1,'msg'=>'done']);
                } else return response()->json(['code' => 0, 'error' => 'requested quantity is bigger than available quanitity in stock !!']);
                //   return response()->json(['code'=>1,'msg'=>'done']);
            } else
                return response()->json(['code' => 0, 'error' => 'check available products !!']);
        }
        //***** end check product varations avallabilty***********

        $product = Product::find($request->product_id);

        $cart = DB::table('customers_basket')->where('customers_basket.customers_id', $request->user_id)
            ->select('customers_basket.*');

        foreach ($product_options as $option) {
            $table_name = strtolower($option->products_options_name);
            $cart->leftjoin('customers_basket_attributes as ' . $table_name . '', '' . $table_name . '.customers_basket_id', 'customers_basket.customers_basket_id')

                ->addSelect('' . $table_name . '.customers_basket_attributes_id as ' . $table_name . '', '' . $table_name . '.products_options_id as ' . $table_name . '_id', '' . $table_name . '.products_options_values_id as ' . $table_name . '_value_id')
                ->where('customers_basket.products_id', $request->product_id)
                ->where('' . $table_name . '.products_options_values_id', $request->attr[$option->options_id])
                ->where('' . $table_name . '.products_options_id', $option->options_id);
        }

        if ($cart->exists()) {
            // return  $attrbuite_quantity_array[$selected_varation_key];

            if ($request->product_quantity > $attrbuite_quantity_array[$selected_varation_key])
                return    response()->json(['code' => 0, 'error' => 'You added all available to your cart!!']);
            else {
                $cart->update(['customers_basket.customers_basket_quantity' => DB::raw($request->product_quantity)]);
                $response['success'] = true;
                $response['messages'] = ['successMessage' => "record updated successfully"];
                return response()->json([$response], 200);
            }
        } else {

            $cart = Cart::create(
                [
                    'customers_id' => $request->user_id,
                    'products_id' => $request->product_id,
                    'customers_basket_quantity' => $request->product_quantity,
                    'final_price' => $product->products_price
                ]
            );


            //insert each attribute into customers_basket_attributes table
            foreach ($product_options as $option) {

                DB::table('customers_basket_attributes')->insert([
                    'customers_id' => $request->user_id,
                    'products_id' => $request->product_id,
                    'customers_basket_id' => $cart->customers_basket_id,
                    'products_options_id' => $option->options_id,
                    'products_options_values_id' => $request->attr[$option->options_id]
                ]);
            }

            $response['success'] = true;
            $response['data'] = $cart;
            $response['messages'] = ['successMessage' => 'Record added successfully'];
            return response()->json([$response], 200);
        }
    }

    public function destroy(Request $request)
    {
        //*************vaildation*************
        {  //basic rules for all products
            $rules = [
                'user_id' => ['required', 'exists:users,id'],
                'cart_id' => ['required', 'exists:customers_basket,customers_basket_id'],
            ];


            //return $rules;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $response['success'] = false;
                $response['messages'] = $validator->errors();

                return response()->json([$response], 400);
            }
        }
        //end vaildation



        $cart = customers_basket::find($request->cart_id);


        if ($cart->exists()) {
            // return 'here';
            $cart->cart_attribute()->delete();
            $cart->delete();
            $response['success'] = true;
            $response['messages'] = ['successMessage' => "record deleted successfully"];
            return response()->json([$response], 200);
        } else {
            $response['success'] = false;
            $response['messages'] = ['failedMessage' => "No data found"];
            return response()->json([$response], 400);
        }
    }

    public function update_cart(Request $request)
    {
        //*************vaildation*************
        {  //basic rules for all products
            $rules = [
                'user_id' => ['required', 'exists:users,id'],
                'cart_id' => ['required', 'exists:customers_basket,customers_basket_id'],
                'quantity' => ['required', 'numeric', 'min:1'],
                'attr' => ['required', 'array', 'min:0']
            ];
            //attr min is 0 if the product does not have any attrbuites

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $response['success'] = false;
                $response['messages'] = $validator->errors();

                return response()->json([$response], 400);
            }

            $cart = Cart::find($request->cart_id);
            //get all product attributes;
            $product_options = DB::table('products_attributes')
                ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                ->select('products_attributes.options_id', 'products_options.products_options_name')
                ->where('products_attributes.products_id', $cart->products_id)
                ->distinct('products_attributes.options_id')
                ->get();

            //add rules for all attrbuites where it is required and the value of attrbuite exists for this product and this attrbuite
            $att_rules = [];
            // return $request->attr;
            if ($request->attr != [null]) {
                foreach ($request->attr as $key => $attr) {
                    //     $rules["attr"] = ["required", "array", "min:1"];
                    $att_rules['attr.' . $key . ''] = [
                        'required',
                        Rule::exists('products_attributes', 'options_values_id')
                            ->where('products_id', $cart->products_id)
                            ->where('options_id', $key),
                        // 'exists:products_options_values,products_options_values_id,products_options_id,'
                    ];

                    $attr_name = $product_options->where('options_id', $key)->first()->products_options_name;
                    $messages['attr.' . $key . '.required'] = '' . $attr_name . ' attribute is required.';
                    $messages['attr.' . $key . '.exists'] = 'The selected ' . $attr_name . ' value is invalid.';
                }




                $att_validator = Validator::make($request->all(), $att_rules, $messages);


                if ($att_validator->fails()) {

                    $response['success'] = false;
                    $response['messages'] = $att_validator->errors();

                    return response()->json([$response], 400);
                }
            }
        }


        //end vaildation
        //*****check product varations avallabilty***********
        if ($request->attr != [null]) {
            $attrbuite = $request->attr;
            // return array_values($attrbuite);
            $original_attr = $cart->cartAttributes()->whereNotIn('products_options_values_id', array_values($attrbuite))->get();

            if ($original_attr->count()) {
                //return array_values($attrbuite);
                //used to be a loop for assiging original values to $attrbuite
                // foreach ($original_attr as $key => $attr) {
                //     $attrbuite[$attr->products_options_id] = $attr->products_options_values_id;
                // }

                //return $attrbuite;
                //return product varaitions ids that are greater than 0 in quantity
                $product_quantity_stock = product_quantity_stock::where('product_quantity_stock.product_id', $cart->products_id)
                    ->join('store_product', 'product_quantity_stock.id', '=', 'store_product.product_quantity_stock_id')
                    ->where('is_active', 1)->where('store_product.quantity', '>', 0)->where('store_product.store_id', 1)->select('product_quantity_stock.id', 'store_product.quantity')->get();

                //foreach product variation get the varaiton values and store in array
                foreach ($product_quantity_stock as $product_q_s) {

                    $attrbuite_array[$product_q_s->id] = array();
                    $product_variations_group = product_variations_group::where('product_quantity_stock_id', $product_q_s->id)->select('options_id', 'options_values_id')->orderBy('options_id', 'ASC')->get();
                    foreach ($product_variations_group as $product_variations_group1) {


                        array_push($attrbuite_array[$product_q_s->id], $product_variations_group1);
                    }
                }


                //put request attrbuite values in array
                $only_val = array();
                $attrbuite_array12 = array();
                foreach ($attrbuite as $id => $details) {

                    array_push($only_val, $details);
                    array_push($attrbuite_array12, [$id, (int)$details]);
                }

                //return $attrbuite_array12;
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
                //return response()->json(['code'=>1,'msg'=>$final1]); 
                //push available product attributes in array
                $attrbuite_array11 = array();
                foreach ($attrbuite_array as $id1 => $details1) {
                    $attrbuite_array111 = array();
                    foreach ($details1 as $value1) {
                        array_push($attrbuite_array111, [$value1->options_id, $value1->options_values_id]);
                    }
                    array_push($attrbuite_array11, $attrbuite_array111);
                }
                //return $attrbuite_array;
                //check if request attributes are in avaliable  attributes
                if (in_array($attrbuite_array12, $attrbuite_array11)) {
                    //   return response()->json(['code'=>1,'msg'=>'done']);
                } else
                    return response()->json(['code' => 0, 'error' => 'check available products !!']);
            }
        }
        //***** end check product varations avallabilty***********


        //************quantity and attributes update ****************

        if ($cart->customers_basket_quantity != $request->quantity && $original_attr->count()) {
            $carts = Cart::with('cartAttributes')->where('customers_id', $request->user_id)->where('products_id', $cart->products_id)->where('customers_basket_id', '!=', $request->cart_id)->get();
            //check if there is an identcal cart (with same attributes)
            if ($carts->isEmpty()) {
                //return $cart;
                $req3 = ['user_id' => $request->user_id, 'product_id' => $cart->products_id, 'product_quantity' => $request->quantity, 'attr' => $attrbuite];
                $req3 = new Request($req3);
                $res =  $this->store($req3);
                if ($res->status() == 200) {
                    $req2 = ['user_id' => $request->user_id, 'cart_id' => $request->cart_id];
                    $req2 = new Request($req2);
                    $res2 = $this->destroy($req2);
                    if ($res2->status() == 400) {
                        $response['error'] = true;
                        $response['messages'] = ['errorMessage' => $res2->getData()->error];
                        return response()->json([$response], 400);
                    } else {
                        $response['success'] = true;
                        $response['messages'] = ['successMessage' => "current cart deleted and a new cart was created successfully"];
                        return response()->json([$response], 200);
                    }
                } else {
                    $response['error'] = true;
                    $response['messages'] = ['errorMessage' => "something went wrong"];
                    return response()->json([$response], 400);
                }
            } else {
                //return 'there is ';
                foreach ($carts as $cart2) {
                    //return $cart2->cartAttributes;
                    $carts_array[$cart2->customers_basket_id] = [];

                    foreach ($cart2->cartAttributes as $cart_attrbuite) {

                        $cart_array[$cart_attrbuite->products_options_id] = $cart_attrbuite->products_options_values_id;
                    }
                    array_push($carts_array[$cart2->customers_basket_id], $cart_array);
                }


                foreach ($carts_array as $key => $cart_test) {

                    if (in_array($attrbuite, $cart_test)) {
                        // return 'found it';
                        //  return  Cart::find($key)->customers_basket_quantity;
                        $req = ['user_id' => $request->user_id, 'cart_id' => $key, 'quantity' => $request->quantity + Cart::find($key)->customers_basket_quantity, 'attr' => $attrbuite];
                        $req = new Request($req);
                        $res =  $this->update_cart($req);

                        if ($res->status() == 400) {
                            //order more than stock quantity
                            $response['error'] = true;
                            $response['messages'] = ['errorMessage' => $res->getData()->error];
                            return response()->json([$response], 400);
                        } else {
                            // quantity in twin cart updated and going to delete old cart;
                            $req2 = ['user_id' => $request->user_id, 'cart_id' => $request->cart_id];
                            $req2 = new Request($req2);
                            $res2 = $this->destroy($req2);
                            if ($res2->status() == 400) {
                                $response['error'] = true;
                                $response['messages'] = ['errorMessage' => $res2->getData()->error];
                                return response()->json([$response], 400);
                            } else {
                                $response['success'] = true;
                                $response['messages'] = ['successMessage' => "current cart deleted and quantity was added to identical cart successfully"];
                                return response()->json([$response], 200);
                            }
                        }
                    } else {

                        foreach ($request->attr as $key => $value) {
                            $cart_attr = $cart->cartAttributes()->where('products_options_id', $key)->first();
                            $cart_attr->products_options_values_id = $value;
                            $cart_attr->save();
                        }
                    }
                    // return $cart_test;
                }
            }
            $response['success'] = true;
            $response['messages'] = ['successMessage' => "cart attributes and quantity updated successfully"];
            return response()->json([$response], 200);
        }

        //******************update attributes***************
        if ($original_attr->count()) {


            $carts = Cart::with('cartAttributes')->where('customers_id', $request->user_id)->where('products_id', $cart->products_id)->where('customers_basket_id', '!=', $request->cart_id)->get();
            //check if there is an identcal cart (with same attributes)
            if ($carts->isEmpty()) {
                foreach ($request->attr as $key => $value) {
                    $cart_attr = $cart->cartAttributes()->where('products_options_id', $key)->first();
                    $cart_attr->products_options_values_id = $value;
                    $cart_attr->save();
                }
            } else {

                foreach ($carts as $cart2) {
                    //return $cart2->cartAttributes;
                    $carts_array[$cart2->customers_basket_id] = [];

                    foreach ($cart2->cartAttributes as $cart_attrbuite) {

                        $cart_array[$cart_attrbuite->products_options_id] = $cart_attrbuite->products_options_values_id;
                    }
                    array_push($carts_array[$cart2->customers_basket_id], $cart_array);
                }


                foreach ($carts_array as $key => $cart_test) {

                    if (in_array($attrbuite, $cart_test)) {
                        // return 'found it';
                        //  return  Cart::find($key)->customers_basket_quantity;
                        $req = ['user_id' => $request->user_id, 'cart_id' => $key, 'quantity' => $request->quantity + Cart::find($key)->customers_basket_quantity, 'attr' => $attrbuite];
                        $req = new Request($req);
                        $res =  $this->update_cart($req);

                        if ($res->status() == 400) {
                            //order more than stock quantity
                            $response['error'] = true;
                            $response['messages'] = ['errorMessage' => $res->getData()->error];
                            return response()->json([$response], 400);
                        } else {
                            // quantity in tein cart updated and going to delete old cart;
                            $req2 = ['user_id' => $request->user_id, 'cart_id' => $request->cart_id];
                            $req2 = new Request($req2);
                            $res2 = $this->destroy($req2);
                            if ($res2->status() == 400) {
                                $response['error'] = true;
                                $response['messages'] = ['errorMessage' => $res2->getData()->error];
                                return response()->json([$response], 400);
                            } else {
                                $response['success'] = true;
                                $response['messages'] = ['successMessage' => "current cart deleted and quantity was added to identical cart successfully"];
                                return response()->json([$response], 200);
                            }
                        }
                    } else {

                        foreach ($request->attr as $key => $value) {
                            $cart_attr = $cart->cartAttributes()->where('products_options_id', $key)->first();
                            $cart_attr->products_options_values_id = $value;
                            $cart_attr->save();
                        }
                    }
                    // return $cart_test;
                }
            }

            //return $cart;

            //return $attrbuite;
            // return $cart->cartAttributes()->where('products_options_id', '!=', array_keys($attrbuite))->get();
            //  $cart_attrbuites=Cart
            // $cart->customers_basket_quantity = $request->quantity;
            //  $cart->save();
            $response['success'] = true;
            $response['messages'] = ['successMessage' => "cart attributes updated successfully"];
            return response()->json([$response], 200);
        }
        //*****************quantity update******************
        if ($cart->customers_basket_quantity != $request->quantity) {

            $attr = $cart->cartAttributes()->select('products_options_id', 'products_options_values_id')->get();
            $attr_value = $cart->cartAttributes()->select('products_options_values_id')->get();
            $product_quantity_stock = product_quantity_stock::where('product_quantity_stock.product_id', $cart->products_id)
                ->join('store_product', 'product_quantity_stock.id', '=', 'store_product.product_quantity_stock_id')

                ->where('is_active', 1)
                ->where('store_product.quantity', '>', 0)
                ->where('store_product.store_id', 1)
                ->select('store_product.quantity');

            foreach ($attr as $attr1) {
                $product_quantity_stock
                    ->join('product_variations_group as ' . $attr1->products_options_id . '', '' . $attr1->products_options_id . '.product_quantity_stock_id', '=', 'store_product.product_quantity_stock_id')
                    ->where('' . $attr1->products_options_id . '.options_id', $attr1->products_options_id)
                    ->where('' . $attr1->products_options_id . '.options_values_id', $attr1->products_options_values_id);
            }
            //  $product_quantity_stock->whereIn('product_variations_group.options_id', $attr_id)
            // ->whereIn('product_variations_group.options_values_id', $attr_value)
            // ;
            //                ->addSelect('store_product.quantity');

            $product_quantity_stock = $product_quantity_stock->first()->quantity;
            if ($product_quantity_stock <  $request->quantity) {
                return    response()->json(['code' => 0, 'error' => 'You requested quantity is over stock quantity!!'], 400);
            } else {
                $cart->customers_basket_quantity = $request->quantity;
                $cart->save();
                //return $cart;
                $response['success'] = true;
                $response['messages'] = ['quanitySuccessMessage' => "cart quantity updated successfully"];
                return response()->json([$response], 200);
            }
        } else {
            $response['success'] = true;
            $response['messages'] = ['successMessage' => "nothing changed"];
            return response()->json([$response], 200);
        }
    }
}
