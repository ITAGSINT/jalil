<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountingMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->role_id=='26'){
                if(Auth::user()->status==1)
                {return $next($request);}
                else
                { return redirect('/')->with('status','your account is not activated');}
            }
        
            else{
               
                return abort(403);  
          
       }}
       else{
        return redirect('/')->with('status','please login first');
       }
    }
}