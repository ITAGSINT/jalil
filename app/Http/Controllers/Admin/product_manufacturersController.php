<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\product_company;
use Illuminate\Http\Request;
use App\Models\product_manufacturers;
use Yajra\DataTables\DataTables;

class product_manufacturersController extends Controller
{
    public function index()
    {

        $product_manufacturers = product_manufacturers::get();
        // $options = ProductOption::whereIn('products_options_id', [1, 3])->get();
        return view('dashboard.product_manufacturers.index');
    }

    public function getDataTableOfproduct_manufacturers()
    {


        $product_manufacturers = product_manufacturers::get();
        // dd($categories);
        return DataTables::of($product_manufacturers)
            ->addColumn('action', function ($row) {
                return  "<a href='" . route("dashboard.product_manufacturers.edit", ['id' => "$row->id"]) . "' class='btn btn-outline-warning btn-icon-text' > "
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
        $product_company = new product_manufacturers();
        $product_company->name = $request->input('name');

        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'company created successfully.');
    }

    public function create()
    {


        return view('dashboard.product_manufacturers.create');
    }


    public function edit($id)
    {
        $brand = product_manufacturers::find($id);

        return view('dashboard.product_manufacturers.edit', ['brand' => $brand]);
    }

    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|max:255',
        ]);

        // Create a new instance of product_company model
        $product_company =  product_manufacturers::find($request->id);
        $product_company->name = $request->input('name');

        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'brand edited successfully.');
    }
}
