<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Http\Resources\CarResource;
use App\Http\Resources\Website\CarResource as c1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Car;
use App\Models\Address;
use App\Models\CarManufacturer;
use App\Models\CarModel;
use App\Models\City;
use App\Models\Color;
use App\Models\Coupon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL as FacadesURL;
use URL;

class WebsiteController extends Controller
{

    public function index()
    {
        $product = Product::with(['category'])->latest()->take(4)->get();
        $cats = category::take(4)->get();
        return view('website.index', [
            'cats' => $cats, 'allproducts' => $product
        ]);
    }
    public function two() {
        return view ('website.two');
    }
    public function yes() {
        return view ('website.yes');
    } 
    public function myvehicles() {
        return view ('website.myvehicles');
    } 
    // public function myAddress() {
    //     return view ('website.myAddress');
    // } 
     public function carWash() {
        return view ('website.carWash');
    }
    public function addresses() {
        return view ('website.addresses');
    }
    public function addmyaddress() {
        return view ('website.addmyaddress');
    }
    public function myAddress(Request $request) {
        $request['user_id'] = Auth::user()->id;
        // $request['user_id'] = 56;

        $address = Address::shown()->where('user_id', $request['user_id'])->get()
            ->select('id', 'name', 'loc_lat', 'loc_long', 'address', 'street', 'city', 'state');
           
        return view ('website.myAddress',compact('address'));
    }



    public function addressesTwo(Request $request) {
        $request['user_id'] = Auth::user()->id;
        // $request['user_id'] = 56;

        $address = Address::shown()->where('user_id', $request['user_id'])->get()
            ->select('id', 'name', 'loc_lat', 'loc_long', 'address', 'street', 'city', 'state');
            $car_id=$request->session()->get('car_id');
            $qty = $request->session()->get('qty');
            $product_id = $request->session()->get('product_id');
            $price= $request->session()->get('price');  
        return view ('website.addresstwo',compact('address','car_id','qty','product_id','price'));
    }
    public function add($id) {
        
        return view ('website.add',compact('id'));
    }
    public function storeaddPage(Request $request) {
        $validator = Validator::make($request->all(), [
            'manufacturerinput' => [
                'required',
            ],
            'modelinput' => [
                'required'
            ],
            
            
        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            //return response()->json($response, 400);
        }
        $request->session()->put('manf', $request->input('manufacturerinput'));
        $request->session()->put('manfName', $request->input('manfname'));
        $request->session()->put('ModelName', $request->input('modelname'));
        $request->session()->put('model', $request->input('modelinput'));
        $request->session()->put('sertype', $request->input('sertype'));
        $request->session()->put('vichletype', $request->input('vichletype'));
        return redirect('/addNext');
    }
    public function addone(Request $request) {
        $servicetype=$request->session()->get('sertype');
        $manfinput = $request->session()->get('manf');
        $modelinput = $request->session()->get('model');
        $manfname= $request->session()->get('manfName');
        $modelname= $request->session()->get('ModelName');
        $vichleinput=$request->session()->get('vichletype');
        return view ('website.addone',compact('manfinput', 'modelinput','servicetype','vichleinput','manfname','modelname'));
    }
    
    public function storeVichle(Request $request) {
        
        $request['user_id'] = Auth::user()->id;
        $validator = Validator::make($request->all(), [

            'user_id' => ['required', 'exists:users,id'],
            'modelinput' => ['required', 'exists:models,id'],
            'colorinput' => ['required'],
            'plate_num' => ['nullable', 'string', 'min:3'],
            'vichle' => ['required', Rule::in([1, 2])]

        ]);

        if ($validator->fails()) {
            
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 200);
        }

        // if ($request->colorinput != 1) {
            // $validator = Validator::make($request->all(), [
            //     'colorinput' => ['required', 'exists:colors,id'],
            // ]);
            // if ($validator->fails()) {
            //     $response['success'] = false;
            //     $response['messages'] = $validator->errors();

            //     return response()->json([$response], 400);
            // }
       
        // } else {
        //     $validator = Validator::make($request->all(), [
        //         'hex_code' => [
        //             'required',
        //             'regex:/#[a-zA-Z0-9]{6}/'
        //         ],
        //     ]);
        //     if ($validator->fails()) {
        //         $response['success'] = false;
        //         $response['messages'] = $validator->errors();

        //         return response()->json([$response], 400);
        //     }
        // }
        
        // $user = User::find($request->user_id);
        $car = new Car();
        $car->user_id = $request->user_id;
        $car->model_id = $request->modelinput;
        $car->color_id = $request->colorinput;
        // $car->hex_code = ($request->colorinput == 1) ? $request->hex_code :  Color::find($request->colorinput)->hex_code;
        $car->hex_code =  Color::find($request->colorinput)->hex_code;

        $car->plate_num = $request->plate_num;
        $car->type = $request->vichle;
        $car->save();
        $car_id = $car->id;

        $car = Car::shown()->with(['model.colors', 'model.manufacture'])
            ->find($car_id);
        $car = new CarResource($car);

        $response['success'] = true;
        $response['messages'] = ['successMessage' => 'car created successfully'];
        $response['data'] = $car;
        $response['serviceType']=$request->sertype;
        $request->session()->forget(['sertype', 'manf','model','manfName','ModelName','vichletype']);
       
        return response()->json($response, 200);
    }
    public function no() {
        return view ('website.no');
    }
    public function change() {
        return view ('website.change');
    }
    public function changeTwo() {
        return view ('website.changetwo');
    }
    public function tyre() {
        return view ('website.tyre');
    }
    public function storeCouponInSession(Request $request) {
        $request->session()->put('discount', $request->input('discount'));
        $request->session()->put('old_total', $request->input('old_total'));
        $request->session()->put('new_total', $request->input('new_total'));
        $request->session()->put('code', $request->input('code'));
        return redirect()->route('website.how');
    }
    public function how(Request $request) {
       //$code= $request->session()->get('code');
        return view ('website.how');
    }
    public function how_2() {
        return view ('website.how_2');
    }
    public function how_3() {
        return view ('website.how_3');
    }
    public function payment(Request $request) {
        
        $product=Product::where('id',$request->session()->get('product_id'))->first();
        $qty=$request->session()->get('qty');
        return view ('website.payment',compact('product','qty'));
    }
    public function orderSummary(Request $request) {
        $address =  Address::where('id',$request->session()->get('address_id'))->first();
        $car = Car::shown()->with(['model.colors', 'model.manufacture'])
            ->where('id',$request->session()->get('car_id'))->get()->map(function($row) {
                if(count($row->model->colors) ==1) {$row->model_image=$row->model->colors[0]->pivot->image;}
                else {
                    foreach($row->model->colors as $one) {
                        if($one->hex_code == $row->hex_code) {
                            $row->model_image=$one->pivot->image;
                            break;
                        }
                    }
                }
                $row->color_name= Color::where('hex_code',$row->hex_code)->first()->name;
                
                return $row;
            });   
        //    return $car;
        $product=Product::where('id',$request->session()->get('product_id'))->first();
        $time = $request->session()->get('time');
        $date = $request->session()->get('date');
        $time2 = $request->session()->get('time2');
        $date2 = $request->session()->get('date2');
        return view ('website.orderSummary',compact('address','car','product','date','time','date2','time2'));
    }
    public function checkCopon(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'product_id' => ['required'],
                'code' => [
                    'required',
                    Rule::exists('coupons', 'code')->where(function ($query) {
                        $query->where('expiry_date', '>', now())
                            ->whereColumn('usage_count', '<', 'usage_limit');
                    }),
                ],
            ],
            [
                'code.exists' => 'coupon expired or invalid',
            ]
        );


        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json($response, 200);
        }

        $code = Coupon::with('type')
            ->where('code', $request->code)
            ->first();

        $order_total = 0;
        $order_new = 0;




        //calculate order_total


        $product = Product::find($request->product_id);
        $price = $product->products_price;
        $discount = $product->discount_price;
        if ($discount < $price && $discount != 0) {
            $price = $discount;
        }
        if ($request->has('quantity')) {
            $order_total += $price * $request->quantity;
        } else {
            $order_total += $price;
        }


        if ($code->type->id == 1) {
            $order_new = $order_total - $code->amount;
            // return $order_new . '= ' . $order_total . ' ' . $code->amount;
        }

        if ($code->type->id == 2) {

            $order_dis = ($order_total * $code->amount) / 100;
            $order_new = $order_total - $order_dis;
            // return $order_new . '=' . $order_total . ' -' . $order_dis;
        }



        $response['success'] = true;
        $response['data'] = ['old_total' => $order_total, 'new_total' => $order_new, 'discount' => $order_total - $order_new];
        // $response['messages']='';
        return response()->json($response, 200);
    }
    
    
    


    





    




}
