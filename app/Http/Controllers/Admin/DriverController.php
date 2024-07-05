<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\driver;
use App\Models\UImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\File;
use App\Models\OrderStatus;
use App\Models\Order;
use Yajra\DataTables\Facades\DataTables;

class DriverController extends Controller
{
    //
    public function index()
    {

        return view('dashboard.drivers.index');
    }


    public function destroy($id)
    {
        $user = User::driver()->where('id', $id);
        if ($user->clone()->exists()) {
            $user->clone()->first()->delete();
            return redirect()->back()->with('success', 'تم حذف السائق بنجاح');
        } else {
            return redirect()->back()->with('error', 'السائق غير موجود');
        }
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('role', 4)->where('id', $id);
        if ($user->clone()->exists()) {
            $user->clone()->first()->restore();
            return redirect()->back()->with('success', 'تم استعادة المستخدم');
        } else {
            return redirect()->back()->with('error', 'المستخدم غير موجود');
        }
    }
    public function forceDestroy($id)
    {
        $user = User::onlyTrashed()->where('role', 4)->where('id', $id);
        if ($user->clone()->exists()) {
            $user = $user->clone()->first();
            //delete  image
            $driver_image = UImage::where('id', $user->imageid);

            if ($driver_image->clone()->exists()) {
                $driver_image = $driver_image->first();
                if (File::exists('assets/uploads/images/users/' . $driver_image->filename)) {
                    File::delete('assets/uploads/images/users/' . $driver_image->filename);
                }
                $driver_image->delete();
            }

            $user->forceDelete();
            return redirect()->back()->with('success', 'تم حذف المستخدم');
        } else {
            return redirect()->back()->with('error', 'المستخدم غير موجود');
        }
    }
    public function getDataTableOfdrivers($driver_id = null)
    {


        $drivers = User::driver()->where('id', '!=', $driver_id)->select('id', 'first_name as name', 'phone', 'email')->get();

        // $drivers = driver::rightjoin('orders','orders.customers_id','customers.customers_id')
        //->select(DB::raw('COALESCE(customers.customers_id,0) as id'),'user_id as acount',DB::raw('count(*) as orders_count'))
        //->groupBy('orders.customers_name')
        //->get()
        //->map(function ($row){
        //  if($row->acount=='0')
        //      $row->acount = "غير مسجل " ;
        //return $row;
        //})
        //;

        return DataTables::of($drivers)
            ->addColumn('action', function ($row) {
                return "<form style='display:inline' action="
                    . route('dashboard.drivers.destroy', $row['id'])
                    . " method=POST > "
                    . csrf_field()
                    . "<button type='submit' class='btn btn-warning btn-icon-text'>
                        <i class='mdi mdi-trash-can-outline btn-icon-prepend'></i>" . __('dashboard/categories.delete') . "</button></form>"
                    . "<form style='display:inline' action="
                    . route('dashboard.drivers.getdriverOrders', $row['id'])
                    . " method=GET > "
                    . csrf_field()
                    . "<button type='submit' class='btn btn-outline-warning btn-icon-text'>
                    <i class='mdi mdi-pencil btn-icon-prepend'></i> طلبات السائق</button></form>";
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getdriverOrders(Request $request, User $driver)
    {
        //   return      $orders = Order::with(['statusHistory.description','driver'])->where('driver_id',8904)->get();

        $orders_status = OrderStatus::whereIn('id', [2, 3, 4, 7])->get();


        return view('dashboard.drivers.orders.index')->with([
            'driver' => $driver,
            'orders_status' => $orders_status
        ]);
    }

    public function getDataTableOfOrders($driver_id = null)
    {

        $orders = Order::with(['driverName', 'currents.statusDesc']);

        if ($driver_id) {
            $orders = $orders->where('driver_id', $driver_id);
        }

        $count_total = $orders->clone()->count();
        // $orders->with(['statusHistory.description','driver']);
        //  $orders->select('orders.id','driver_id',  'address', 'customers_state', 'customers_name as name', 'date_purchased', 'payment_method', 'customers_telephone as phone', 'customers_city', 'delivery_name', 'email', 'delivery_city', 'delivery_street_address', 'delivery_phone', 'billing_name', 'billing_street_address', 'billing_phone', 'order_price', 'store_id')->get()->map(function ($row) {
        //     $row->store_name = $row->store->name;

        //     return $row;
        // });
        $orders->select('id', 'transaction_id', 'created_at', 'driver_id',  'address_id', 'customers_name as name',  'payment_method',  'customers_phone as phone', 'order_price',)->get();


        return DataTables::eloquent($orders)
            // ->blacklist(['', 'orders_id', 'name', 'phone', 'date_purchased', 'payment_method','customers_city','delivery_name','email','delivery_city','delivery_street_address','delivery_phone','billing_name','billing_street_address','billing_phone','order_price','driver_id'])

            ->setTotalRecords($count_total)
            // ->addColumn('action', function ($row) {
            //     return $row->store->name;
            // })
            // ->rawColumns(['action'])
            ->toJson();
    }
}
