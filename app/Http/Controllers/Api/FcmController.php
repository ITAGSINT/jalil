<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FcmController extends Controller
{
    public function update(Request $request)
    {
        try{
            Auth::user()->update([
                'fcm_token' => $request->token
            ]);

            return response()->json([
                'message' => 'Token updated successfully'
            ]);
        }catch (\Throwable $th){

            return response()->json([
                'message' => 'Something went wrong'
            ],500);
        }

    }
}
