<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SlidersImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    public function index()
    {
        return view('dashboard.slider.index');
    }

    /**
     * get the datatable for creating a new resource.
     */
    public function getDataTableOfslider(Request $request)
    {
        $data = SlidersImage::query();



        return DataTables::eloquent($data)
            ->addColumn('action', function ($data) {
                $actionBtn = '<div style="display:flex; justify-content: space-between;">
            <a href="' . route("dashboard.slider.edit", ["id" => $data->id]) . '" class="text-dark p-1"> 
            <i class="fas fa-edit "></i></a>
                         
            <a href="' . route("dashboard.slider.delete", ["id" => $data->id]) . '" class="text-dark p-1"> 
                <i class="fas fa-trash "></i></a></div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    public function create()
    {
        return view('dashboard.slider.add');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, ([
            'main_image' => ['required', 'image'],
            'title' => ['required', 'string', 'max:255'],


        ]));
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($data);
        }
      


        $slider = new SlidersImage();
        // return $slider->id;
        $slider->title = $request->input('title');

        $slider->image =  $request->main_image;
        $slider->save();


        return redirect()->route('dashboard.slider.index')->with('success', 'Slider created successfully.');
    }

    public function show(SlidersImage $slider)
    {
        return view('dashboard.slider.show', ['slider' => $slider]);
    }

    public function edit($id)
    {
        $slider = SlidersImage::findOrFail($id);
        return view('dashboard.slider.edit', compact('slider'));
    }

    public function update(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($data, ([
            'main_image' => ['required', 'image'],
            'title' => ['required', 'string', 'max:255'],

        ]));
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($data);
        }

        $slider = SlidersImage::findOrFail($request->id);
        $slider->title = $request->input('title');
        $slider->image = $request->main_image;


        $slider->save();

        return redirect()->route('dashboard.slider.index')->with('success', 'Slider updated successfully.');
    }

    public function delete($id)
    {
        $slider = SlidersImage::findOrFail($id);

        $slider->delete();

        return back()->with(['success', 'Slider deleted successfully.']);
    }
}
