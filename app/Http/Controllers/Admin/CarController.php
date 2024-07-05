<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarManufacturer;
use App\Models\CarModel;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CarController extends Controller
{
    public function index()
    {
        return view('dashboard.manufacturer.index');
    }



    public function getDataTableOfmanufacturer()
    {


        $product_brand = CarManufacturer::get();
        // dd($categories);
        return DataTables::of($product_brand)
            ->addColumn('action', function ($row) {
                return  "<a href='" . route("dashboard.manufacturer.edit", ['id' => "$row->id"]) . "' class='btn btn-outline-warning btn-icon-text' > "
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
            'is_car' => 'required',
            "logo" => ['required', 'image']
        ]);


        $path = 'images/media/logos/';

        $main_image_name = '';
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $main_image_name = time() . 'logo_' .  $image->getClientOriginalName();
            str_replace(' ', '', $main_image_name);
            $image->move(public_path($path), $main_image_name);
        }
        $main_image_name;
        // Create a new instance of product_company model
        $product_company = new CarManufacturer();
        $product_company->name = $request->input('name');
        $product_company->is_car = $request->input('is_car');
        $product_company->logo = URL::asset($path . '' . $main_image_name);

        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'manufacturer created successfully.');
    }

    public function create()
    {


        return view('dashboard.manufacturer.create');
    }


    public function edit($id)
    {
        $brand = CarManufacturer::find($id);

        return view('dashboard.manufacturer.edit', ['brand' => $brand]);
    }

    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'id' => 'required',
            'name' => 'required|max:255',
            "logo" => ['image']
        ]);

        $path = 'images/media/logos/';

        $main_image_name = '';
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $main_image_name = time() . 'logo_' .  $image->getClientOriginalName();
            str_replace(' ', '', $main_image_name);
            $image->move(public_path($path), $main_image_name);
        }
        $main_image_name;

        // Create a new instance of product_company model
        $product_company =  CarManufacturer::find($request->id);
        $product_company->name = $request->input('name');
        $product_company->is_car = $request->input('is_car');
        $product_company->logo = URL::asset($path . '' . $main_image_name);

        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'manufacturer edited successfully.');
    }


    public function index_model()
    {
        $manufacturers = CarManufacturer::get();
        return view('dashboard.model.index', ['manufacturers' => $manufacturers]);
    }



    public function getDataTableOfmodel()
    {


        $product_brand = CarModel::with('manufacture')->get();
        // dd($categories);
        return DataTables::of($product_brand)
            ->addColumn('action', function ($row) {
                return  "<a href='" . route("dashboard.model.edit", ['id' => "$row->id"]) . "' class='btn btn-outline-warning btn-icon-text' > "
                    . "   <i class='mdi mdi-pencil btn-icon-prepend'></i> " . __('dashboard/categories.update') . " </a> ";
            })
            ->rawColumns(['action'])
            ->make(true);
    }



    public function store_model(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|max:255',
            'manufacturer_id' => 'required'
        ]);

        // Create a new instance of product_company model
        $product_company = new CarModel();
        $product_company->name = $request->input('name');
        $product_company->manufacturer_id = $request->input('manufacturer_id');

        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'model created successfully.');
    }

    public function create_model()
    {
        $manufacturers = CarManufacturer::get();
        return view('dashboard.model.create', ['manufacturers' => $manufacturers]);
    }


    public function edit_model($id)
    {
        $manufacturers = CarManufacturer::get();
        $brand = CarModel::find($id);
        $colors = Color::get();
        return view('dashboard.model.edit', ['brand' => $brand, 'manufacturers' => $manufacturers, 'colors' => $colors]);
    }

    public function update_model(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|max:255',
            'manufacturer_id' => 'required'
        ]);

        // Create a new instance of product_company model
        $product_company =  CarModel::find($request->id);
        $product_company->name = $request->input('name');
        $product_company->manufacturer_id = $request->input('manufacturer_id');

        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'model edited successfully.');
    }

    public function store_model_color(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, ([
            'model_id' => ['required', 'exists:models,id'],
            'color_id' => ['required', 'exists:colors,id'],
            'image' => ['required', 'image'],


        ]));
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($data);
        }
        $model = CarModel::find($request->model_id);


        $file = $request->image;
        $name = uniqid('img_') . '.' . $file->getClientOriginalExtension();
        $path = 'images';
        $file->storeAs('public/' . $path, $name);
        $value = 'storage/' . $path . '/' . $name;


        if ($model->colors()->find($request->color_id) != null) {
            $color = $model->colors()->find($request->color_id);
            $color->pivot->image = URL::asset($value);
            $color->pivot->save();
        } else {
            $model->colors()->attach($request->color_id, ['image' =>  URL::asset($value)]);
        }

        // return $model->colors()->find($request->color_id);





        return redirect()->back()->with('success', 'color variation edited successfully.');
    }

    public function index_color()
    {
        return view('dashboard.color.index');
    }



    public function getDataTableOfcolor()
    {


        $product_brand = Color::where('is_hidden',0)->get();
        // dd($categories);
        return DataTables::of($product_brand)
            ->addColumn('action', function ($row) {
                return  "<a href='" . route("dashboard.color.edit", ['id' => "$row->id"]) . "' class='btn btn-outline-warning btn-icon-text' > "
                    . "   <i class='mdi mdi-pencil btn-icon-prepend'></i> " . __('dashboard/categories.update') . " </a> "
                    . "<a href='" . route("dashboard.color.delete", ['id' => "$row->id"]) . "' class='btn btn-outline-warning btn-icon-text' > "
                    . "   <i class='mdi mdi-trach btn-icon-prepend'></i> Delete </a> ";
            })
            ->rawColumns(['action'])
            ->make(true);
    }



    public function store_color(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|max:255',
            'hex_code' => 'required',

        ]);

        // Create a new instance of product_company color
        $product_company = new Color();
        $product_company->name = $request->input('name');
        $product_company->hex_code = $request->input('hex_code');

        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'color created successfully.');
    }

    public function create_color()
    {
        $manufacturers = CarManufacturer::get();

        return view('dashboard.color.create', ['manufacturers' => $manufacturers]);
    }


    public function edit_color($id)
    {

        $brand = Color::find($id);

        return view('dashboard.color.edit', ['brand' => $brand]);
    }

    public function update_color(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|max:255',
            'hex_code' => 'required',

        ]);

        // Create a new instance of product_company color
        $product_company =  Color::find($request->id);
        $product_company->name = $request->input('name');
        $product_company->hex_code = $request->input('hex_code');

        // Save the product_company
        $product_company->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'color edited successfully.');
    }

    public function delete_color($id)
    {
        $brand = Color::find($id);
        $brand->is_hidden = 1;
        $brand->save();
        return redirect()->back()->with(['success' => 'deleted Successfully']);
    }
}
