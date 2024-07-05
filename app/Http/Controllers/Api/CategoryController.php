<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Car;
use App\Models\Category;
use App\Models\Product;
use App\Models\product_manufacturers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::where('parent_id', 0)->paginate(10);
        // return $categories;
        $cat_res = CategoryResource::collection($categories);
        //return $cat_res;
        $response['success'] = true;
        $response['data'] = $cat_res;
        // $response['messages']='';
        return  response()->json($response, 200);
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
                    $query->where('is_hidden',0);
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
                    $query->where('is_hidden',0);
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
                    $query->where('is_hidden',0);
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

    public function product_manufacturer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
                    ->where(function ($query) {
                        $query->where('id', 3);
                    })
            ],

        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json($response, 422);
        }


        $products = product_manufacturers::get();
        $response['success'] = true;
        $response['data'] = $products;
        return  response()->json($response, 200);
    }

    public function pro_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => [
                'required',
                Rule::exists('products', 'id')

            ],

        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json($response, 422);
        }





        $products = Product::find($request->product_id);
        $response['success'] = true;
        $response['data'] = $products->only(['id', 'name', 'description', 'products_price', 'discount_price', 'products_quantity']);

        // $response['messages'] = '';
        return  response()->json($response, 200);
    }
}
