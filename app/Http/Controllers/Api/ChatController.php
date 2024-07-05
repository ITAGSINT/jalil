<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\notifications;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function getConversations()
    {
        $userId = Auth::id();

        // $conversations=Message::w
        $conversations = User::select('id', 'name')
            // where('id', '!=', $userId)
            ->withCount(['sentMessages as count' => function ($query) use ($userId) {
                $query->where('receiver_id', $userId)->whereNull('read_at');
            }])
            ->with(['receivedMessages' => function ($query) use ($userId) {
                $query->where('sender_id', $userId)->latest();
            }])
            ->with(['sentMessages' => function ($query) use ($userId) {
                $query->where('receiver_id', $userId)->latest();
            }])
            ->whereHas('receivedMessages', function ($query) use ($userId) {
                $query->where('sender_id', $userId)->latest();
            })
            ->orWhereHas('sentMessages', function ($query) use ($userId) {
                $query->where('receiver_id', $userId)->latest();
            })

            // ->orHas('sentMessages')
            ->get()
            ->map(function ($user) {
                $latest_message_received = $user->receivedMessages->first();
                $latest_message_sent = $user->sentMessages->first();
                if ($latest_message_sent != null && $latest_message_received != null) {
                    $user->last_message = ($latest_message_sent->sent_at > $latest_message_received->sent_at) ? $latest_message_sent : $latest_message_received;
                    // $user->last_message = $latest_message_sent;
                } else if ($latest_message_sent != null && $latest_message_received == null)
                    $user->last_message = $latest_message_sent;

                else if ($latest_message_sent == null && $latest_message_received != null)
                    $user->last_message = $latest_message_received;
                return $user;
            });

        $conversations
            ->makeHidden(['sentMessages', 'receivedMessages']);
        $response['success'] = true;
        $response['data'] = $conversations;
        return response()->json($response, 200);
    }

    public function getMessages(User $user)
    {
        $userId = Auth::id();

        $messages = Message::select('id', 'sender_id', 'receiver_id', 'message', 'image', 'sent_at', 'read_at')
            ->where(function ($query) use ($user, $userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $user->id);
            })->orWhere(function ($query) use ($user, $userId) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $userId);
            })->get();
        $messages['user_name'] = Auth::user()->name;
        $messages['friend_name'] = $user->name;
        // ->with('sender:id,name', 'receiver:id,name')

        return response()->json(['success' => true, 'data' => $messages], 200);
    }

    public function sendMessage(Request $request, User $user)
    {
        $request->validate([
            'message' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $message = new Message();
        $message->sender_id = Auth::id();
        $message->receiver_id = $user->id;
        $message->message = $request->message;
        $message->sent_at = Carbon::now();

        if ($request->hasFile('image')) {
            // $path = $request->file('image')->store('public/images');
            $message->image = $request->file('image');
        }

        $message->save(); {
            $firebaseToken = User::where('id', $user->id)->pluck('fcm_token')->all();

            $SERVER_API_KEY = env('FCM_SERVER_KEY');

            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => 'New Message from ' . Auth::user()->name . '',
                    "body" => 'Head to chat to see it',
                    "mutable_content" => true,
                    "sound" => "Tri-tone"
                ],


                "priority" =>  "high",
                "content_available" =>  true
            ];

            $payload = [
                'title' => 'New Message from ' . $user->name . '',
                'body'  => 'Head to chat to see it',
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
                'type' => 'App\Notifications\MyNotification', 'notifiable_type' => 'App\Models\User', 'notifiable_id' => $user->id,
                'data' => json_encode($payload),  'action' => ''
            ]);
        }


        return response()->json(['success' => true, 'message' => 'message sent successfully'], 200);
    }

    public function markAsRead(User $user)
    {
        $userId = Auth::id();

        Message::where('sender_id', $user->id)
            ->where('receiver_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => Carbon::now()]);

        return response()->json(['success' => true, 'message' => 'messages read successfully'], 200);
    }
}
