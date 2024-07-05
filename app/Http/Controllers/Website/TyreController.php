<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Http\Resources\Website\CarResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Car;
use App\Models\CarManufacturer;
use App\Models\CarModel;
use App\Models\City;
use App\Models\Color;
use App\Models\Address;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL as FacadesURL;
use URL;
use Illuminate\Support\Collection;
use App\Http\Resources\Website\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\product_manufacturers;
class TyreController extends Controller
{

    public function getAllCars(Request $request)
    {
        $request['user_id'] = Auth::user()->id;
        // $request['user_id'] = 56;
        $cars = Car::shown()->with(['model.colors', 'model.manufacture'])
            ->where('user_id',  $request['user_id'])->where('type',$request->type)
        
            ->get()->map(function($row) {
                 $row->color= Color::where('id',$row->color_id)->first()->name;
                 return $row;
            });
        
        $cars = CarResource::collection($cars);
        
        $response['success'] = true;
        $response['data'] = $cars;
        // $response['messages']='';
        return response()->json($response, 200);
    }
    public function getAllColors(Request $request)
    {
        $colors = Color::shown()->get()->where('is_hidden',0)->select('id', 'name', 'hex_code');
        $response['success'] = true;
        $response['data'] = $colors;
        // $response['messages']='';
        return response()->json($response, 200);
    }
    //get sub categories of parents
    public function sub_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => [
                'required',
                Rule::exists('categories', 'id')
                    ->where(function ($query) {
                        $query->where('parent_id', 0);
                    })
            ],
            'car_id' => [
                'nullable',
                Rule::exists('cars', 'id')
                
            ],
            'manufacturer_id' => [
                'nullable',
                Rule::exists('product_manufacturers', 'id')
                
            ],
        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json($response, 422);
        }
        if ($request->has('car_id') && $request->car_id != '') {
            $car_model = Car::find($request->car_id)->model_id;
        }


        $cat = Category::with('sun')->find($request->parent_id);
        if ($cat->sun != null) {
            if ($request->has('car_id') && $request->car_id != '') {
                $categories = Category::with(['products' => function ($query) use ($car_model, $request) {
                    $query->where('is_hidden', 0);
                    $query->whereHas('models', function ($query) use ($car_model) {
                        $query->where('model_id', $car_model);
                    });
                    if ($request->has('size') && $request->size != '') {
                        $query->where('size', 'like', '%' . $request->size . '%');
                    }
                    if ($request->has('manufacturer_id') && $request->manufacturer_id != '') {
                        $query->whereHas('manufacturer', function ($query) use ($request) {
                            $query->where('manufacturer_id', $request->manufacturer_id);
                        });
                    }
                }])
                    ->where('parent_id', $request->parent_id);
            } else {
                $categories = Category::with(['products' => function ($query) use ($request) {
                    $query->where('is_hidden', 0);
                    if ($request->has('manufacturer_id') && $request->manufacturer_id != '') {
                        $query->whereHas('manufacturer', function ($query) use ($request) {
                            $query->where('manufacturer_id', $request->manufacturer_id);
                        });
                    }
                    if ($request->has('size') && $request->size != '') {
                        $query->where('size', 'like', '%' . $request->size . '%');
                    }
                }])
                    ->where('parent_id', $request->parent_id);
            }


            $categories = $categories->get();
            $cat_res = CategoryResource::collection($categories);
            
            $response['success'] = true;
            $response['data'] = $cat_res;
            // $response['messages']='';
            return  response()->json($response, 200);
        } else {

            if ($request->has('car_id') && $request->car_id != '') {
                $categories = Category::with(['products' => function ($query) use ($car_model, $request) {
                    $query->where('is_hidden', 0);
                    $query->whereHas('models', function ($query) use ($car_model) {
                        $query->where('model_id', $car_model);
                    });
                    if ($request->has('manufacturer_id') && $request->manufacturer_id != '') {
                        $query->whereHas('manufacturer', function ($query) use ($request) {
                            $query->where('manufacturer_id', $request->manufacturer_id);
                        });
                    }
                    if ($request->has('size')) {
                        $query->where('size', 'like', '%' . $request->size . '%');
                    }
                }])
                    ->where('id', $request->parent_id);
            } else {
                $categories = Category::with(['products' => function ($query) use ($request) {
                    $query->where('is_hidden', 0);
                    if ($request->has('manufacturer_id') && $request->manufacturer_id != '') {
                        $query->whereHas('manufacturer', function ($query) use ($request) {
                            $query->where('manufacturer_id', $request->manufacturer_id);
                        });
                    }
                    if ($request->has('size')) {
                        $query->where('size', 'like', '%' . $request->size . '%');
                    }
                }])
                    ->where('id', $request->parent_id);
            }


            $categories = $categories->get();
            $cat_res = CategoryResource::collection($categories);
            $response['success'] = true;
            $response['data'] = $cat_res;
            // $response['messages']='';
            return  response()->json($response, 200);
            //return $cat_res;
        }


        
    }
    public function storeProductInSession(Request $request) {
        $validator = Validator::make($request->all(), [
            'car_id' => [
                'required',
            ],
            'qty' => [
                'required'
            ],
            'product_id' => [
                'required',
            ],
            
        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            //return response()->json($response, 400);
        }
        $request->session()->put('car_id', $request->input('car_id'));
        $request->session()->put('qty', $request->input('qty'));
        $request->session()->put('product_id', $request->input('product_id'));
        $request->session()->put('price', $request->input('price'));
        
        return redirect()->route('website.addresses.two');
    }
    public function storeAddressTimeInSession(Request $request) {
        $validator = Validator::make($request->all(), [
            'address_id' => [
                'required',
            ],
            'time' => [
                'required'
            ],
            'date' => [
                'required',
            ],
            
        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            //return response()->json($response, 400);
        }
        $request->session()->put('address_id', $request->input('address_id'));
        $request->session()->put('time', $request->input('time'));
        $request->session()->put('date', $request->input('date'));
        $request->session()->put('time2', $request->input('time2'));
        $request->session()->put('date2', $request->input('date2'));
        return redirect()->route('website.orderSummary');
    }
    


}
