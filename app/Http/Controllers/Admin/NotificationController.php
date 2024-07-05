<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\notifications;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class NotificationController extends Controller
{
    public function test()
    {
        $firebaseToken = User::where('id', 1)->pluck('fcm_token')->all();

        $SERVER_API_KEY = env('FCM_SERVER_KEY');

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => 'notification_user_regest',
                "body" => 1,
            ]
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
        $notifications = notifications::create([
            'type' => 'App\Notifications\MyNotification','notifiable_type'=>'App\Models\User','notifiable_id'=>1,  'data' => 'New user registered',  'action' => ''
        ]);
    }

    public function update(Request $req)
    {
        $id = $req->id;
        $notifi = notifications::where('id', $id)->first();
        $notifi->read_at = now();
        $notifi->save();
        return redirect()->to($notifi->action);
    }
}
