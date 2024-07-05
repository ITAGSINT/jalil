<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role_id==1) {
                return redirect()->intended('/dashboard');
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->withErrors(['email' => 'Unauthorized access.']);
            }
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }

}
