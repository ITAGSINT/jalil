<?php

namespace App\Http\Controllers\website;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use App\Models\Product;
use App\Models\LikedProducts;
use App\Models\User;
use App\Models\ProductDesc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ProductOption;
use Illuminate\Support\Facades\URL;

use App\Http\Auth\RegisterController;
class EditUserController extends Controller
{
    
    public function edit_to_login(Request $request){
        
            $validator = Validator::make($request->all(),[
            
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
           
        ]);
        
        if($validator->fails()){
            return redirect()->back()->with('error',"Please check required fileds");
        }
         else{
             
         $user_id=Auth::id();
       
        if($user_id==null){
            if(request()->cookie('user_id')==null){
         
          }
          else{
          $user_id=request()->cookie('user_id');}
        
            } 
         // $user_id =Auth::User()->id;
          $user=User::find($user_id);
            if($user->name==null)
                $user->name=$request->name;
            if($user->email==null)
                $user->email=$request->email;
            if($user->password==null)
                $user->password=Hash::make($data['password']);
             
          $user->save();
          if (Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
       
            return redirect();
        }
        else{}
        
    }
}
    
}