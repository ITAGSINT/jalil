<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\product_quantity_stock;
use App\Models\product_variations_group;
use App\Models\orders_products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{

    public function index(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
                // ->where(function ($query) {
                //     $query->where('parent_id', 0);
                // })
            ],
            'car_id' => [
                'required',
                Rule::exists('cars', 'id')
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
        $cat = Category::with('sun')->find($request->category_id);
        if ($cat->sun != null) {
            $response['success'] = false;
            $response['messages'] = ["category_id" => [
                "The selected category id is invalid."
            ]];

            return response()->json($response, 422);
            return 'yes';
        }
        $products = Product::with(['category'])
            ->where('category_id', $request->category_id)

            ->paginate(10);
        $response['success'] = true;
        $response['data'] = ProductResource::collection($products);
        // $response['messages']='';
        return  response()->json($response, 200);
    }


    public function most_baught()
    {

        //          $pro=orders_products::select('products_id')
        //   ->groupBy('products_id')
        //   ->orderByRaw('COUNT(products_id) DESC')
        // //   ->orderBy( 'COUNT(products_id)', 'DESC')
        //   ->limit(10)->
        //             get()->pluck('products_id');
        $products = Product::with(['images', 'mainImage', 'category.description', 'descriptionFE'])->where('is_feature', 1)->take(7)->get();
        $response['success'] = true;
        $response['data'] = ProductResource::collection($products);
        // $response['messages']='';
        return  response()->json($response, 200);
    }

    public function getProductById($product_id)
    {

        // return [$product_id];
        $validator = Validator::make(['product_id' => $product_id], [
            'product_id' =>  ['required', 'exists:products,id']
        ]);

        if ($validator->fails()) {

            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json($response, 400);
        }




        $product = Product::with(['category'])

            ->find($product_id);
        //return $product;
        $pro_res = new ProductResource($product);
        $response['success'] = true;
        $response['data'] = $pro_res;
        // $response['messages']='';
        return  response()->json($response, 200);
    }


    public function related($product_id)
    {

        // return [$product_id];
        $validator = Validator::make(['product_id' => $product_id], [
            'product_id' =>  ['required', 'exists:products,products_id']
        ]);

        if ($validator->fails()) {

            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json($response, 400);
        }

        $product = Product::
            //  ->where('language_id',4)
            find($product_id);


        $cats = $product->category->pluck('categories_id');

        $products    = Product::with(['images', 'mainImage', 'category.description', 'descriptionFE' ])->whereHas('category', function ($query) use ($cats) {
            return $query->whereIn('categories.categories_id', $cats);
        })
            ->take(5)->get();





        $response['success'] = true;
        $response['data'] = ProductResource::collection($products);
        // $response['messages']='';
        return  response()->json($response, 200);
        //  ->whereRelationIn('categories.categories_id', $cats);

    }


    public function filter(Request $request)
    {
        $cat_id = ($request->has('cat_id')) ? $request->cat_id : null;
        $keyword = ($request->has('keyword')) ? $request->keyword : null;


        // return $cat_id;
        $validator = Validator::make(['cat_id' => $cat_id, 'keyword' => $keyword], [
            'cat_id' => "nullable|exists:categories,categories_id",
            'keyword' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {

            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json($response, 400);
        }

        $products = Product::with(['images', 'mainImage', 'category.description', 'descriptionFE' ]);

        if ($cat_id != null) {
            $products->whereRelation('category', 'products_to_categories.categories_id', $cat_id);
            // $products->join('products_to_categories', 'products_to_categories.products_id', '=', 'products.products_id')
            //     ->where('products_to_categories.categories_id', $cat_id);
        }
        if ($keyword != null) {
            $products->whereRelation('descriptionFE', 'products_description.products_name', 'like', '%' . $keyword . '%')
                ->OrwhereRelation('descriptionFE', 'products_description.products_description', 'like', '%' . $keyword . '%');
            // $products->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            //     ->where('products_description.products_name', 'like', '%' . $keyword . '%')
            //     ->where('products_description.products_description', 'like', '%' . $keyword . '%');
        }

        // return $products->dd();
        $pro_res = ProductResource::collection($products->paginate(10));
        $response['success'] = true;
        $response['data'] = $pro_res;
        // $response['messages']='';
        return  response()->json($response, 200);
    }


    public function barcode_reader(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'barcode' => ['required', 'string', 'exists:products,Qr_code'],
            ]
        );
        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();
            return response()->json([$response], 400);
        }

        //  $product = Product::where('Qr_code',$request->barcode)->get();

        $product = Product::with(['images', 'mainImage', 'category.description', 'descriptionFE'])
            //  ->where('language_id',4)
            ->where('Qr_code', $request->barcode)->first();
        // $product->attributes = $attrbuite_array;
        //return $product;
        $pro_res = new ProductResource($product);
        $response['success'] = true;
        $response['data'] = $pro_res;



        return response()->json($response, 200);
    }
}
