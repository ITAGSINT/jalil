<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Twilio\Exceptions\RestException;
use Twilio\Rest\Client;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.user-login');
    }

    protected function register(Request $request)
    {
        $data = $request->all();
        $validateUser = Validator::make($data, [
            'phone' => ['required', 'numeric']

        ]);

        if ($validateUser->fails()) {
            return redirect()->back()->withErrors($validateUser)->withInput($data);
        }


        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio_message_sid = getenv("TWILIO_MESSAGE_SID");
        $twilio = new Client($twilio_sid, $token);



        if ($user = User::where('phone', $request->phone)->first()) {

            //check if he has verified his phone or not

            if ($user->phone_verified == null) {
                $user->update(['fcm_token' => $request->fcm_token]);

                $verification = $twilio
                    ->verify
                    ->v2
                    ->services($twilio_verify_sid)
                    ->verifications
                    ->create($request->phone, "sms");
                return redirect()->route('user.verify_page')->with(['phone' => $data['phone']]);
            } else {
                return redirect()->back()->with(['message' => 'this phone number is taken']);
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
            return redirect()->route('user.verify_page')->with(['phone' => $data['phone']]);
        }
    }

    protected function verify_page(Request $request)
    {
        return view('auth.verify');
    }
    protected function verify(Request $request)
    {

        // return redirect()->route('website.index');
        $validateUser = Validator::make($request->all(), [
            'verification_code' => ['required', 'numeric'],
            'phone' => ['required', 'string'],
        ]);

        if ($validateUser->fails()) {
            return redirect()->back()->withErrors($validateUser)->withInput($request->all());
        }
        $data = $request->all();

        $user = User::where('phone', $request->phone)->first();

        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);

        try { {
                // return 'not verfiy';
                $verification = $twilio->verify->v2->services($twilio_verify_sid)
                    ->verificationChecks
                    ->create(['code' => $data['verification_code'], 'to' => $data['phone']]);


                if ($verification->valid) {
                    $user = tap(User::where('phone', $data['phone']))->update(['phone_verified' => true]);
                    /* Authenticate user */
                    Auth::login($user->first());
                    return redirect()->route('website.index');
                }


                return redirect()->back()->with(
                    [
                        'message' => 'Invalid verification code entered!',
                        'phone' => $data['phone']
                        // 'token' => $user->createToken("API TOKEN")->plainTextToken
                    ]
                );
            }
        } catch (RestException $exception) {

            // return $exception;
            return redirect()->back()->with(
                [

                    'message' => 'Something went wrong',

                ]
            );
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
                return redirect()->back()->withErrors($validateUser)->withInput($request->all());
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
                return redirect()->route('user.verify_page')->with(['phone' => $request->phone]);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with(
                [

                    'message' => 'Something went wrong',

                ]
            );
        }
    }
}
