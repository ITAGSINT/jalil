<?php

namespace App\Http\Controllers\website;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Car;
use App\Models\Category;
use App\Resources\CarResource;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\LikedProducts;
use App\Models\User;
use App\Models\ProductDesc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ProductOption;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use App\Http\Auth\RegisterController;
use App\Models\OrderStatus;


class BatteryChangeController extends Controller
{
     


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
                // ->where(function ($query) {
                //     $query->where('parent_id', 0);
                // })
            ],
            'manufacturer_id' => [
                'nullable',
                Rule::exists('product_manufacturers', 'id')
                // ->where(function ($query) {
                //     $query->where('parent_id', 0);
                // })
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
            return $cat_res;
            $response['success'] = true;
            $response['data'] = $cat_res;
            // $response['messages']='';
            return  response()->json($response, 200);
        } else {

            if ($request->has('car_id') && $request->car_id != '') {
                $categories = Category::with(['products' => function ($query) use ($car_model, $request) {
                    $query->whereHas('models', function ($query) use ($car_model) {
                        $query->where('model_id', $car_model);
                    });
                    if ($request->has('size')) {
                        $query->where('size', 'like', '%' . $request->size . '%');
                    }
                }])
                    ->where('id', $request->parent_id);
            } else {
                $categories = Category::with(['products' => function ($query) use ($request) {

                    if ($request->has('size')) {
                        $query->where('size', 'like', '%' . $request->size . '%');
                    }
                }])
                    ->where('id', $request->parent_id);
            }


            $categories = $categories->get();
            $cat_res = CategoryResource::collection($categories);
            return $cat_res;
        }


        // $products = Product::with(['images', 'mainImage', 'category.description', 'descriptionFE' => function ($q) {
        //     $q->where('language_id', 1);
        // }])
        //     ->whereRelation('category', 'categories.categories_id', $request->parent_id)

        //     ->paginate(10);
        // $response['success'] = true;
        // $response['data'] = ProductResource::collection($products);
        // $response['data'] = $categories;
        // $response['messages']='';
        // return  response()->json($response, 200);
        
    }


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

}