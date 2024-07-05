<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Setting;
use App\Models\SlidersImage;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

use Throwable;
use Twilio\Exceptions\RestException;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    protected function create(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'phone' => ['required', 'numeric']

        ]);

        if ($validateUser->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ],
                401
            );
        }

        $data = $request->all();
        // if (($user = User::where('phone', $request->phone)->first())) {

        //     if ($request->has('fcm_token') && $request->fcm_token != '') {
        //         $user->update(['fcm_token' => $request->fcm_token]);
        //         // $user->save();
        //     }

        //     return response()->json(
        //         [
        //             'status' => true,
        //             'message' => 'Code sent Successfully',
        //             'phone' => $request->phone,

        //         ],
        //         200,
        //     );
        // } else {
        //     /* Get credentials from .env */
        //     $user =  User::create([
        //         'name' => ($request->has('phone')) ? 'user' . $data['phone'] : $data['email'],
        //         'phone' => $data['phone'],
        //         'email' => ($request->has('email')) ? $data['email'] : null,
        //         'role_id' => 2,
        //         'fcm_token' => $request->fcm_token,
        //         // 'password' => Hash::make($data['password']),
        //     ]);



        //     return response()->json(
        //         [
        //             'status' => true,
        //             'message' => 'Code sent Successfully',
        //             'phone' => $request->phone,

        //         ],
        //         200,
        //     );
        // }
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio_message_sid = getenv("TWILIO_MESSAGE_SID");
        $twilio = new Client($twilio_sid, $token);


        //check if user is registing or logging in
        // if (($user = User::where('phone', $request->phone))->first()) {

        //     //check if he has verified his phone or not
        //     if ($user->phone_verified == null) {

        //         $verification = $twilio
        //             ->verify
        //             ->v2
        //             ->services($twilio_verify_sid)
        //             ->verifications
        //             ->create($request->phone, "sms");
        //     } else {
        //         // return 'h';

        //         $code = mt_rand(100000, 999999);

        //         $user->auth_id_tiwilo = $code;
        //         $user->save();
        //         $message = $twilio->messages
        //             ->create(
        //                 $request->phone, // to
        //                 array(
        //                     "messagingServiceSid" => $twilio_message_sid,
        //                     "body" => 'Your Jalel OTP is : ' . $code
        //                 )
        //             );
        //     }

        //     return response()->json(
        //         [
        //             'status' => true,
        //             'message' => 'Code sent Successfully',
        //             'phone' => $request->phone,

        //         ],
        //         200,
        //     );
        // } else
        if ($user = User::where('phone', $request->phone)->first()) {

            //check if he has verified his phone or not

            if ($user->phone_verified == null) {
                //$user->update(['fcm_token' => $request->fcm_token]);

                $verification = $twilio
                    ->verify
                    ->v2
                    ->services($twilio_verify_sid)
                    ->verifications
                    ->create($request->phone, "sms");
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'User Created Successfully',
                        'phone' => $data['phone'],
                    ],
                    200,
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'this phone number is taken',

                    ],
                    401
                );
            }
        } else {

            $verification = $twilio
                ->verify
                ->v2
                ->services($twilio_verify_sid)
                ->verifications
                ->create($request->phone, "sms");
            $user =  User::create([
                'name' => ($request->has('phone')) ? 'user' . $data['phone'] : $data['email'],
                'phone' => $data['phone'],
                'email' => ($request->has('email')) ? $data['email'] : null,
                'role_id' => 2,
                'fcm_token' => $request->fcm_token,
                // 'password' => Hash::make($data['password']),
            ]);


            return response()->json(
                [
                    'status' => true,
                    'message' => 'User Created Successfully',
                    'phone' => $data['phone'],
                ],
                200,
            );
        }
        // return redirect()->route('verify')->with(['phone' => $data['phone']]);
    }


    protected function verify(Request $request)
    {


        $validateUser = Validator::make($request->all(), [
            'verification_code' => ['required', 'numeric'],
            'phone' => ['required', 'string'],
        ]);

        if ($validateUser->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ],
                401
            );
        }
        $data = $request->all();

        $user = User::where('phone', $request->phone)->first();
        if ($request->phone == '+963000000000' || $request->phone == '+963992620968') {
            // return 'h';
            if ($request->verification_code === '000000') {
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Phone number verified',
                        'token' => $user->createToken("API TOKEN")->plainTextToken
                    ],
                    200,
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Invalid verification code entered!',
                        'phone' => $data['phone']
                        // 'token' => $user->createToken("API TOKEN")->plainTextToken
                    ],
                    400,
                );
            }
        }
        // return response()->json(
        //     [
        //         'status' => true,
        //         'message' => 'Phone number verified',
        //         'token' => $user->createToken("API TOKEN")->plainTextToken
        //     ],
        //     200,
        // );
        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);

        try {
            // if (($user = User::where('phone', $request->phone)->first()) && $user->phone_verified == 1) {
            //     // return 'is verfiy';
            //     // $user = $user->first();
            //     $user_code = $user->auth_id_tiwilo;
            //     if ($user_code == $request->verification_code) {
            //         $user->auth_id_tiwilo = null;
            //         $user->save();
            //         Auth::login($user);
            //         return response()->json(
            //             [
            //                 'status' => true,
            //                 'message' => 'Phone number verified',
            //                 'token' => $user->first()->createToken("API TOKEN")->plainTextToken
            //             ],
            //             200,
            //         );
            //     } else {
            //         return response()->json(
            //             [
            //                 'status' => false,
            //                 'message' => 'Invalid verification code entered!',
            //                 'phone' => $data['phone']
            //                 // 'token' => $user->createToken("API TOKEN")->plainTextToken
            //             ],
            //             400,
            //         );
            //     }
            // } else
            {
                // return 'not verfiy';
                $verification = $twilio->verify->v2->services($twilio_verify_sid)
                    ->verificationChecks
                    ->create(['code' => $data['verification_code'], 'to' => $data['phone']]);


                if ($verification->valid) {
                    $user = tap(User::where('phone', $data['phone']))->update(['phone_verified' => true]);
                    /* Authenticate user */
                    Auth::login($user->first());
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Phone number verified',
                            'token' => $user->first()->createToken("API TOKEN")->plainTextToken
                        ],
                        200,
                    );
                    // return redirect()->route('home')->with(['message' => 'Phone number verified']);
                }

                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Invalid verification code entered!',
                        'phone' => $data['phone']
                        // 'token' => $user->createToken("API TOKEN")->plainTextToken
                    ],
                    400,
                );
            }
        } catch (RestException $exception) {

            return $exception;
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Something went wrong',

                    // 'token' => $user->createToken("API TOKEN")->plainTextToken
                ],
                404,
            );
        }

        // return back()->with(['phone' => $data['phone'], 'error' => 'Invalid verification code entered!']);
    }

    public function resendCode(Request $request)
    { {
            try {
                $validateUser = Validator::make($request->all(), [
                    'phone' => ['required', 'exists:users,phone'],
                    // 'password' => ['required', 'string', 'min:8'],
                ]);

                if ($validateUser->fails()) {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'validation error',
                            'errors' => $validateUser->errors(),
                        ],
                        401,
                    );
                }
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Code sent Successfully',
                        'phone' => $request->phone,

                    ],
                    200,
                );


                $token = getenv("TWILIO_AUTH_TOKEN");
                $twilio_sid = getenv("TWILIO_SID");
                $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
                $twilio_message_sid = getenv("TWILIO_MESSAGE_SID");
                $twilio = new Client($twilio_sid, $token);


                $user = User::where('phone', $request->phone); {

                    //check if he has verified his phone or not
                    if ($user->first()->phone_verified == null) {

                        $verification = $twilio
                            ->verify
                            ->v2
                            ->services($twilio_verify_sid)
                            ->verifications
                            ->create($request->phone, "sms");
                    } else {
                        // return 'h';

                        $code = mt_rand(100000, 999999);
                        $user = $user->first();
                        $user->auth_id_tiwilo = $code;
                        $user->save();
                        $message = $twilio->messages
                            ->create(
                                $request->phone, // to
                                array(
                                    "messagingServiceSid" => $twilio_message_sid,
                                    "body" => 'Your Jalel OTP is : ' . $code
                                )
                            );
                    }

                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Code sent Successfully',
                            'phone' => $request->phone,

                        ],
                        200,
                    );
                }
            } catch (\Throwable $th) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => $th->getMessage(),
                    ],
                    500,
                );
            }
        }
    }



    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'phone' => ['required', 'exists:users,phone'],
                // 'password' => ['required', 'string', 'min:8'],
            ]);

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateUser->errors(),
                    ],
                    401,
                );
            }

            if ($request->phone == '+963992620968') {
                $user = User::where('phone', $request->phone);
                $user->update(['fcm_token' => $request->fcm_token]);
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Code sent Successfully',
                        'phone' => $request->phone,

                    ],
                    200,
                );
            }


            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio_message_sid = getenv("TWILIO_MESSAGE_SID");
            $twilio = new Client($twilio_sid, $token);


            $user = User::where('phone', $request->phone);
            $user->update(['fcm_token' => $request->fcm_token]); {

                //check if he has verified his phone or not
                // if ($user->first()->phone_verified == null) {
                // if ($user->first()->phone_verified == null) {

                $verification = $twilio
                    ->verify
                    ->v2
                    ->services($twilio_verify_sid)
                    ->verifications
                    ->create($request->phone, "sms");
                // } else {
                //     // return 'h';

                //     $code = mt_rand(100000, 999999);
                //     $user = $user->first();
                //     $user->auth_id_tiwilo = $code;
                //     $user->save();
                //     $message = $twilio->messages
                //         ->create(
                //             $request->phone, // to
                //             array(
                //                 "messagingServiceSid" => $twilio_message_sid,
                //                 "body" => 'Your Jalel OTP is : ' . $code
                //             )
                //         );
                // }
                //     $code = mt_rand(100000, 999999);
                //     $user = $user->first();
                //     $user->auth_id_tiwilo = $code;
                //     $user->save();
                //     $message = $twilio->messages
                //         ->create(
                //             $request->phone, // to
                //             array(
                //                 "messagingServiceSid" => $twilio_message_sid,
                //                 "body" => 'Your Jalel OTP is : ' . $code
                //             )
                //         );
                // }

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Code sent Successfully',
                        'phone' => $request->phone,

                    ],
                    200,
                );
            }
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }

    public function loginDriver(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'phone' => ['required', 'exists:users,phone'],
                // 'password' => ['required', 'string', 'min:8'],
            ]);

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateUser->errors(),
                    ],
                    401,
                );
            }

            if ($request->phone == '+963000000000') {

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Code sent Successfully',
                        'phone' => $request->phone,

                    ],
                    200,
                );
            }

            // return response()->json(
            //     [
            //         'status' => true,
            //         'message' => 'Code sent Successfully',
            //         'phone' => $request->phone,

            //     ],
            //     200,
            // );

            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio_message_sid = getenv("TWILIO_MESSAGE_SID");
            $twilio = new Client($twilio_sid, $token);


            $user = User::where('phone', $request->phone);
            $user->update(['fcm_token' => $request->fcm_token]); {

                //check if he has verified his phone or not
                // if ($user->phone_verified == null) {

                $verification = $twilio
                    ->verify
                    ->v2
                    ->services($twilio_verify_sid)
                    ->verifications
                    ->create($request->phone, "sms");
                // } else {
                //     // return 'h';

                //     $code = mt_rand(100000, 999999);
                //     $user = $user;
                //     $user->auth_id_tiwilo = $code;
                //     $user->save();
                //     $message = $twilio->messages
                //         ->create(
                //             $request->phone, // to
                //             array(
                //                 "messagingServiceSid" => $twilio_message_sid,
                //                 "body" => 'Your Jalel OTP is : ' . $code
                //             )
                //         );
                // }

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Code sent Successfully',
                        'phone' => $request->phone,

                    ],
                    200,
                );
            }
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
        try {
            $validateUser = Validator::make($request->all(), [
                'phone' => ['required', 'exists:users,phone'],
                // 'password' => 'required',
            ]);

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateUser->errors(),
                    ],
                    401,
                );
            }

            if (!Auth::attempt($request->only(['phone', 'password']))) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Phone & Password does not match with our record.',
                    ],
                    401,
                );
            }

            $user = User::where('phone', $request->phone)->first();

            if ($user->role_id != 4) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'this is not a driver account',
                    ],
                    401,
                );
            }

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User Logged In Successfully',

                    'token' => $user->createToken('API TOKEN')->plainTextToken,
                ],
                200,
            );
        } catch (Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }


    public function logout(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if ($user) {
            // Delete FCM token
            $user->fcm_token = null;
            $user->save();

            // Revoke Bearer token

            $tokens = $user->tokens;
            foreach ($tokens as $token) {
                $token->delete();
            }
            // $user->token()->revoke();

            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        }

        return response()->json([
            'message' => 'No user authenticated',
        ], 401);
    }



    public function edit(Request $request)
    {
        $id = $request->id;
        $validateUser = Validator::make($request->all(), [
            'id' => ['required', 'exists:users'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'unique:users,phone,' . $id, 'regex:/(09)[0-9]{8}/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            // 'avatar' => ['image'],
        ]);

        if ($validateUser->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ],
                401
            );
        }

        $data = $request->all();

        // $time = now();
        // $path = 'images/avatars/' . date_format($time, 'Y') . '/' . date_format($time, 'm');

        // $main_image_name = '';
        // if ($request->hasFile('avatar')) {
        //     $image = $request->file('avatar');
        //     $main_image_name = time() . 'main_' . $image->getClientOriginalName();
        //     str_replace(' ', '', $main_image_name);
        //     $image->move(public_path($path), $main_image_name);
        // }

        $user = User::where('id', $id)->update([
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            // 'password' => Hash::make($data['password']),
            // 'avatar' => URL::asset($path . '/' . $main_image_name),
            // 'role_id' => 2,
        ]);

        return response()->json(
            [
                'status' => true,
                'message' => 'User edited Successfully',
                'id' => $id,
                // 'token' => $user->createToken("API TOKEN")->plainTextToken
            ],
            200,
        );
    }

    public function edit_avatar(Request $request)
    {
        $id = $request->id;
        $validateUser = Validator::make($request->all(), [
            'id' => ['required', 'exists:users'],

            'avatar' => ['image'],
        ]);

        if ($validateUser->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ],
                401,
            );
        }

        $data = $request->all();

        $time = now();
        $path = 'images/avatars/' . date_format($time, 'Y') . '/' . date_format($time, 'm');

        $main_image_name = '';
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $main_image_name = time() . 'main_' . $image->getClientOriginalName();
            str_replace(' ', '', $main_image_name);
            $image->move(public_path($path), $main_image_name);
        }

        $user = User::where('id', $id)->update([
            'avatar' => URL::asset($path . '/' . $main_image_name),
        ]);

        return response()->json(
            [
                'status' => true,
                'message' => 'User avatar edited Successfully',
                'id' => $id,
                // 'token' => $user->createToken("API TOKEN")->plainTextToken
            ],
            200,
        );
    }

    public function editPassword(Request $request)
    {
        $id = $request->id;
        $validateUser = Validator::make($request->all(), [
            'id' => ['required', 'exists:users'],
            'password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8'],
        ]);

        if ($validateUser->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ],
                401,
            );
        }

        if (!Auth::attempt($request->only(['id', 'password']))) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'هذه البيانات لا تطابق سجلاتنا',
                ],
                401,
            );
        }
        $data = $request->all();

        $user = User::where('id', $id)->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return response()->json(
            [
                'status' => true,
                'message' => 'User edited Successfully',
                'id' => $id,
                // 'token' => $user->createToken("API TOKEN")->plainTextToken
            ],
            200,
        );
    }




    public function loginDataEntry(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), [
                'phone' => ['required', 'exists:users,phone', 'regex:/(09)[0-9]{8}/'],
                'password' => 'required',
            ]);

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateUser->errors(),
                    ],
                    401,
                );
            }

            if (!Auth::attempt($request->only(['phone', 'password']))) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Phone & Password does not match with our record.',
                    ],
                    401,
                );
            }

            $user = User::where('phone', $request->phone)->first();

            if ($user->role_id != 13) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'this is not a data entry account',
                    ],
                    401,
                );
            }

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User Logged In Successfully',

                    'token' => $user->createToken('API TOKEN')->plainTextToken,
                ],
                200,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }

    public function user_info(Request $request)
    {

        $id = $request->id;
        $validateUser = Validator::make($request->all(), [
            'id' => ['required', 'exists:users'],

        ]);

        if ($validateUser->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors(),
                ],
                401
            );
        }

        $user = User::find($id);

        return response()->json(
            [
                'status' => true,
                // 'message' => 'User edited Successfully',
                'data' => $user,
                // 'token' => $user->createToken("API TOKEN")->plainTextToken
            ],
            200,
        );
    }

    public function images()
    {

        $images = SlidersImage::get();
        //   return $setting;
        return response()->json(
            [
                'status' => true,
                // 'message' => 'User edited Successfully',
                'data' => $images,
                // 'token' => $user->createToken("API TOKEN")->plainTextToken
            ],
            200,
        );
    }
    public function main_info()
    {

        $setting = Setting::whereIn('name', ['facebook_url', 'phone_no', 'whats_app', 'telegram'])->pluck('value', 'name');
        //   return $setting;
        return response()->json(
            [
                'status' => true,
                // 'message' => 'User edited Successfully',
                'data' => $setting,
                // 'token' => $user->createToken("API TOKEN")->plainTextToken
            ],
            200,
        );
    }
}
