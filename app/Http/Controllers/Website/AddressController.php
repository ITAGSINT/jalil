<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function create(Request $request)
    {

        $request['user_id'] = Auth::user()->id;
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
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            //return response()->json([$response], 400);
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
        return redirect()->route('website.addresses.two');
       // return response()->json($response, 200);
    }
    public function create_myAdress(Request $request)
    {

        $request['user_id'] = Auth::user()->id;
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
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
            //return response()->json([$response], 400);
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
        return redirect()->route('website.myAddress');
       // return response()->json($response, 200);
    }

    public function edit($id) {
        
        $address =  Address::where('id',$id)->first();
        
        return view('website.editAddress',compact('address'));
    }


    public function editmyAddress($id) {
        
        $address =  Address::where('id',$id)->first();
        
        return view('website.editmyAddress',compact('address'));
    }
    public function update(Request $request)
    {

        $request['user_id'] = Auth::user()->id;
        // $request['user_id'] = 56;

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:addresses,id'],
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

            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
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
        //return response()->json($response, 200);
        return redirect()->route('website.addresses.two');
    }
    public function updateMyaddress(Request $request)
    {

        $request['user_id'] = Auth::user()->id;
        // $request['user_id'] = 56;

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:addresses,id'],
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

            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
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
        //return response()->json($response, 200);
        return redirect()->route('website.myAddress');
    }

    
    public function deleteMyAddress(Request $request)
    {

        $request['user_id'] = Auth::user()->id;
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
        return redirect()->route('website.myAddress');
    }
    public function delete(Request $request)
    {

        $request['user_id'] = Auth::user()->id;
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
        return redirect()->route('website.addresses.two');
    }


    
}
