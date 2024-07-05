<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FcmController extends Controller
{
    public function update(Request $request){
        Auth::user()->update([
            'fcm_token' => $request->token
        ]);

        return response()->json(['success'=>true]);
    }

    public function send(){

        // $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();

        // $SERVER_API_KEY = 'AAAAA2xUMbw:APA91bF9ADEXkUvqAUSevZeVBv4400T49SFoTJtAoF6ZMwOEle66XF0qpaGVdFsWIUQvYuFVsGkqEdKQrArNbXmSZUuTDsV5tWAGvqos8Wo_27wOTc2HXemK-aCloIW8ng3UqMVOlao1';
        $firebaseToken = User::where('id',57)->pluck('fcm_token')->all();

        $SERVER_API_KEY = env('FCM_SERVER_KEY');
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => 'order accepted',
                "body" => 'your support team has been assigned',
                "mutable_content" => true,
                "sound" => "Tri-tone"
            ],
            "data" =>["id"=>1,'status'=>1],
            "priority" =>  "high",
            "content_available" =>  true
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

        $response = curl_exec($ch);

        dd($response);
    }
}
