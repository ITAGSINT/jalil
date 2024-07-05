<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ShipController;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDriverDetailsResource;
use App\Http\Resources\OrderDriverResource;
use App\Models\notifications;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderStatus;
use App\Models\orders_products;
use App\Models\orders_products_attribute;
use App\Models\Orders_drivers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\pos_user;
use App\Models\POS;
use App\Models\User;

class OrderController extends Controller
{
    public function index()
    {
        // $order = Order::where('id',62074)->with(['statusHistory','statusHistory.description'])->get();


        $orders_status = OrderStatus::whereIn('id', [2, 3, 4, 5, 6])->get();
        $drivers = User::where('role_id', 4)->where('is_active', 1)->get();
        // return $orders_status;
        return view('dashboard.orders.index')->with([
            'orders_status' => $orders_status, 'drivers' => $drivers
        ]);
    }
    public function getDataTableOfOrders1(Request $request, $client_id = false)
    {

        $search = $request->input('search.value');
        $columns = $request->get('columns');

        $pageSize = ($request->length) ? $request->length : 40;
        $start = ($request->start) ? $request->start : 0;

        //dd($request->all());
        $dir = 'desc';
        if ($request->has('order')) {

            $dir = $request->order[0]['dir'];
        }
        $orders = Order::query();
        if ($client_id) {
            $orders = $orders->where('customers_id', $client_id);
        }

        $count_total = $orders->clone()->count();

        $count_filter = 0;

        if ($search != '') {
            if (preg_match('/[0-9]+/i', $search)) {
                $orders->where('orders.id', $search)
                    ->orWhere('orders.phone', $search);
            } else if ($search == 'شحنها' || $search == 'منجز' || $search == 'تم تأكيد' || $search == 'إلغاء' || $search == 'إرجاع' || $search == 'قيد الانتظار') {
                // $orders->with(['statusHistory.description'=>function($query) use ($search){
                //$query->where('orders_status_name', 'like', '%'.$search.'%');
                $orders->whereRelation('currents', 'name', 'like', '%' . $search . '%');

                $keywords = [
                    'شحنها' => '6',
                    'تم تأكيد' => '5',
                    'إرجاع' => '4',
                    'إلغاء' => '3'
                ];

                unset($keywords[$search]);

                //dd($keywords);
                $orders->whereDoesntHave('currents', function ($query) use ($keywords) {
                    $query->whereIn('orders_status_history.status_id', array_values($keywords));
                });
            } else if ($search == 'today') {

                $orders->whereDate('created_at', '>=', now()->startOfDay());
            } else if ($search == 'month') {

                $orders->whereDate('created_at', '>=', now()->startOfMonth());
            } else if ($search == 'yesterday') {

                $orders->whereDate('created_at', '=', now()->subDay());
            } else {
                $orders->where('orders.customers_name', 'LIKE', '%' . $search . '%')

                    ->orWhere('orders.payment_method', 'LIKE', '%' . $search . '%');
            }
            $count_total = $orders->clone()->count();
        }


        $orders->skip($start)
            ->take($pageSize)
            ->orderBy('orders.id', $dir)
            ->with(['currents.statusDesc', 'driverName', 'address', 'payment.method']);
        $orders->select('orders.id', 'transaction_id', 'created_at', 'driver_id',  'address_id', 'customers_name as name',  'payment_method',  'customers_phone as phone', 'order_price',)->get();

        // dd($orders->get());
        return DataTables::eloquent($orders)
            ->blacklist(['', 'id', 'name', 'phone', 'created_at', 'payment_method', 'customers_city', 'delivery_name', 'email', 'delivery_city', 'delivery_street_address', 'delivery_phone', 'billing_name', 'billing_street_address', 'billing_phone', 'order_price', 'store_name'])
            ->setTotalRecords($count_total)
            ->addColumn('action', function ($row) {
                return "<form style='display:inline' action="
                    . ''
                    . " method=POST > "
                    . csrf_field()
                    . "<button type='submit' class='btn btn-warning btn-icon-text'>
                <i class='mdi mdi-trash-can-outline btn-icon-prepend'></i></button></form>"
                    . "<form style='display:inline' action=''"
                    . " method=GET > "
                    . csrf_field() . "<button type='submit' class='btn btn-outline-warning btn-icon-text'>
                    <i class='mdi mdi-pencil btn-icon-prepend'></i>  </button> </form>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    // public function getDataTableOfOrders(Request $request)
    // {


    //     $search = $request->input('search.value');
    //     $columns = $request->get('columns');



    //     //dd($request->all());
    //     $dir = 'desc';
    //     if ($request->has('order')) {

    //         $dir = $request->order[0]['dir'];
    //     }
    //     $orders = Order::query();


    //     $count_total = $orders->clone()->count();
    //     $orders->orderBy('orders.id', $dir)
    //         ->with(['currents.statusDesc', 'driverName', 'address', 'payment.method']);
    //     $orders->select('orders.id', 'transaction_id', 'created_at', 'driver_id',  'address_id', 'customers_name as name',  'payment_method',  'customers_phone as phone', 'order_price',)->get();

    //     if ($request->date == $request->date2) {
    //         $orders->where(DB::raw('DATE(created_at)'), $request->date);
    //     } else {
    //         $orders->whereBetween(DB::raw('DATE(created_at)'), [$request->date, $request->date2]);
    //     }

    //     // dd($orders->get());
    //     return DataTables::eloquent($orders)
    //         // ->blacklist(['', 'id', 'name', 'phone', 'created_at', 'payment_method', 'customers_city', 'delivery_name', 'email', 'delivery_city', 'delivery_street_address', 'delivery_phone', 'billing_name', 'billing_street_address', 'billing_phone', 'order_price', 'store_name'])
    //         ->setTotalRecords($count_total)

    //         ->toJson();
    // }
    public function getDataTableOfOrders(Request $request)
    {
        $search = $request->input('search.value');
        $columns = $request->get('columns');

        $dir = 'desc';
        if ($request->has('order')) {
            $dir = $request->order[0]['dir'];
        }
        $orders = Order::query();

        $count_total = $orders->clone()->count();

        if ($request->date == $request->date2) {
            $orders->where(DB::raw('DATE(created_at)'), $request->date);
        } else {
            $orders->whereBetween(DB::raw('DATE(created_at)'), [$request->date, $request->date2]);
        }

        $orders->orderBy('orders.id', $dir)
            ->with(['currents.statusDesc', 'driverName', 'address', 'payment.method']);

        // Add subquery to fetch drivers' names
        $orders->select(
            'orders.id',
            'transaction_id',
            'created_at',
            'driver_id',
            'address_id',
            'customers_name as name',
            'payment_method',
            'customers_phone as phone',
            'order_price',
            DB::raw('(SELECT GROUP_CONCAT(users.name SEPARATOR ", ")
                      FROM orders_drivers
                      JOIN users ON orders_drivers.driver_id = users.id
                      WHERE orders_drivers.order_id = orders.id
                      AND users.role_id = 4) as drivers')
        );

        return DataTables::eloquent($orders)
            // ->blacklist(['', 'id', 'name', 'phone', 'created_at', 'payment_method', 'customers_city', 'delivery_name', 'email', 'delivery_city', 'delivery_street_address', 'delivery_phone', 'billing_name', 'billing_street_address', 'billing_phone', 'order_price', 'store_name'])
            ->setTotalRecords($count_total)
            ->addColumn('drivers', function ($row) {
                return $row->drivers ? $row->drivers : 'No drivers assigned';
            })
            ->addColumn('action', function ($row) {
                return "<form style='display:inline' action='' method=POST >"
                    . csrf_field()
                    . "<button type='submit' class='btn btn-warning btn-icon-text'>
                        <i class='mdi mdi-trash-can-outline btn-icon-prepend'></i></button></form>"
                    . "<form style='display:inline' action='' method=GET >"
                    . csrf_field()
                    . "<button type='submit' class='btn btn-outline-warning btn-icon-text'>
                        <i class='mdi mdi-pencil btn-icon-prepend'></i>  </button> </form>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    public function show($order_id)
    {
        $order = Order::with(['code', 'currents', 'driverName.address'])->find($order_id);

        $job = $order->products->category_id;

        if (!in_array($job, [1, 2])) {
            $job = 1;
        }
        $drivers = User::with('jobs')
            ->where('role_id', 4)->whereRelation('jobs', 'job_id', $job)->get();


        // return $drivers;
        // $order_products = Order::with(['orders_products'])->where('orders.id', $order_id)->get();
        $total_after_discount = $order->discount_price;
        $order_total = $order->order_price;

        $orders_status = OrderStatus::whereIn('id', [2, 3, 4, 5, 6, 7])->get();

        return view('dashboard.orders.products.index')->with([
            'order' => $order,
            // 'products' => $order_products,
            'total' => $order_total,
            'total_after_discount' => $total_after_discount,
            'orders_status' => $orders_status,
            'drivers' => $drivers,

        ]);
    }



    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:orders,id'],
            // 'comments' => ['nullable', 'string'],
            'orders_status' => ['required', 'exists:orders_status,id']
        ]);
        if ($validator->fails())
            return redirect()->back()->with('error', 'عذرا , يرجى التأكد من اختيار الحالة بشكل صحيح');
        // dd($request->all());

        // $date_added = date('Y-m-d h:i:s');
        $orders_status = $request->orders_status;

        $comments = $request->comments;
        $id = $request->id;


        $order = Order::where('id', '=', $id)
            ->where('customers_id', '!=', '')->first();


        if ($orders_status == '2') {

            // $orders_products = DB::table('orders_products')->where('id', '=', $id)->get();

            // foreach ($orders_products as $products_data) {
            //     DB::table('products')->where('products_id', $products_data->products_id)->update([
            //         'products_quantity' => DB::raw('products_quantity - "' . $products_data->products_quantity . '"'),
            //         'products_ordered' => DB::raw('products_ordered + ' . $products_data->products_quantity),
            //     ]);


            //     $product_with_attr =  DB::table('orders_products_attributes')
            //         ->where('id', $id)
            //         ->where('products_id', $products_data->products_id)
            //         ->join('products_options_values_descriptions', 'products_options_values_descriptions.options_values_name', 'orders_products_attributes.products_options_values')
            //         ->select('orders_products_attributes.products_id', 'products_options_values_descriptions.products_options_values_id')
            //         ->first();

            //     if ($product_with_attr) {

            //         DB::table('products_attributes')
            //             ->where('products_id', $product_with_attr->products_id)
            //             ->where('options_values_id', $product_with_attr->products_options_values_id)
            //             ->update([
            //                 'attribute_quantity' => DB::raw('attribute_quantity - ' . $products_data->products_quantity)
            //             ]);
            //     }
            // }



            // if ($order->shippment_id == '') {
            //     ShipController::shipOrder($id);
            // }
        }

        if ($orders_status == '4') {

            // $orders_products = DB::table('orders_products')->where('id', '=', $id)->get();

            // foreach ($orders_products as $products_data) {
            //     DB::table('products')->where('products_id', $products_data->products_id)->update([
            //         'products_quantity' => DB::raw('products_quantity + "' . $products_data->products_quantity . '"'),
            //         'products_ordered' => DB::raw('products_ordered - '.$products_data->products_quantity),
            //     ]);
            // }
            /*  if ($orders[0]->return_shippment_id == '') {
                $this->returnShipOrder($id);
            } */
        }

        if ($orders_status == '3') {


            // $orders_products = DB::table('orders_products')->where('id', '=', $id)->get();

            // foreach ($orders_products as $products_data) {
            //     DB::table('products')->where('products_id', $products_data->products_id)->update([
            //         'products_quantity' => DB::raw('products_quantity + "' . $products_data->products_quantity . '"'),
            //     ]);
            // }
            /*$orders_products = DB::table('orders_products')->where('id', '=', $id)->get();

            foreach ($orders_products as $products_data) {

                $product_detail = DB::table('products')->where('products_id', $products_data->products_id)->first();

                $date_added = date('Y-m-d h:i:s');
                $inventory_ref_id = DB::table('inventory')->insertGetId([
                    'products_id' => $products_data->products_id,
                    'stock' => $products_data->products_quantity,
                    'admin_id' => auth()->user()->id,
                    'created_at' => $date_added,
                    'stock_type' => 'in',

                ]);
                //dd($product_detail);
                if ($product_detail->products_type == 1) {
                    $product_attribute = DB::table('orders_products_attributes')
                        ->where([
                            ['orders_products_id', '=', $products_data->orders_products_id],
                            ['id', '=', $products_data->id],
                        ])
                        ->get();

                    foreach ($product_attribute as $attribute) {
                        //dd($attribute->products_options,$attribute->products_options_values);
                        $prodocuts_attributes = DB::table('products_attributes')
                            ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_attributes.options_id')
                            ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'options_values_id')
                            ->where('products_options_values_descriptions.options_values_name', $attribute->products_options_values)
                            ->where('products_options_descriptions.options_name', $attribute->products_options)
                            ->select('products_attributes.products_attributes_id')
                            ->first();

                        DB::table('inventory_detail')->insert([
                            'inventory_ref_id' => $inventory_ref_id,
                            'products_id' => $products_data->products_id,
                            'attribute_id' => $prodocuts_attributes->products_attributes_id,
                        ]);
                    }
                }
            }*/
        }


        /* $order->statusHistory()->attach($orders_status, [
            'date_added' => $date_added,
            'customer_notified' => '1',
            'comments' => $comments,
        ]);*/
        $orders_history_id = DB::table('orders_status_history')->insertGetId(
            [
                'order_id' => $id,
                'status_id' => $orders_status,
                // 'created_at' => $date_added,
                'customer_notified' => '1',
                'comments' => $comments,
            ]
        );
        return redirect()->back()->with('success', 'order status updated successfully : order No :' . $id);
    }
    public function getInvoice(Request $request)
    {



        $order = Order::find($request->order_id);

        // $order_products = DB::table('orders_products')
        //  ->leftjoin('orders_products_attributes','orders_products.orders_products_id','orders_products_attributes.orders_products_id')
        //  ->leftjoin('products_options_values', 'products_options_values.products_options_values_id','orders_products_attributes.products_options_values')
        //  ->leftjoin('products_options', 'products_options.products_options_id','orders_products_attributes.products_options')
        // ->selectRaw('orders_products_attributes.orders_products_id,orders_products.* , orders_products_attributes.products_options ,orders_products_attributes.products_options_values,products_options_values_name,products_options.products_options_name')
        //->where('orders_products.id',$request->order_id);
        $order_products = Order::with(['orders_products'])->where('orders.id', $request->order_id)->get()
            ->map(function ($row) {
                foreach ($row->orders_products as $prod) {
                    foreach ($prod->orders_products_att as $orders_products_att) {

                        $orders_products_att->option =  DB::table('products_options')->where('products_options_id', $orders_products_att->products_options)->value('products_options_name');
                        $orders_products_att->val = DB::table('products_options_values')->where('products_options_id', $orders_products_att->products_options)->where('products_options_values_id', $orders_products_att->products_options_values)->value('products_options_values_name');
                    }
                }

                return $row;
            });
        //dd($order_products);

        //return $order_products;
        // $order_total = $order_products ->clone()->sum(DB::raw('products_price * products_quantity'))+$order->shipping_cost;
        $total_after_discount = $order->order_price;
        $order_total = $order->order_price;

        return $order_products;
    }

    public function select_driver(Request $request)
    {

        // $date_added = date('Y-m-d h:i:s');
        //  $orders_history_id = DB::table('orders_status_history')->insertGetId(
        // [
        //     'id' => $order_id,
        //     'orders_status_id' => 6,
        //     'date_added' => $date_added,
        //     'customer_notified' => '1',
        //     'comments' => '',
        // ]);
        $order = Order::find($request->order_id);
        $driverIds = $request->driver_id;
        // $order->drivers()->attach($request->driver_ids);
        DB::table('orders_drivers')->where('order_id', $request->order_id)->delete();

        foreach ($driverIds as $driverId) {
            DB::table('orders_drivers')->insert([
                'order_id' => $request->order_id,
                'driver_id' => $driverId,
                'created_at' => now()

            ]);
        } {
            $firebaseToken = User::whereIn('id', $request->driver_id)->pluck('fcm_token')->all();

            $SERVER_API_KEY = env('FCM_SERVER_KEY');
            $order = Order::with(['currents', 'driverName', 'products', 'address', 'car', 'pendingDrivers'])
                ->find($request->order_id);
            // $order = Order::with('currents', 'products', 'pendingDrivers')->find($request->order_id);
            $order = new OrderDriverResource($order);
            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    'title' => 'new order',
                    'body'  => 'accept or reject the order',
                    "mutable_content" => true,
                    "sound" => "Tri-tone",

                ],
                "data" =>  $order,
                "priority" =>  "high",
                "content_available" =>  true
            ];

            $payload = [
                'title' => 'new order',
                'body'  => 'accept or reject the order',
                'data'  => [],
            ];


            $dataString = json_encode($data);

            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response2 = curl_exec($ch);

            $notifications = notifications::create([
                'type' => 'App\Notifications\MyNotification', 'notifiable_type' => 'App\Models\User', 'notifiable_id' => 1,
                'data' => json_encode($payload),
                'action' => ''
            ]);
        }


        // $order->save();
        return redirect()->back()->with('success', 'Drivers Assigned successfully to the order : order No :' . $request->order_id);
    }


    public function get_driver_location_api($order_id)
    {

        $order = Order::findOrFail($order_id);



        return $order->driver_location;
    }
}
