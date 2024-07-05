<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\themes;
use App\Models\templates;
use App\Models\section;
use App\Models\fields;
use App\Models\field_type;
use App\Models\User;
use App\Models\notifications;
use App\Models\user_types;
use App\Models\template_link;
use App\Models\template_link_fields;
use App\Models\subscriptions;
use App\Models\subscription_description;
use App\Models\duration_type;
use App\Models\message_recipient_user;
use App\Models\messages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;


use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class MessagesController extends Controller
{
    public function index()
    {
        $Users = User::with(['user_types'])->get();
        //return $Users;
        return view('dashboard.messages.index')->with(['Users' => $Users]);
    }

    public function index_user_message()
    {
        $Users = User::with(['user_types'])->get();
        $messages = messages::where('sender_user', Auth::id())->get();
        $message_recipient_user = message_recipient_user::where('user_id', Auth::id())->get();
        return view('dashboard.messages.inbox')->with(['messages' => $messages, 'Users' => $Users]);;
    }


    public function user_message_recipient_datatable()
    {
        $message_recipient_user = message_recipient_user::with(['messages'])->where('user_id', Auth::id())->orderBy('reserve_date', 'DESC')->get();
        return DataTables::of($message_recipient_user)

            ->addColumn('circle', function ($row) {
                if ($row->is_read == 0)
                    $st = ' <i class="fas fa-circle m_btn" id="circle_' . $row->id . '" style="color:#1d7af3"></i>';
                else
                    $st = ' <i class="fas fa-circle " ></i>';
                return $st;
            })

            ->addColumn('from_user', function ($row) {
                if ($row->is_read == 0)
                    $st = '<span style="font-weight: 900;" id="span_name_' . $row->id . '">' . $row->messages->sender_user_info->name . '</span>';
                else
                    $st = '<span>' . $row->messages->sender_user_info->name . '</span>';
                return  $st;
            })
            ->addColumn('from_date', function ($row) {
                if ($row->is_read == 0)
                    $st = '<span style="font-weight: 900;" id="span_date_' . $row->id . '">' . $row->reserve_date . '</span>';
                else
                    $st = '<span>' . $row->reserve_date . '</span>';
                return  $st;
            })
            ->addColumn('action', function ($row) {
                $st = '<span>' . $row->messages->text . '</span>';
                return $st;
            })

            ->addColumn('message_title', function ($row) {
                if ($row->is_read == 0)
                    $st = '<span style="font-weight: 900;" id="span_' . $row->id . '">' . $row->messages->title . '</span>';
                else
                    $st = '<span>' . $row->messages->title . '</span>';
                return $st;
            })

            ->rawColumns(['action', 'message_title', 'circle', 'from_user', 'from_date'])
            ->make(true);
    }
    public function user_message_datatable()
    {
        $messages = messages::with(['message_recipient_user', 'sender_user_info'])->where('sender_user', Auth::id())->orderBy('created_at', 'DESC')->get();


        //return $messages;
        if (app()->getLocale() == 'ar') {
            return DataTables::of($messages)
                ->addColumn('action', function ($row) {
                    $st = '<div style="float: left;"><a href="' . route('messages.message_index', $row->id) . '" class="btn btn-link">' . trans("dashboard.read-more") . ' <span class="btn-label"><i class="fas fa-arrow-right ml-1"></i></span></a></div>';
                    $st .= '<div class="form-group"><label for="field_type">' . trans("dashboard.from") . ' : </label>' . $row->sender_user_info->name . '<br><label for="field_type">' . trans("dashboard.to") . ' : </label><span>';
                    foreach ($row->message_recipient_user as $message_recipient_user) {
                        $st .= $message_recipient_user->user_info->name . ' ,';
                    }

                    $st .= '</span><br><label for="field_type">' . trans("dashboard.message") . ' : </label> ' . $row->text . '</div>';
                    return $st;
                })

                ->addColumn('user_name', function ($row) {

                    return $row->sender_user_info->name;
                })
                ->addColumn('read', function ($row) {
                    $messages_all_read = message_recipient_user::where('message_id', $row->id)->count();

                    $is_read = message_recipient_user::where('message_id', $row->id)->where('is_read', 1)->count();
                    $messages_is_read = (($is_read) * 100) / $messages_all_read;
                    $st = $is_read . '/' . $messages_all_read;
                    $st .= ' <div class="progress">'
                        . '<div class="progress-bar" role="progressbar" style="width: ' . $messages_is_read . '%;" aria-valuenow="' . $messages_is_read . '" aria-valuemin="0" aria-valuemax="' . $messages_all_read . '"></div>'
                        . '</div>';
                    return $st;
                })
                ->rawColumns(['action', 'user_name', 'read'])
                ->make(true);
        } else {
            return DataTables::of($messages)
                ->addColumn('action', function ($row) {
                    $st = '<div style="float: right;"><a href="' . route('messages.message_index', $row->id) . '" class="btn btn-link">' . trans("dashboard.read-more") . ' <span class="btn-label"><i class="fas fa-arrow-right ml-1"></i></span></a></div>';
                    $st .= '<div class="form-group"><label for="field_type">' . trans("dashboard.from") . ' : </label>' . $row->sender_user_info->name . '<br><label for="field_type">' . trans("dashboard.to") . ' : </label><span>';
                    foreach ($row->message_recipient_user as $message_recipient_user) {
                        $st .= $message_recipient_user->user_info->name . ' ,';
                    }

                    $st .= '</span><br><label for="field_type">' . trans("dashboard.message") . ' : </label> ' . $row->text . '</div>';
                    return $st;
                })

                ->addColumn('user_name', function ($row) {

                    return $row->sender_user_info->name;
                })
                ->addColumn('read', function ($row) {
                    $messages_all_read = message_recipient_user::where('message_id', $row->id)->count();

                    $is_read = message_recipient_user::where('message_id', $row->id)->where('is_read', 1)->count();
                    $messages_is_read = (($is_read) * 100) / $messages_all_read;
                    $st = $is_read . '/' . $messages_all_read;
                    $st .= ' <div class="progress">'
                        . '<div class="progress-bar" role="progressbar" style="width: ' . $messages_is_read . '%;" aria-valuenow="' . $messages_is_read . '" aria-valuemin="0" aria-valuemax="' . $messages_all_read . '"></div>'
                        . '</div>';
                    return $st;
                })
                ->rawColumns(['action', 'user_name', 'read'])
                ->make(true);
        }
    }
    public function message_index($id)
    {
        $messages = messages::with(['message_recipient_user', 'sender_user_info'])->where('id', $id)->first();
        $messages_all_read = message_recipient_user::where('message_id', $id)->count();
        $messages_is_read = ((message_recipient_user::where('message_id', $id)->where('is_read', 1)->count()) * 100) / $messages_all_read;
        $messages_not_read = ((message_recipient_user::where('message_id', $id)->where('is_read', 0)->count()) * 100) / $messages_all_read;

        //return $messages_not_read;
        return view('dashboard.messages.message')->with(['messages' => $messages, 'messages_not_read' => $messages_not_read, 'messages_is_read' => $messages_is_read]);
    }

    public function add(Request $request)
    {
        //return $request->users_ids;

        $rules = [
            "title" => ['required'],
            "text" => ['required'],
            "users_ids" => ['required'],
        ];
        foreach ($rules as $key => $value) {
            if ($key != "images.*" && $key != "video")
                $attributes_name[$key] = __('attribute.' . $key);
        }

        $validator = Validator::make($request->all(), $rules, [], $attributes_name);
        if ($validator->fails()) {
            //return redirect()->back()->with('error', 'Enter All fields');
            //return response()->json(['code' => 0, 'error' => 'Enter All fields']);
            return redirect()->back()->withInput()->with('error', 'Enter All fields');
        }


        //$firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
        $firebaseToken = User::whereIn('id', $request->users_ids)->pluck('fcm_token')->all();

        // $SERVER_API_KEY = 'AAAAA2xUMbw:APA91bF9ADEXkUvqAUSevZeVBv4400T49SFoTJtAoF6ZMwOEle66XF0qpaGVdFsWIUQvYuFVsGkqEdKQrArNbXmSZUuTDsV5tWAGvqos8Wo_27wOTc2HXemK-aCloIW8ng3UqMVOlao1';
        $SERVER_API_KEY = 'AAAAqqJbqGo:APA91bGK5zGjeIW7__jI8fDAYdOtXwzvKTxhihx0EgnMnv_FP9qDMtQrEx-isyX52tbD9lEk11fERiadqkBd6Yl9qR8ZFHTIdUYmyosJs0yqr0OhfyD6OqFMOJD5VSv5lKmvAvIjUNM7';

        if ($request->notifi != 1) {

            $messages = messages::create([
                'title' => $request->title,
                'text' => $request->text,
                'sender_user' =>  Auth::id(),
                'created_at' => now()
            ]);
            foreach ($request->users_ids as $user) {
                //return $field;

                $message_recipient_user = message_recipient_user::create([
                    'message_id' => $messages->id,
                    'sender_user' => Auth::id(),
                    'user_id' => $user,
                    'is_read' => 0,
                    'reserve_date' => now()
                ]);
            }


            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => 'message',
                    "body" => $request->text,
                ]
            ];
        }

        if ($request->notifi == 1) {


            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => 'Kit',
                    "body" => $request->text,
                ]
            ];
        }


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


        //$themes = themes::where('is_active', 1)->get();
        return redirect()->back()->with('success', 'Messages was send');
        //return response()->json(['code' => 1, 'success' => 'section was added']);
    }
    public function messages_datatable()
    {
        $messages = messages::with(['message_recipient_user', 'sender_user_info'])->orderBy('created_at', 'DESC')->get();
        //return $messages;
        if (app()->getLocale() == 'ar') {
            return DataTables::of($messages)
                ->addColumn('action', function ($row) {
                    $st = '<div style="float: left;"><a href="' . route('messages.message_index', $row->id) . '" class="btn btn-link">' . trans("dashboard.read-more") . ' <span class="btn-label"><i class="fas fa-arrow-right ml-1"></i></span></a></div>';
                    $st .= '<div class="form-group"><label for="field_type">' . trans("dashboard.from") . ' : </label>' . $row->sender_user_info->name . '<br><label for="field_type">' . trans("dashboard.to") . ' : </label><span>';
                    foreach ($row->message_recipient_user as $message_recipient_user) {
                        $st .= $message_recipient_user->user_info->name . ' ,';
                    }

                    $st .= '</span><br><label for="field_type">' . trans("dashboard.message") . ' : </label> ' . $row->text . '</div>';
                    return $st;
                })
                ->addColumn('user_name', function ($row) {

                    return $row->sender_user_info->name;
                })
                ->rawColumns(['action', 'user_name'])
                ->make(true);
        } else {
            return DataTables::of($messages)
                ->addColumn('action', function ($row) {
                    $st = '<div style="float: right;"><a href="' . route('messages.message_index', $row->id) . '" class="btn btn-link">' . trans("dashboard.read-more") . ' <span class="btn-label"><i class="fas fa-arrow-right ml-1"></i></span></a></div>';
                    $st .= '<div class="form-group"><label for="field_type">' . trans("dashboard.from") . ' : </label>' . $row->sender_user_info->name . '<br><label for="field_type">' . trans("dashboard.to") . ' : </label><span>';
                    foreach ($row->message_recipient_user as $message_recipient_user) {
                        $st .= $message_recipient_user->user_info->name . ' ,';
                    }

                    $st .= '</span><br><label for="field_type">' . trans("dashboard.message") . ' : </label> ' . $row->text . '</div>';
                    return $st;
                })
                ->addColumn('user_name', function ($row) {

                    return $row->sender_user_info->name;
                })
                ->rawColumns(['action', 'user_name'])
                ->make(true);
        }
    }
    public function red_message(Request $request)
    {
        $message_recipient_user = message_recipient_user::where('user_id', Auth::id())->where('id', $request->id)->first();
        //  return $request->id;
        if ($message_recipient_user->is_read == 0) {
            $message_recipient_user->update([
                'is_read' => 1,
                'read_date' => now()
            ]);
            return response()->json(['code' => 1, 'success' => 'is read']);
        }
        return response()->json(['code' => 0, 'error' => 'Enter All fields']);
    }

    public function get_message()
    {
        $messages = message_recipient_user::with(['messages'])->where('user_id', Auth::id())->where('is_read', 0)->get()->map(function ($row) {
            if ($row->messages != null) {
                $date = $row->messages->created_at;
            }
            $now = now();

            $monthdate = Carbon::parse($date);
            $dateDiff = $monthdate->diffInMinutes(Carbon::now());
            $row->user_name = $row->messages->sender_user_info->name;
            if (strlen($row->messages->text) >= 30)
                $row->message_text = substr($row->messages->text, 0, 30) . '...';
            else
                $row->message_text = $row->messages->text;

            if ($dateDiff == 0) {
                $row->date1 = 'Now';
            }
            if ($dateDiff < 60) {
                if ($dateDiff == 1)
                    $row->date1 = $dateDiff . ' minute ago';
                else
                    $row->date1 = $dateDiff . ' minutes ago';
            } else {
                $dateDiff = $monthdate->diffInHours(Carbon::now());
                if ($dateDiff < 24) {
                    if ($dateDiff == 1)
                        $row->date1 = $dateDiff . ' hour ago';
                    else
                        $row->date1 = $dateDiff . ' hours ago';
                } else {
                    $dateDiff = $monthdate->diffInDays(Carbon::now());
                    if ($dateDiff < 30) {
                        if ($dateDiff == 1)
                            $row->date1 = $dateDiff . ' day ago';
                        else
                            $row->date1 = $dateDiff . ' days ago';
                    } else {
                        $row->date1 = 'from ' . $monthdate->toDateString();
                    }
                }
            }
            return $row;
        });
        return $messages;
    }
    public function get_notification()
    {
        $notifications = notifications::
            // where('is_done',0)->
            orderBy('id', 'DESC')->get()->map(function ($row) {
                $date = $row->created_at;
                $now = now();

                $monthdate = Carbon::parse($date);
                $dateDiff = $monthdate->diffInMinutes(Carbon::now());
                //$row->user_name=$row->messages->sender_user_info->name    ;

                //  $row->content= $row->messages->text;

                if ($dateDiff == 0) {
                    $row->date1 = 'Now';
                }
                if ($dateDiff < 60) {
                    if ($dateDiff == 1)
                        $row->date1 = $dateDiff . ' minute ago';
                    else
                        $row->date1 = $dateDiff . ' minutes ago';
                } else {
                    $dateDiff = $monthdate->diffInHours(Carbon::now());
                    if ($dateDiff < 24) {
                        if ($dateDiff == 1)
                            $row->date1 = $dateDiff . ' hour ago';
                        else
                            $row->date1 = $dateDiff . ' hours ago';
                    } else {
                        $dateDiff = $monthdate->diffInDays(Carbon::now());
                        if ($dateDiff < 30) {
                            if ($dateDiff == 1)
                                $row->date1 = $dateDiff . ' day ago';
                            else
                                $row->date1 = $dateDiff . ' days ago';
                        } else {
                            $row->date1 = 'from ' . $monthdate->toDateString();
                        }
                    }
                }
                return $row;
            });


        $not_read = $notifications->where('read_at', null)->count();
        return [$notifications, $not_read];
    }
}
