<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\orders_products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\products_options_values_descriptions;
use App\Models\products_options_descriptions;

class home_Controller extends Controller
{
    //
    public function index()
    {


        return view('dashboard.statistics')
            ->with([

            ]);
    }
    public function profile(Request $request)
    {
        $client_id = Auth::id();
        $user = User::with(['user_types'])->where('id', $client_id)->first();
        return view('dashboard.profile')->with([
            'user' => $user,
        ]);
    }
    public function profile_POS(Request $request)
    {
        $client_id = Auth::id();
        $user = User::with(['user_types'])->where('id', $client_id)->first();
        return view('POS.profile')->with([
            'user' => $user,
        ]);
    }
}
