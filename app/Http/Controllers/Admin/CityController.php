<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function index()
    {
        return view('dashboard.city.index');
    }



    public function getDataTableOfcity()
    {


        $product_brand = City::get();
        // dd($categories);
        return DataTables::of($product_brand)
            ->addColumn('action', function ($row) {
                return  "<a href='" . route("dashboard.city.edit", ['id' => "$row->id"]) . "' class='btn btn-outline-warning btn-icon-text' > "
                    . "   <i class='mdi mdi-pencil btn-icon-prepend'></i> " . __('dashboard/categories.update') . " </a> "
                    . "<a href='" . route("dashboard.city.delete", ['id' => "$row->id"]) . "' class='btn btn-outline-warning btn-icon-text' > "
                    . "   <i class='mdi mdi-trach btn-icon-prepend'></i> Delete </a> ";
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
        $product_company = new City();
        $product_company->name = $request->input('name');



        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'city created successfully.');
    }

    public function create()
    {


        return view('dashboard.city.create');
    }


    public function edit($id)
    {
        $brand = City::find($id);

        return view('dashboard.city.edit', ['brand' => $brand]);
    }

    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'id' => 'required',
            'name' => 'required|max:255',
        ]);

        // Create a new instance of product_company model
        $product_company =  City::find($request->id);
        $product_company->name = $request->input('name');



        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'city edited successfully.');
    }

    public function delete($id)
    {
        $brand = City::find($id);
        $brand->is_hidden = 1;
        $brand->save();
        return redirect()->back()->with(['success' => 'deleted Successfully']);
    }
}
