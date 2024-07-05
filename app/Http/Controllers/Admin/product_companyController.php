<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\product_company;
use Yajra\DataTables\DataTables;
class product_companyController extends Controller
{
    public function index()
    {

        $product_company = product_company::get();
        // $options = ProductOption::whereIn('products_options_id', [1, 3])->get();
        return view('dashboard.product_company.index');
    }

    public function getDataTableOfproduct_company()
    {


        $product_company = product_company::get()
     ;
        // dd($categories);
        return DataTables::of($product_company)
            ->addColumn('action', function ($row) {
                return  "<a href='" . route("dashboard.product_company.edit", ['id' => "$row->id"]) . "' class='btn btn-outline-warning btn-icon-text' > "
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
        $product_company = new product_company();
        $product_company->name = $request->input('name');

        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'company created successfully.');
    }

    public function create()
    {


        return view('dashboard.product_company.create');
    }


    public function edit($id)
    {
        $brand = product_company::find($id);

        return view('dashboard.product_company.edit', ['brand' => $brand]);
    }

    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|max:255',
        ]);

        // Create a new instance of product_company model
        $product_company =  product_company::find($request->id);
        $product_company->name = $request->input('name');

        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'brand edited successfully.');
    }
}