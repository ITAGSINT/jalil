<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryDesc;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\UImage;
use App\Scopes\LangScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
 



class mobile_users extends Controller
{
   public function newDevice(Request $request){
      
      
        $apple_id_pattern =  "/^[0-9 a-f]{8}-[0-9 a-f]{4}-[0-9 a-f]{4}-[0-9 a-f]{4}-[0-9 a-f]{12}$/i";
        
        $android_id_pattern = "/^[0-9 a-f]{16}$/";
        
        
        if(!preg_match($apple_id_pattern,$request->device_id)){
            if(!preg_match($android_id_pattern,$request->device_id))
            {
            $response=[
                'success'=>false,
                'message'=>'Device id is required and must match this pattern: Android device => XXXXXXXXXXXXXXXX 16 Hex digit , Apple device =>XXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX'
                ];
        
             return response()->json($response,400);
                
            }
        }                     
        
           
        
        
        $user_id=NULL;
     
        if(!User::where('device',$request->device_id)->exists()){
        $user = new User();
         $user->first_name='user'.time();
         $user->email=$user->first_name.'@gmail.com';
         $user->phone='00000000';
         $user->status=1;
         $user->role_id=2;
         $user->device=$request->device_id;
         $user->device_order=0;
         $user->save();
         $user_id=$user->id;
         $response=[
            'success'=>true,
            'data'=>['user_id'=>$user_id],
            'message'=>'new device added successfully '
        ];
        }else{
            $user_id= User::where('device',$request->device_id)->first()->id;
            $response=[
            'user_id'=>$user_id
        ];
            
        }
          
        return response()->json($response,200);
     
       
       
   }
    
}