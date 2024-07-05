<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryDesc;
use App\Models\Category;
use Yajra\DataTables\DataTables;
use App\Rules\ParentCategoryRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use App\Scopes\LangScope;
use App\Models\UImage;
use App\Models\categories_image;

class CategoryController extends Controller
{

    public function index()
    {
        //return all categories
        $categories = Category::select('id', 'name')->get();
        return view('dashboard.categories.index', [
            'categories' => $categories,
        ]);
    }
    public function store(Request $request)
    {
        //Validate request
        //rules
        $rules = [
            'name' => ['required', 'string'],
            'parent_id' => ['required', new ParentCategoryRule],
            "main_image" => ['required', 'image']

        ];
        foreach ($rules as $key => $value) {
            $attributes_name[$key] = __('attribute.' . $key);
        }
        //dd($request->all());
        $validator = Validator::make($request->all(), $rules, [], $attributes_name);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }


        DB::transaction(function () use ($request) {

            //dd($image);
            $category = Category::create([
                'name' => $request->name,
                'image' => $request->main_image,

                'parent_id' => $request->parent_id,

            ]);
        });
        return redirect()->back()->with('success', __('dashboard/categories.category_added'));
    }
    public function edit($id)
    {
        $parent_categories = Category::select('id', 'name')->get();
        $category = Category::where('id', $id);
        if ($category->clone()->exists()) {
            $category = $category->first();

            return view('dashboard.categories.edit')->with([
                'category' => $category,
                'parent_categories' => $parent_categories
            ]);
        } else {
            return redirect()->back()->with('error', __('dashboard/categories.category_not_found'));
        }
    }

    public function destroy($id)
    {
        if (in_array($id, [1, 2, 3])) {
            return redirect()->back()->with('error', 'You can not delete a main category');
        }
        $category = Category::where('id', $id);
        if ($category->clone()->exists()) {
            $category = $category->first();
            if (count($category->products) > 0) {
                return redirect()->back()->with('error', 'this category has products');
            }


            // $category->delete();
            return redirect()->back()->with('success',  __('dashboard/categories.category_deleted'));
        } else {
            return redirect()->back()->with('error',  __('dashboard/categories.category_not_found'));
        }
    }
    public function update($id, Request $request)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return redirect()->back()->withInput()->with('error',  __('dashboard/categories.category_not_found'));
        }
        //Validate request
        //rules
        $rules = [
            'name' => ['required', 'string'],
            "main_image" => ['image'],
            'parent_id' => ['required', new ParentCategoryRule]
        ];
        foreach ($rules as $key => $value) {
            $attributes_name[$key] = __('attribute.' . $key);
        }

        $validator = Validator::make($request->all(), $rules, [], $attributes_name);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }



        DB::transaction(function () use ($category, $request) {


            if ($request->main_image) {
                $category->update([
                    'name' => $request->name,
                    'parent_id' => $request->parent_id,
                    'image' => $request->main_image,
                ]);
            } else
                $category->update([
                    'name' => $request->name,
                    'parent_id' => $request->parent_id,

                ]);
        });
        return redirect()->back()->with('success',  __('dashboard/categories.category_updated'));
    }
    public function getDataTableOfCategories()
    {


        $categories = Category::with('parentCategory')
            ->orderBy('id', 'Desc')->get();
        // dd($categories);
        return DataTables::of($categories)
            ->addColumn('action', function ($row) {
                return "<form style='display:inline' action="
                    . route('dashboard.categories.destroy', $row['id'])
                    . " method=POST > "
                    . csrf_field()
                    . "<button type='submit' class='btn btn-warning btn-icon-text'>
                        <i class='mdi mdi-trash-can-outline btn-icon-prepend'></i> " . __('dashboard/categories.delete') . " </button></form>"
                    . "<form style='display:inline' action=" . route('dashboard.categories.edit', $row['id'])
                    . " method=GET > "
                    . csrf_field()
                    . "<button type='submit' class='btn btn-outline-warning btn-icon-text'>
                    <i class='mdi mdi-pencil btn-icon-prepend'></i> " . __('dashboard/categories.update') . " </button> </form>";
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
