<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\OrderUserResource;
use App\Models\Address;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderStatus;
use App\Models\product_quantity_stock;
use App\Models\product_variations_group;
use App\Models\orders_products;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\notifications;
use App\Models\Setting;
use App\Models\OrderStatusHistory;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{


    public function add(Request $request)
    {
        $request['user_id'] = Auth::guard('sanctum')->user()->id;
        // $request['user_id'] = 56;

        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'product_id' => ['required', 'exists:products,id'],
            'address_id' => ['required'],
            'car_id' => ['required'],
            'date' => ['required'],
            'time' => ['required'],
            'payment_method' => ['required'],
            // 'order_price' => ['required'],
            'note' => ['string'],

            'code' => [
                'nullable',
                Rule::exists('coupons', 'code')->where(function ($query) {
                    $query
                        ->where('expiry_date', '>', now())
                        ->whereColumn('usage_count', '<', 'usage_limit');
                }),
            ]
        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }


        // return Product::find($request->product_id)->category;


        $product = Product::find($request->product_id);

        if ($request->has('quantity')) {
            if ($product->products_quantity > $request->quantity) {
                $product->products_quantity = $product->products_quantity - $request->quantity;
                $product->save();
            } else {
                $response['success'] = false;
                $response['messages'] = 'required quantity not available';

                return response()->json([$response], 400);
            }
        } else {
            if ($product->products_quantity > 1) {
                $product->products_quantity = $product->products_quantity - 1;
                $product->save();
            } else {
                $response['success'] = false;
                $response['messages'] = 'required quantity not available';

                return response()->json([$response], 400);
            }
        }



        $user = User::find($request->user_id);


        DB::beginTransaction();
        try {

            ////create order
            $order = new Order();
            $order->customers_id = $request->user_id;
            $order->email = $user->email;
            $order->product_id = $request->product_id;
            $order->address_id = $request->address_id;
            if ($request->car_id == 1) {
                $order->car_id = 1;
            } else {
                $order->car_id = $request->car_id;
            }

            $order->customers_name = $user->name;
            $order->customers_phone = $user->phone;
            $order->date = $request->date;
            $order->time = $request->time;

            $order->payment_method = $request->payment_method;
            if ($request->has('quantity')) {
                $order->quantity = $request->quantity;
                $order->order_price = ($product->products_price) * $request->quantity;
            } else {
                $order->order_price = Product::find($request->product_id)->products_price;
            }

            $order->customer_comment = $request->note;


            //apply coupon
            if ($request->has('code') && $request->code != '') {
                $copoun = $this->applyCoupon($request);
                $new_order_total = $copoun->getData()->data->new_total;
                $code = Coupon::with('type')
                    ->where('code', $request->code)
                    ->first();
                $code->usage_count = $code->usage_count + 1;
                $code->save();
                $order->coupon_code = $request->code;
                $order->discount_price = $new_order_total;
                $order->save();
            }


            $order->save();
            $order_id = $order->id;

            //insert cart details to order record

            //create order history
            $history = new OrderStatusHistory();
            $history->order_id = $order_id;
            $history->status_id = 1;
            $history->save();

            $charge = NULL;
            $serviceName = Product::find($request->product_id)->category->name;

            if ($request->payment_method == 1) {
                $charge = $this->checkouOnlinePayment($order, $serviceName);
            }

            $payment = new PaymentHistory();
            $payment->user_id = $request->user_id;
            $payment->payment_id = $request->payment_method;
            $payment->status_id = 1;
            $payment->service_name = $serviceName;
            $payment->amount = ($order->discount_price != null) ? $order->discount_price : $order->order_price;
            $payment->recipient_name = 'Jalel';
            $payment->sender_name = $user->name;
            $payment->reference_id = $charge ? $charge->id : NULL;
            $payment->save();

            $order->transaction_id = $payment->id;
            $order->save(); {
                $firebaseToken = User::whereIn('role_id', [1, 3])->pluck('fcm_token')->all();

                $SERVER_API_KEY = env('FCM_SERVER_KEY');

                $data = [
                    "registration_ids" => $firebaseToken,
                    "notification" => [
                        "title" => 'new order',
                        "body" => 'assign drivers to the order',
                        "mutable_content" => true,
                        "sound" => "Tri-tone",

                    ],
                    "data" =>  $order->id,
                    "priority" =>  "high",
                    "content_available" =>  true
                ];

                $payload = [
                    'title' => 'new order',
                    'body'  => 'assign drivers to the order',
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
            $pro=$order->products->name;
            $order['product_name'] = $pro;
            data_forget($order, 'products');
            $response['success'] = true;
            $response['messages'] = ['successMessage' => 'order created successfully'];
            $response['data'] = $order;
            $response['hasUrl'] = !is_null($charge);
            $response['url'] = $charge ? $charge->url : NULL;
            DB::commit();
            return response()->json($response, 200);
        } catch (\Throwable $throwable) {
            return $throwable;
            DB::rollBack();
            $response = [];
            $response['data'] = [];
            $response['message'] = 'Server Error';
            $response['success'] = false;
            return response()->json($response, 200);
        }
    }


    public function getAllOrders(Request $request)
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
        $order = Order::with(['currents', 'driverName', 'products', 'address', 'car'])
            ->where('customers_id', $request->user_id);


        if ($request->status) {
            $order->whereRelation('currents', 'status_id', $request->status);
        }

        if ($request->ord_by) {
            $ord_by = $request->ord_by;
        }

        $order = $order->orderBy('created_at', $ord_by);
        $order = $order->get();

        $order = OrderUserResource::collection($order);
        $response['success'] = true;
        $response['data'] = $order;
        // $response['messages']='';
        return response()->json($response, 200);
    }

    public function getOrderById(Request $request)
    {
        $request['user_id'] = Auth::guard('sanctum')->user()->id;

        // return $request;
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => ['required', 'exists:users,id'],

                'order_id' => ['required', Rule::exists('orders', 'id')->where('customers_id', $request->user_id)],
            ],
            [
                'order_id.exists' => 'The customer id is not vaild with the order id.',
            ],
        );

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json($response, 400);
        }

        $order = Order::with(['currents', 'driverName.address:id,name,loc_lat,loc_long,address,street,city,state', 'products', 'address', 'car'])

            //  ->where('language_id',4)
            ->find($request->order_id);

        // return $order;
        $order = new OrderUserResource($order);
        $response['success'] = true;
        $response['data'] = $order;
        // $response['messages']='';
        return response()->json($response, 200);
    }

    public static function status_cancel(Request $request)
    {
        $request['user_id'] = Auth::guard('sanctum')->user()->id;

        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => ['required', 'exists:users,id'],
                'order_id' => ['required', Rule::exists('orders', 'id')->where('customers_id', $request->user_id)],
            ],
            [
                'order_id.exists' => 'The customer id is not vaild with the order id.',
            ],
        );
        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();
            return response()->json($response, 400);
        }

        $order = Order::with('currents')
            ->where('customers_id', $request->user_id)
            ->find($request->order_id);

        // return $order->currents->statusDesc->orders_status_name;

        if ($order->driver_id == null && ($order->currents->status_id == 2 ||  $order->currents->status_id == 1)) {

            $history = new OrderStatusHistory();
            $history->order_id = $order->id;
            $history->status_id = 3;
            $history->save();

            $payment =  PaymentHistory::find($order->transaction_id);

            $payment->status_id = 4;

            $payment->save();


            $orders = new OrderUserResource($order); {
                $firebaseToken = User::whereIn('role_id', [1, 3])->pluck('fcm_token')->all();

                $SERVER_API_KEY = env('FCM_SERVER_KEY');

                $data = [
                    "registration_ids" => $firebaseToken,
                    "notification" => [
                        "title" => 'order canceled',
                        "body" => 'inform drivers of the order',
                        "mutable_content" => true,
                        "sound" => "Tri-tone",

                    ],
                    "data" =>  $order->id,
                    "priority" =>  "high",
                    "content_available" =>  true
                ];

                $payload = [
                    'title' => ' order canceled',
                    'body'  => 'inform drivers of the order',
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
                    'data' => json_encode($payload),
                    'action' => ''
                ]);
            }
            $response['success'] = true;

            $response['data'] = $orders;
            $response['messages'] = ['successMessage' => 'Success '];
            //$response['code']="MO";
            //$result=CouponController::couponApplay($response,$cart);
            return response()->json($response, 200);
        } else {
            $response['success'] = false;

            if ($order->driver_id == null) {
                $response['messages'] = ['errorMessage' => 'you cannot cancel this order a driver is on his way'];
            } else {
                $response['messages'] = ['errorMessage' => 'you cannot cancel this order it is  (' . $order->currents->name . ')'];
            }
            return response()->json($response, 400);
        }
    }

    public static function status_get()
    {
        $status = OrderStatus::whereIn('id', [1, 2, 3, 4, 5, 6, 7])

            ->get()->select('id', 'name');

        $response['success'] = true;

        $response['data'] = $status;
        $response['messages'] = ['successMessage' => 'Success '];

        return response()->json($response, 200);
    }

    private function checkouOnlinePayment($order, $serviceName)
    {
        $user = Auth::user();

        $charge = $user->checkoutCharge((int)($order->order_price * 100), $serviceName, sessionOptions: [
            'payment_method_types' => ['card'],
            'payment_intent_data' => [
                'capture_method' => 'manual',
                'metadata' => [
                    'order' => $order->id
                ]
            ],
            'success_url' => route('payment-status', ['status' => 'success']),
            'cancel_url' => route('payment-status', ['status' => 'cancel']),
        ]);

        return $charge;
    }
}
