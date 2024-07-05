<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\product_brand;
use Yajra\DataTables\DataTables;

class product_brandController extends Controller
{
    public function index()
    {

        $product_brand = product_brand::get();
        // $options = ProductOption::whereIn('products_options_id', [1, 3])->get();
        return view('dashboard.product_brand.index');
    }



    public function getDataTableOfproducts_brand()
    {


        $product_brand = product_brand::get();
        // dd($categories);
        return DataTables::of($product_brand)
            ->addColumn('action', function ($row) {
                return  "<a href='" . route("dashboard.product_brand.edit", ['id' => "$row->id"]) . "' class='btn btn-outline-warning btn-icon-text' > "
                    . "   <i class='mdi mdi-pencil btn-icon-prepend'></i> " . __('dashboard/categories.update') . " </a> ";
            })
            ->rawColumns(['action'])
            ->make(true);
    }



    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|max:255',
        ]);

        // Create a new instance of product_company model
        $product_company = new product_brand();
        $product_company->name = $request->input('name');

        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'brand created successfully.');
    }

    public function create()
    {


        return view('dashboard.product_brand.create');
    }


    public function edit($id)
    {
        $brand = product_brand::find($id);

        return view('dashboard.product_brand.edit', ['brand' => $brand]);
    }

    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|max:255',
        ]);

        // Create a new instance of product_company model
        $product_company =  product_brand::find($request->id);
        $product_company->name = $request->input('name');

        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'brand edited successfully.');
    }
}
