<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
      public function authenticated(){
        if(Auth::user()->role_id==2){
            return redirect('/')->with('success','logged successfully');
        }
        if(Auth::user()->role_id=='26'){ return redirect('accounting')->with('success','Hi');}
        if(Auth::user()->role_id=='27'||Auth::user()->role_id=='28'){ return redirect('delivery')->with('success','Hi');}
        if(Auth::user()->role_id=='16'||Auth::user()->role_id=='17'||Auth::user()->role_id=='18'||Auth::user()->role_id=='19'||Auth::user()->role_id=='20'){return redirect('stores')->with('success','Hi');}
        if(Auth::user()->role_id=='12'||Auth::user()->role_id=='15'||Auth::user()->role_id=='21'||Auth::user()->role_id=='3'){return redirect('POS')->with('success','Hi');}
        if(Auth::user()->role_id=='14'){return redirect('POS/Sales_Interface')->with('success','Hi');}
        if(Auth::user()->role_id=='30'||Auth::user()->role_id=='31'||Auth::user()->role_id=='32'||Auth::user()->role_id=='33'||Auth::user()->role_id=='34'){return redirect('ecommerce')->with('success','Hi');}
        else{
            return redirect('dashboard')->with('success','Hi');
        }
       
    }
}
