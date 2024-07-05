<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PaymentsResource;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function getAllPayments(Request $request)
    {
        $request['user_id'] = Auth::guard('sanctum')->user()->id;

        $validator = Validator::make($request->all(), [
            // 'status' => [Rule::in(['1', '2', '3', '5', '6', '4', '7'])],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json($response, 400);
        }

        $ord_by = 'desc';
        $order = PaymentHistory::with(['method', 'order.products', 'status'])->where('user_id', $request->user_id);




        if ($request->ord_by) {
            $ord_by = $request->ord_by;
        }

        $order = $order->orderBy('created_at', $ord_by);
        $order = $order->get();

        $order = PaymentsResource::collection($order);
        $response['success'] = true;
        $response['data'] = $order;
        // $response['messages']='';
        return response()->json($response, 200);
    }

    public function getPaymentById(Request $request)
    {
        $request['user_id'] = Auth::guard('sanctum')->user()->id;

        // return $request;
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => ['required', 'exists:users,id'],

                'payment_id' => ['required', Rule::exists('payment_history', 'id')->where('user_id', $request->user_id)],
            ],
            [
                'payment_id.exists' => 'The user id is not vaild with the payment id.',
            ],
        );

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json($response, 400);
        }

        $order = PaymentHistory::with(['status'])


            ->find($request->payment_id);

        // return $order;
        // $order = new PaymentResource($order);
        $response['success'] = true;
        $response['data'] = $order;
        // $response['messages']='';
        return response()->json($response, 200);
    }
}
