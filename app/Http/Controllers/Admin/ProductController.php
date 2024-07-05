<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\Product;
use App\Models\Category;
use App\Models\product_company;
use App\Models\product_brand;
use App\Models\product_manufacturers;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\UImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductController extends Controller
{
    //
    public function add_index()
    {

        // $categories = Category::where('parent_id', '!=', 0)->get();
        $categories = Category::select('id', 'name')->get();
        $product_company = product_company::get();
        $product_brand = product_brand::get();
        $product_manufacturers = product_manufacturers::get();
        $models = CarModel::with('manufacture')->get();
        return view('dashboard.products.add')->with(
            [
                'categories' => $categories,
                'product_company' => $product_company,
                'product_brand' => $product_brand,
                'product_manufacturers' => $product_manufacturers,
                'models' => $models

            ]
        );
    }
    public function index()
    {

        $categories = Category::select('id', 'name')
            ->get();
        return view('dashboard.products.index')->with(
            [
                'categories' => $categories,
            ]
        );
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if (!($product->clone()->exists())) {
            return redirect()->back()->with('error', __('dashboard/products.product_not_found'));
        }
        $categories = Category::select('id', 'name')->get();

        $models = CarModel::with('manufacture')->get();

        $product_company = product_company::get();
        $product_brand = product_brand::get();
        $product_manufacturers = product_manufacturers::get();
        return view('dashboard.products.edit')->with([
            'product' => $product,
            'categories' => $categories,
            'product_company' => $product_company,
            'product_brand' => $product_brand,
            'product_manufacturers' => $product_manufacturers,
            'p_id' => $id,
            'models' => $models

        ]);
    }
    public function destroy($id)
    {
        $product = Product::where('id', $id);
        if (!$product->clone()->exists())
            return redirect()->back()->with('error', __('dashboard/products.product_not_found'));
        $product = $product->first();


        $product->is_hidden = 1;

        $product->save();
        return redirect()->back()->with('error', __('dashboard/products.product_deleted'));
    }
    public function getDataTableOfProducts()
    {
        $products = Product::select('id', 'category_id', 'name', 'products_price as price', 'main_image')
            ->with('category')
            ->where('is_hidden', 0)
            ->orderBy('id', 'Desc')->get();

        return DataTables::of($products)
            ->addColumn('action', function ($row) {
                return "<form style='display:inline' action="
                    . route('dashboard.products.destroy', $row['id'])
                    . " method=POST > "
                    . csrf_field()
                    . "<button type='submit' class='btn btn-warning btn-icon-text'>
            <i class='mdi mdi-trash-can-outline btn-icon-prepend'></i> " . __('dashboard/categories.delete') . " </button></form>"
                    . "<form style='display:inline' action=" . route('dashboard.products.edit', $row['id'])
                    . " method=GET>"
                    . csrf_field()
                    . "<button type='submit' class='btn btn-outline-warning btn-icon-text'>
                  <i class='mdi mdi-pencil btn-icon-prepend'></i> " . __('dashboard/categories.update') . " </button> </form>";
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function store(Request $request)
    {

        //rules
        $rules = [
            "name" => ['required', 'string'],
            "description" => ['required', 'string'],
            // "orginal_price" => ['required', 'numeric',  'min:0'],
            "selling_price" => ['required', 'numeric',  'min:1'],
            "category_id" => ['required', 'exists:categories,id'],
            'size' => 'required',
            "model_id" => ['required'],
            "model_id.*" => ['exists:models,id'],
            "main_image" => ['required', 'image'],
            "images.*" => ['image'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'discount_price' => ['nullable', 'numeric'],
        ];
        foreach ($rules as $key => $value) {
            if ($key != "images.*" && $key != "video")
                $attributes_name[$key] = __('attribute.' . $key);
        }

        $validator = Validator::make($request->all(), $rules, [], $attributes_name);

        if ($request->discount_price !== null) {
            if ($request->discount_price <= $request->selling_price) {
                $validator->errors()->add('discount_price', 'The discount price must be greater than the original price.');
            }
        }
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        DB::transaction(function () use ($request) {

            $product = Product::create([
                'category_id' => $request->category_id,
                'main_image' => $request->main_image,
                'name' => $request->name,
                'description' => $request->description,
                'size' => $request->size,
                'products_quantity' => $request->quantity,
                'products_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'country' => $request->country,
                'company_id' => $request->company,
                'brand_id' => $request->brand,
                'manufacturer_id' => $request->manufacturer,
                'sku' => $request->sku,
                'code' => $request->code,
                'capacity' => $request->capacity,
                'capacityUnit' => $request->capacity_u,
                'promotional_text' => $request->promotional_text,
                'netWeight' => $request->netWeight,
                'netWeightUnit' => $request->netWeight_u,
                'grossWeight' => $request->grossWeight,
                'grossWeightUnit' => $request->grossWeight_u,
                'width' => $request->width,
                'widthUnit' => $request->width_u,
                'length' => $request->length,
                'lengthUnit' => $request->length_u,
                'height' => $request->height,
                'heightUnit' => $request->height_u,
                'warrantyPeriod' => $request->warrantyPeriod,
                'warrantyType' => $request->warrantyType,
                'shippingWeight' => $request->shippingWeight,
                'shippingDimensions' => $request->shippingDimensions,
                'warranty_information' => $request->warranty_information,
                'specifications' => $request->specifications,
                'benefits' => $request->benefits,

            ]);

            $product->models()->sync([]);

            foreach ($request->model_id as $key => $model) {
                $product->models()->attach($model);
                $product->save();
            }
        });
        return redirect()->back()->with('success', 'added succesfully');
    }


    public function update($id, Request $request)
    {
        // return $request;
        $product  = Product::where('id', $id);


        if (!$product->clone()->exists()) {
            return redirect()->back()->with('error', __('dashboard/products.product_not_found'));
        }
        //rules
        $rules = [
            "name" => ['required', 'string'],
            "description" => ['required', 'string'],
            // "orginal_price" => ['required', 'numeric',  'min:0'],
            "selling_price" => ['required', 'numeric',  'min:1'],
            "category_id" => ['required', 'exists:categories,id'],

            "model_id" => ['required'],
            "model_id.*" => ['exists:models,id'],
            'size' => 'required',
            "main_image" => ['required', 'image'],
            "images.*" => ['image'],
            'products_quantity' => ['required', 'numeric', 'min:1'],
            'discount_price' => ['nullable', 'numeric'],
        ];
        foreach ($rules as $key => $value) {
            if ($key != "images.*")
                $attributes_name[$key] = __('attribute.' . $key);
        }
        //dd($request->all());

        $validator = Validator::make($request->all(), $rules, [], $attributes_name);
        //dd($validator->errors());
        if ($request->discount_price !== null) {
            if ($request->discount_price <= $request->selling_price) {
                $validator->errors()->add('discount_price', 'The discount price must be greater than the original price.');
            }
        }
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        $product = $product->first();


        DB::transaction(function () use ($product, $request) {

            if ($request->has('main_image')) {
                $product->update([
                    'main_image' => $request->main_image
                ]);
            }

            $product->update([
                'category_id' => $request->category_id,
                // 'main_image' => $request->main_image,
                'name' => $request->name,
                'description' => $request->description,
                'size' => $request->size,
                'products_quantity' => $request->products_quantity,
                'products_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'country' => $request->country,
                'company_id' => $request->company,
                'brand_id' => $request->brand,
                'manufacturer_id' => $request->manufacturer,
                'sku' => $request->sku,
                'code' => $request->code,
                'capacity' => $request->capacity,
                'capacityUnit' => $request->capacity_u,
                'promotional_text' => $request->promotional_text,
                'netWeight' => $request->netWeight,
                'netWeightUnit' => $request->netWeight_u,
                'grossWeight' => $request->grossWeight,
                'grossWeightUnit' => $request->grossWeight_u,
                'width' => $request->width,
                'widthUnit' => $request->width_u,
                'length' => $request->length,
                'lengthUnit' => $request->length_u,
                'height' => $request->height,
                'heightUnit' => $request->height_u,
                'warrantyPeriod' => $request->warrantyPeriod,
                'warrantyType' => $request->warrantyType,
                'shippingWeight' => $request->shippingWeight,
                'shippingDimensions' => $request->shippingDimensions,
                'warranty_information' => $request->warranty_information,
                'specifications' => $request->specifications,
                'benefits' => $request->benefits
            ]);

            $product->models()->sync([]);

            foreach ($request->model_id as $key => $model) {
                $product->models()->attach($model);
                $product->save();
            }
        });
        return redirect()->back()->with('success', 'edited succesfully');
    }




    public function getOrders(Product $product)
    {
        return view('dashboard.products.orders.index')->with(['product' => $product]);
    }

    public function getDataTableOfProductOrders(Product $product)
    {
        $clients = DB::table('users')
            ->join('orders', 'orders.customers_id', 'users.id')
            ->join('orders_products', 'orders_products.orders_id', 'orders.orders_id')
            ->where('orders_products.id', $product->id)
            ->orderByDesc('date_purchased')
            ->select('users.id', 'users.email', 'users.first_name as name', 'users.phone', 'orders.date_purchased as date')
            ->get();
        //dd($clients);
        return DataTables::of($clients)
            ->addColumn('action', function ($row) {
                return "<form style='display:inline' action="
                    . route('dashboard.clients.destroy', $row->id)
                    . " method=POST > "
                    . csrf_field()
                    . "<button type='submit' class='btn btn-warning btn-icon-text'>
                            <i class='mdi mdi-trash-can-outline btn-icon-prepend'></i>" . __('dashboard/categories.delete') . "</button></form>"
                    . "<form style='display:inline' action="
                    . route('dashboard.clients.getClientOrders', $row->id)
                    . " method=GET > "
                    . csrf_field()
                    . "<button type='submit' class='btn btn-outline-warning btn-icon-text'>
                        <i class='mdi mdi-pencil btn-icon-prepend'></i> طلبات العميل</button></form>";
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
