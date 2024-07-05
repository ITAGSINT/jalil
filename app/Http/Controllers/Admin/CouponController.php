<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryDesc;
use App\Models\Coupon;
use App\Models\ProductDesc;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\Object_;
use stdClass;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    //

    // public $discount_type = [
    //     'fixed_cart',
    //     'percent',
    //     'fixed_product',
    //     'percent_product'
    // ];

    public $discount_type = [
        '1',
        '2'
    ];


    public function index()
    {

        return view('dashboard.coupons.index');
    }

    public function getDataTableOfCoupons()
    {

        $coupons = Coupon::with('type');
        // ->map(function ($r) {
        //     if (Carbon::parse($r->expiry_date)->lt(now()))
        //         $r->expiry_date = "منتهي";
        //     return $r;
        // });
        return DataTables::of($coupons)
            ->addColumn('action', function ($row) {
                return "<form style='display:inline' action=" . route('dashboard.coupons.destroy', $row['coupans_id'])
                    . " method=POST > "
                    . csrf_field()
                    . "<button type='submit' class='btn btn-warning btn-icon-text'>
                    <i class='mdi mdi-trash-can-outline btn-icon-prepend'></i> " . __('dashboard/categories.delete') . " </button></form>"
                    . "<form style='display:inline' action=" . route('dashboard.coupons.edit', $row['coupans_id'])
                    . " method=GET > "
                    . csrf_field()
                    . "<button type='submit' class='btn btn-outline-warning btn-icon-text'>
                <i class='mdi mdi-pencil btn-icon-prepend'></i> " . __('dashboard/categories.update') . " </button> </form>";
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function create()
    {

        return view('dashboard.coupons.create');
    }
    public function store(Request $request)
    {
        //dd($request->all());
        $rules = [
            'code' => ['required', 'string', 'unique:coupons,code'],
            'description' => ['required', 'string'],
            'discount_type' => ['required', 'string'],
            'expiry_date' => ['required', 'date'],
            'amount' => ['required', 'numeric'],
            // 'usage_count' => ['required','numeric'],
            // 'product_ids.*' => ['numeric', 'exists:products,products_id'],
            // 'exclude_product_ids.*' => ['numeric', 'exists:products,products_id'],
            // 'usage_limit' => ['required', 'numeric'],
            // 'usage_limit_per_user' => ['nullable', 'numeric'],
            // 'limit_usage_to_x_items' => ['required', 'numeric'],
            // 'product_categories.*' => ['numeric', 'exists:categories,categories_id'],
            // 'excluded_product_categories.*' => ['numeric', 'exists:categories,categories_id'],
            // 'minimum_amount' => ['required', 'numeric'],
            // 'maximum_amount' => ['required', 'numeric'],
            // 'email_restrictions.*' => ['email'],
            // 'x_items_limit' => ['nullable', 'numeric']
        ];

        $validator = Validator::make($request->all(), $rules);
        // dd($validator->errors());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        if (!in_array($request->discount_type, $this->discount_type))
            return redirect()->back()->with('error', 'نوع الحسم غير صالح');

        Coupon::create([
            'code' => $request->code,
            'description' => $request->description,
            'coupon_type' => $request->discount_type,
            'expiry_date' => Carbon::parse($request->expiry_date)->toDateTimeString(),
            'amount' => $request->amount,
            // 'usage_count' => (!is_null($request->usage_count)) ? $request->usage_count : 0,
            // 'individual_use' => ($request->individual_use) ? 1 : 0,
            // 'product_ids' => ($request->product_ids) ? $request->product_ids : -1,
            // 'exclude_product_ids' => $request->exclude_product_ids ? $request->product_ids : -1,
            // 'usage_limit' => $request->usage_limit ? $request->usage_limit : -1,
            // 'usage_limit_per_user' => null,
            // 'limit_usage_to_x_items' => $request->x_items_limit ? $request->x_items_limit : -1,
            // 'free_shipping' => ($request->free_shipping) ? 1 : 0,
            // 'product_categories' => $request->product_categories ? $request->product_categories : -1,
            // 'excluded_product_categories' => $request->excluded_product_categories ? $request->excluded_product_categories : -1,
            // 'exclude_sale_items' => ($request->exclude_sale_items) ? 1 : 0,
            // 'minimum_amount' => $request->minimum_amount ? $request->minimum_amount : -1,
            // 'maximum_amount' => $request->maximum_amount ? $request->maximum_amount : -1,
            // 'email_restrictions' => $request->email_restrictions ? $request->email_restrictions : -1,
            // 'limit_usage_to_x_items' => $request->x_items_limit ? $request->x_items_limit : 1
        ]);
        /*
        $rules=[
            'code'=>,
            'description'=>,
            'discount_type'=>,
            'expiry_date'=>,
            'amount'=>,
            'usage_count'=>,
            'individual_use'=>,
            'product_ids'=>,
            'exclude_product_ids'=>,
            'usage_limit'=>,
            'usage_limit_per_user'=>,
            'limit_usage_to_x_items'=>,
            'free_shipping'=>,
            'product_categories'=>,
            'excluded_product_categories'=>,
            'exclude_sale_items'=>,
            'minimum_amount'=>,
            'maximum_amount'=>,
            'email_restrictions'=>,
            'used_by'=>,
            ]; */

        return redirect()->route('dashboard.coupons.index')->with('success', 'Success');
    }
    public function edit(Coupon $coupon)
    {
        $notFound = new stdClass();
        $notFound->name = "not found";



        return view('dashboard.coupons.edit')->with([
            'coupon' => $coupon,

        ]);
    }
    public function update(Coupon $coupon, Request $request)
    {
        // return $request;

        $rules = [
            'code' => ['required', 'string'],
            'description' => ['required', 'string'],
            'discount_type' => ['required', 'string'],
            'expiry_date' => ['nullable', 'date'],
            'amount' => ['required', 'numeric'],

        ];

        $validator = Validator::make($request->all(), $rules);
        // dd($validator->errors());
        if ($validator->fails()) {
            return     redirect()->back()->withErrors($validator->errors())->withInput();
        }
        //dd(!in_array($request->discount_type, $this->discount_type));
        if (!in_array($request->discount_type, $this->discount_type))
            return redirect()->back()->with('error', 'error');


    return    $coupon->update([
            'code' => $request->code,
            'description' => $request->description,
            'coupon_type' => $request->discount_type,
            'amount' => $request->amount,

        ]);



        if ($request->has('expiry_date') && !is_null($request->expiry_date))
            $coupon->expiry_date = Carbon::parse($request->expiry_date)->toDateTimeString();

        $coupon->save();

        return redirect()->back()->with('success', 'Success');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->back()->with('success', 'Success');
    }
}
