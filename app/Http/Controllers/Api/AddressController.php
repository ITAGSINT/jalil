<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function create(Request $request)
    {

        $request['user_id'] = Auth::guard('sanctum')->user()->id;
        // $request['user_id'] = 56;

        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string'],
            'address' => ['string','required'],
            'city' => ['string','required'],
            'street' => ['string','required'],
            'state' => ['string','required'],
            'lat' => ['required'],
            'long' => ['required'],

        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }

        $address = new Address();
        $address->user_id = $request->user_id;
        $address->name = $request->name;
        $address->loc_lat = $request->lat;
        $address->loc_long = $request->long;
        $address->address = $request->address;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->street = $request->street;
        $address->save();


        // return $address->id;
        $response['success'] = true;
        $response['messages'] = ['successMessage' => 'address created successfully'];
        $response['data'] = $address;
        return response()->json($response, 200);
    }

    public function edit(Request $request)
    {

        $request['user_id'] = Auth::guard('sanctum')->user()->id;
        // $request['user_id'] = 56;

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:addresses,id'],
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string'],
            'address' => ['string'],
            'city' => ['string'],
            'street' => ['string'],
            'state' => ['string'],
            'lat' => ['required'],
            'long' => ['required'],

        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }

        $address =  Address::find($request->id);
        // $address->user_id = $request->user_id;
        $address->name = $request->name;
        $address->loc_lat = $request->lat;
        $address->loc_long = $request->long;
        $address->address = $request->address;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->street = $request->street;
        $address->save();


        // return $address->id;
        $response['success'] = true;
        $response['messages'] = ['successMessage' => 'address edited successfully'];
        $response['data'] = $address;
        return response()->json($response, 200);
    }

    public function delete(Request $request)
    {

        $request['user_id'] = Auth::guard('sanctum')->user()->id;
        // $request['user_id'] = 56;

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:addresses,id'],
            'user_id' => ['required', 'exists:users,id'],


        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }

        $address =  Address::find($request->id);

        $address->is_hidden = 1;
        $address->save();


        // return $address->id;
        $response['success'] = true;
        $response['messages'] = ['successMessage' => 'address deleted successfully'];
        // $response['data'] = $address;
        return response()->json($response, 200);
    }


    public function get_address()
    {

        $request['user_id'] = Auth::guard('sanctum')->user()->id;
        // $request['user_id'] = 56;

        $address = Address::shown()->where('user_id', $request['user_id'])->get()
            ->select('id', 'name', 'loc_lat', 'loc_long', 'address', 'street', 'city', 'state');

        $response['success'] = true;
        $response['data'] = $address;
        // $response['messages']='';
        return response()->json($response, 200);
    }

    public function get_address_ById(Request $request)
    {

        $request['user_id'] = Auth::guard('sanctum')->user()->id;
        // $request['user_id'] = 56;
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:addresses,id'],
            'user_id' => ['required', 'exists:users,id'],


        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }
        $address = Address::shown()->find($request->id)

            ->only(['id', 'name', 'loc_lat', 'loc_long', 'address', 'street', 'city', 'state']);

        $response['success'] = true;
        $response['data'] = $address;
        // $response['messages']='';
        return response()->json($response, 200);
    }
}
