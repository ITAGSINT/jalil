<?php

namespace App\Http\Controllers\Api;

// use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
// use Illuminate\Support\Facades\DB;
// use URL;
use App\Models\OrderStatus;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderDriverDetailsResource;
use App\Http\Resources\OrderDriverResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderUserResource;
use App\Http\Resources\UserProfileResource;
use App\Models\notifications;
use App\Models\OrderStatusHistory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Ramsey\Collection\Collection;

class DriverController extends Controller
{

    public static function get_all(Request $request)
    {
        $request['user_id'] = Auth::guard('sanctum')->user()->id;

        $validator = Validator::make($request->all(), [
            'status' => [Rule::in(['1', '2', '3', '5', '6', '4', '7'])],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json($response, 400);
        }

        $ord_by = 'desc';
        $order = Order::with(['currents', 'driverName', 'products', 'address', 'car', 'pendingDrivers'])
            ->where('driver_id', $request->user_id)
            ->orWhereRelation('pendingDrivers', 'driver_id', $request->user_id);


        if ($request->status) {
            $order->whereRelation('currents', 'status_id', $request->status);
        }

        if ($request->ord_by) {
            $ord_by = $request->ord_by;
        }

        $order = $order->orderBy('created_at', $ord_by);
        $order = $order->get();
        // $order['req_drive'] = $request->user_id;
        // return $order;
        $order = OrderDriverResource::collection($order, $request->user_id);
        $response['success'] = true;
        $response['data'] = $order;
        // $response['messages']='';
        return response()->json($response, 200);
    }


    public function show(Request $request)
    {
        $driver_id = Auth::guard('sanctum')->user()->id;

        $validator = Validator::make(
            $request->all(),
            [

                'order_id' => ['required', Rule::exists('orders', 'id')]
                // ->where('driver_id', $driver_id)],
            ],
            [
                'order_id.exists' => 'The driver id is not vaild with the order id.'
            ]
        );

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();
            return response()->json($response, 400);
        }

        $order = Order::with('currents', 'products', 'pendingDrivers')->find($request->order_id);
        //   return  $order->pendingDrivers()->find($driver_id);
        //     if ($driver_id->in($order->pendingDrivers)) {
        //         return 'j';
        //     }
        if ($order->driver_id != $driver_id && $order->pendingDrivers()->find($driver_id) == null && $order->currents->status_id != 1) {
            $response['success'] = false;
            $response['messages'] = 'you can not access this order';
            return response()->json($response, 403);
        }

        // return $order;


        // return $order;
        $orders = new OrderDriverDetailsResource($order);
        $response['success'] = true;

        $response['data'] = $orders;
        $response['messages'] = ['successMessage' => 'Success '];
        //$response['code']="MO";
        //$result=CouponController::couponApplay($response,$cart);
        return response()->json($response, 200);
    }

    public static function status_accept(Request $request)
    {
        $driver_id = Auth::guard('sanctum')->user()->id;
        $validator = Validator::make(
            $request->all(),
            [

                'order_id' => [
                    'required', Rule::exists('orders', 'id')
                ],

            ]
        );
        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();
            return response()->json($response, 400);
        }

        $order = Order::with(['pendingDrivers'])->find($request->order_id);


        if ($order->driver_id != $driver_id && $order->pendingDrivers()->find($driver_id) == null && $order->currents->status_id != 1) {
            $response['success'] = false;
            $response['messages'] = 'you can not access this order';
            return response()->json($response, 403);
        }


        $order->pendingDrivers()->sync([]);
        $order->driver_id=$driver_id;
        $order->save();
        // return $order;

        //create order history
        $history = new OrderStatusHistory();
        $history->order_id = $request->order_id;
        $history->status_id = 2;
        $history->save();

        $orders = new OrderResource($order); {
            $firebaseToken = User::where('id', $order->customers_id)->pluck('fcm_token')->all();

            $SERVER_API_KEY = env('FCM_SERVER_KEY');

            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => 'order accepted',
                    "body" => 'your support team has been assigned',
                    "mutable_content" => true,
                    "sound" => "Tri-tone"
                ],
                "data" =>["id"=> $order->id,'status'=>1],

                "priority" =>  "high",
                "content_available" =>  true
            ];

            $payload = [
                'title' => 'order accepted',
                'body'  => 'your support team has been assigned',
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
                'type' => 'App\Notifications\MyNotification', 'notifiable_type' => 'App\Models\User', 'notifiable_id' => $order->customers_id,
                'data' => json_encode($payload),  'action' => ''
            ]);
        }

        $response['success'] = true;

        $response['data'] = $orders;
        $response['messages'] = ['successMessage' => 'Success '];
        //$response['code']="MO";
        //$result=CouponController::couponApplay($response,$cart);
        return response()->json($response, 200);
    }

    public static function status_reject(Request $request)
    {
        $driver_id = Auth::guard('sanctum')->user()->id;
        $validator = Validator::make(
            $request->all(),
            [

                'order_id' => [
                    'required', Rule::exists('orders', 'id')
                ],

            ]
        );
        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();
            return response()->json($response, 400);
        }


        $order = Order::with(['pendingDrivers'])->find($request->order_id);

        if ($order->driver_id != $driver_id && $order->pendingDrivers()->find($driver_id) == null && $order->currents->status_id != 1) {
            $response['success'] = false;
            $response['messages'] = 'you can not access this order';
            return response()->json($response, 403);
        }


        // return $order->pendingDrivers;
        $order->pendingDrivers()->detach($driver_id);
        $order->save();
        // return $order->pendingDrivers;


        if ($order->pendingDrivers()->first() == null) { {
                $firebaseToken = User::where('id', $order->customers_id)->pluck('fcm_token')->all();

                $SERVER_API_KEY = env('FCM_SERVER_KEY');

                $data = [
                    "registration_ids" => $firebaseToken,
                    "notification" => [
                        "title" => 'order canceled',
                        "body" => 'please order another time',
                        "mutable_content" => true,
                        "sound" => "Tri-tone"
                    ],
                    "data" =>["id"=> $order->id,'status'=>0],

                    "priority" =>  "high",
                    "content_available" =>  true
                ];

                $payload = [
                    'title' => 'order canceled',
                    'body'  => 'please order another time',
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
                    'type' => 'App\Notifications\MyNotification', 'notifiable_type' => 'App\Models\User', 'notifiable_id' => $order->customers_id,
                    'data' => json_encode($payload),  'action' => ''
                ]);
            }
        }



        $response['success'] = true;
        $response['messages'] = ['successMessage' => 'Success'];
        //$response['code']="MO";
        //$result=CouponController::couponApplay($response,$cart);
        return response()->json($response, 200);
    }

    public static function status_changed(Request $request)
    {
        $driver_id = Auth::guard('sanctum')->user()->id;
        $validator = Validator::make(
            $request->all(),
            [

                'order_id' => ['required', Rule::exists('id', 'orders_id')
                    ->where('driver_id', $driver_id)],
                // 'driver_comment' => ['string', 'min:4', 'max:100'],
                'order_status' => ['required', Rule::in(['5', '4', '7']),]
            ],
            [
                'order_id.exists' => 'The driver id is not vaild with the order id.',
                'order_status.in' => 'wrong status id the avaliable ids are 5 for completed , 4 for return, 7 for unreachable'
            ]
        );
        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();
            return response()->json($response, 400);
        }


        $order = Order::where('driver_id', $driver_id)->find($request->order_id);
        $driver = User::find($driver_id);
        $price = ($order->discount_price == null) ? $order->order_price : $order->discount_price;
        if ($order->payment_method == 2) {
            $driver->cash = $driver->cash + $price;
            $driver->save();
        }


        $orders_status = $request->order_status;
        // $comments = $request->driver_comment;
        $orders_id = $request->order_id;


        $history = new OrderStatusHistory();
        $history->order_id = $orders_id;
        $history->status_id = $orders_status;
        $history->save();

        //  $order->driver_comment = $request->driver_comment;

        // $order->order_status = $request->order_status;
        // $order->save();
        $response['success'] = true;

        // $response['data'] = $order;
        $response['messages'] = ['status changed Successfully '];
        //$response['code']="MO";
        //$result=CouponController::couponApplay($response,$cart);
        return response()->json($response, 200);
    }

    public static function status_get()
    {



        $status = OrderStatus::whereIn('orders_status_id', [2, 4, 5, 6, 7])->with('description')->get();


        $response['success'] = true;

        $response['data'] = $status;
        $response['messages'] = ['successMessage' => 'Success '];
        //$response['code']="MO";
        //$result=CouponController::couponApplay($response,$cart);
        return response()->json($response, 200);
    }


    public static function  location_set(Request $request)
    {
        $driver_id = Auth::guard('sanctum')->user()->id;

        $validator = Validator::make(
            $request->all(),
            [
                'order_id' => ['required', Rule::exists('orders', 'orders_id')
                    ->where('driver_id', $driver_id)],
            ],
            [
                'order_id.exists' => 'The driver id is not vaild with the order id.'


            ]
        );
        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();
            return response()->json($response, 400);
        }

        // return  $request->location;
        $order = Order::with(['status.description', 'currents'])->where('driver_id', $driver_id)->find($request->order_id);

        if ($order->currents->orders_status_id != 6) {
            $response['success'] = false;
            $response['messages'] = "this order is not pending shipping!!";
            return response()->json($response, 400);
        }

        $order->driver_location = $request->location;
        $order->save();


        $response['success'] = true;

        // $response['data'] = $status;
        $response['messages'] = ['successMessage' => 'Success '];
        //$response['code']="MO";
        //$result=CouponController::couponApplay($response,$cart);
        return response()->json($response, 200);
    }


    public function toggleActive(Request $request)
    {

        $request['user_id'] = Auth::guard('sanctum')->user()->id;

        // $request['user_id'] = 56;
        $data = $request->all();
        $validator = Validator::make($data, ([

            'user_id' => ['required', 'exists:users,id'],

        ]));


        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }

        // $user =  User::find($request->user_id);
        $user = User::find( $request->user_id);
        $user->update([

            'is_active' => !$user->is_active
        ]);


        // return $address->id;
        $response['success'] = true;
        $response['messages'] = ['active status changed successfully'];
        // $response['data'] = $user;
        return response()->json($response, 200);
    }

    public function index(Request $request)
    {

        $request['user_id'] = Auth::guard('sanctum')->user()->id;

        // $request['user_id'] = 56;
        $data = $request->all();
        $validator = Validator::make($data, ([

            'user_id' => ['required', 'exists:users,id'],

        ]));


        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }

        // $user =  User::find($request->user_id);
        $user = User::with([
            'driverOrders' => function ($query) {


                $query->whereHas('currents', function ($query2) {
                    $query2->whereIn('status_id', [2, 6]);
                });
                $query->with('products:id,category_id','address','car');
                // $query->select(['orders.id', 'date', 'time']);
                // $query->whereRelation('driverOrders.currents','id', 1);
            }
            // , 'driverOrders.currents' => function ($query) {
            //     // $query->select(['id', 'date', 'time']);
            //      $query->whereIn('status_id', [2, 6]);
            //     // $query->whereHas('currents', function ($query2) {

            //     // });


            //     // $query->whereRelation('driverOrders.currents','id', 1);
            // }
        ])
            ->withCount(['driverOrders', 'driverOrders as done' => function ($query) {
                $query->whereHas('currents', function ($query) {
                    $query->where('status_id', 5);
                });
                // $query->whereRelation('driverOrders.currents','id', 1);
            }])

            ->withCount(['driverOrders', 'driverOrders as scheduled' => function ($query) {
                $query->whereHas('currents', function ($query) {
                    $query->whereIn('status_id', [2, 6]);
                });
                // $query->whereRelation('driverOrders.currents','id', 1);
            }])

            ->withCount('pendingOrders', 'pendingOrders as pending')
            ->find($request->user_id)
            // ->only(['is_active', 'cash', 'id', 'pending', 'done', 'scheduled', 'driverOrders'])
            ;
        // return $user;
        return   $user = new UserProfileResource($user);
        // return $address->id;
        $response['success'] = true;
        // $response['messages'] = ['successMessage' => 'profile deleted successfully'];
        $response['data'] = $user;
        return response()->json($response, 200);
    }
}
