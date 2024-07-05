<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarManufacturer;
use App\Models\CarModel;
use App\Models\City;
use App\Models\Color;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CarController extends Controller
{


    public function add(Request $request)
    {
        $request['user_id'] = Auth::guard('sanctum')->user()->id;
        $validator = Validator::make($request->all(), [

            'user_id' => ['required', 'exists:users,id'],
            'model_id' => ['required', 'exists:models,id'],
            'color_id' => ['required'],
            'plate_num' => ['nullable', 'string', 'min:3'],
            'type' => ['required', Rule::in([1, 2])]

        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }

        if ($request->color_id != 1) {
            $validator = Validator::make($request->all(), [
                'color_id' => ['required', 'exists:colors,id'],
            ]);
            if ($validator->fails()) {
                $response['success'] = false;
                $response['messages'] = $validator->errors();

                return response()->json([$response], 400);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'hex_code' => [
                    'required',
                    'regex:/#[a-zA-Z0-9]{6}/'
                ],
            ]);
            if ($validator->fails()) {
                $response['success'] = false;
                $response['messages'] = $validator->errors();

                return response()->json([$response], 400);
            }
        }


        // $user = User::find($request->user_id);
        $car = new Car();
        $car->user_id = $request->user_id;
        $car->model_id = $request->model_id;
        $car->color_id = $request->color_id;
        $car->hex_code = ($request->color_id == 1) ? $request->hex_code :  Color::find($request->color_id)->hex_code;
        $car->plate_num = $request->plate_num;
        $car->type = $request->type;
        $car->save();
        $car_id = $car->id;

        $car = Car::shown()->with(['model.colors', 'model.manufacture'])
            ->find($car_id);
        $car = new CarResource($car);

        $response['success'] = true;
        $response['messages'] = ['successMessage' => 'car created successfully'];
        $response['data'] = $car;
        
        return response()->json($response, 200);
    }

    public function edit(Request $request)
    {
        $request['user_id'] = Auth::guard('sanctum')->user()->id;
        // $request['user_id'] = 1;
        $validator = Validator::make($request->all(), [
            'car_id' => ['required', 'exists:cars,id'],
            'user_id' => ['required', 'exists:users,id'],
            'model_id' => ['required', 'exists:models,id'],
            'color_id' => ['required'],
            'plate_num' => ['nullable','string', 'min:3'],
            'type' => ['required', Rule::in([1, 2])]

        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }

        if ($request->color_id != 1) {
            $validator = Validator::make($request->all(), [
                'color_id' => ['required', 'exists:colors,id'],
            ]);
            if ($validator->fails()) {
                $response['success'] = false;
                $response['messages'] = $validator->errors();

                return response()->json([$response], 400);
            }
        } else {
            $validator = Validator::make($request->all(), [
                'hex_code' => [
                    'required',
                    'regex:/#[a-zA-Z0-9]{6}/'
                ],
            ]);
            if ($validator->fails()) {
                $response['success'] = false;
                $response['messages'] = $validator->errors();

                return response()->json([$response], 400);
            }
        }


        // $user = User::find($request->user_id);
        $car =  Car::find($request->car_id);
        $car->user_id = $request->user_id;
        $car->model_id = $request->model_id;
        $car->color_id = $request->color_id;
        $car->hex_code = ($request->color_id == 1) ? $request->hex_code :  Color::find($request->color_id)->hex_code;
        $car->plate_num = $request->plate_num;
        $car->type = $request->type;
        $car->save();

        $car_id = $car->id;

        $car = Car::shown()->with(['model.colors', 'model.manufacture'])
            ->find($car_id);
        $car = new CarResource($car);



        $response['success'] = true;
        $response['messages'] = ['successMessage' => 'car edited successfully'];
        $response['data'] = $car;
        return response()->json($response, 200);
    }

    public function delete(Request $request)
    {

        // $request['user_id'] = Auth::guard('sanctum')->user()->id;
        $request['user_id'] = 56;

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:cars,id'],
            'user_id' => ['required', 'exists:users,id'],


        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }

        $car =  Car::find($request->id);

        $car->is_hidden = 1;
        $car->save();


        // return $address->id;
        $response['success'] = true;
        $response['messages'] = ['successMessage' => 'car deleted successfully'];
        // $response['data'] = $address;
        return response()->json($response, 200);
    }

    public function getAllCarMan(Request $request)
    {
        $cars = CarManufacturer::where('is_car', $request->type);
        if ($request->has('keyword')) {
            $cars->where('name', 'like', '%' . $request->keyword . '%');
        }

        $cars = $cars->get()->select('id', 'name', 'logo');
        $response['success'] = true;
        $response['data'] = $cars;
        // $response['messages']='';
        return response()->json($response, 200);
    }


    public function getAllManModel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'manufacturer_id' => ['required', 'exists:car_manufacturers,id'],
        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json($response, 422);
        }
        $cars = CarModel::where('manufacturer_id', $request->manufacturer_id);
        if ($request->has('keyword')) {
            $cars->where('name', 'like', '%' . $request->keyword . '%');
        }
        $cars = $cars->get()
            ->select('id', 'name', 'manufacturer_id');
        $response['success'] = true;
        $response['data'] = $cars;
        // $response['messages']='';
        return response()->json($response, 200);
    }


    public function getAllColors(Request $request)
    {
        $colors = Color::shown()->get()->select('id', 'name', 'hex_code');
        $response['success'] = true;
        $response['data'] = $colors;
        // $response['messages']='';
        return response()->json($response, 200);
    }


    public function getModelColorImage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'model_id' => ['required', 'exists:models,id'],
            'color_id' => ['required'],
        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json($response, 422);
        }

        if ($request->color_id == 1) {
        } else {

            $validator = Validator::make($request->all(), [

                'color_id' => ['required', 'exists:colors,id'],
            ]);

            if ($validator->fails()) {
                $response['success'] = false;
                $response['messages'] = $validator->errors();

                return response()->json($response, 422);
            }
        }

        $model = CarModel::find($request->model_id);
        if ($model->colors()->find($request->color_id) == null) {
            // return $model->colors->first()->pivot->image;
            // $response['success'] = false;
            // $response['messages'] = ['this model is not relateed to this product'];
            $response['success'] = true;
            $response['data'] = $model->colors->first()->pivot->image;

            return response()->json($response, 422);
        } else {

            $response['success'] = true;
            $response['data'] = $model->colors()->find($request->color_id)->pivot->image;
            // $response['messages']='';
            return response()->json($response, 200);
        }
    }

    public function getAllCity(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'manufacturer_id' => ['required', 'exists:car_manufacturers,id'],
        // ]);

        // if ($validator->fails()) {
        //     $response['success'] = false;
        //     $response['messages'] = $validator->errors();

        //     return response()->json($response, 422);
        // }
        $colors = City::get()->select('id', 'name');
        $response['success'] = true;
        $response['data'] = $colors;
        // $response['messages']='';
        return response()->json($response, 200);
    }

    public function getAllCars()
    {
        $request['user_id'] = Auth::guard('sanctum')->user()->id;
        // $request['user_id'] = 56;
        $cars = Car::shown()->with(['model.colors', 'model.manufacture'])
            ->where('user_id',  $request['user_id'])

            ->get();
        $cars = CarResource::collection($cars);
        $response['success'] = true;
        $response['data'] = $cars;
        // $response['messages']='';
        return response()->json($response, 200);
    }

    public function getCarById(Request  $request)
    {
        $request['user_id'] = Auth::guard('sanctum')->user()->id;
        // $request['user_id'] = 56;

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:cars,id'],
            'user_id' => ['required', 'exists:users,id'],


        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['messages'] = $validator->errors();

            return response()->json([$response], 400);
        }
        $cars = Car::shown()->with(['model.colors', 'model.manufacture'])->find($request->id);
        $cars = new CarResource($cars);
        $response['success'] = true;
        $response['data'] = $cars;
        // $response['messages']='';
        return response()->json($response, 200);
    }
}
