<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class PayController extends Controller
{
    //
    
    
    public function index($order,$checkoutId,$type){
        
        $order_type=Order::withoutGlobalScopes()
                ->where('orders_id',$order)
                ->where('order_status',1);
        if(!$order_type->exists())
            abort(404);
            
        $order_type = $order_type ->first()->payment_method;
        
        if($order_type=='mada')
            $type='MADA';
        else{
            $type='VISA MASTER';
        }
        
        
        return view('website.pay.index',[
            'order'=>$order,
            'id'=>$checkoutId,
            'type'=>$type,
            ]);
        
    }
    
    
    public  function pay($type,$amount,$order,$email="modichic.com@gmail.com"){
             
           $payments_setting =SELF::paymentSetting();
           $amount=number_format((float)$amount, 2, '.', '');
           
           
           $url = "https://eu-prod.oppwa.com/v1/checkouts";
           if($type=="VISA")
                {$data = "entityId=".$payments_setting['entityid']->value.
               "&amount=".$amount.
               "&currency=SAR" .
               "&paymentType=DB".  
               "&customer.email=" .$email.
               "&merchantTransactionId=" . uniqid();
               ;
               $type .= " MASTER";
         
           }else{
                $data = "entityId=".$payments_setting['entityidmada']->value.
               "&amount=".$amount.
               "&currency=SAR" .
               "&paymentType=DB".
               "&customer.email=" . $email.
               "&merchantTransactionId=" . uniqid();
                ;
           }
            
            
        	$ch = curl_init();
        	curl_setopt($ch, CURLOPT_URL, $url);
        	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                           'Authorization:Bearer '.$payments_setting['userid']->value));
        	curl_setopt($ch, CURLOPT_POST, 1);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	$responseData = curl_exec($ch);
        	//dd($responseData);
        	if(curl_errno($ch)) {
        		return curl_error($ch);
        	}
        	curl_close($ch);
            
        	
        	$res = json_decode($responseData);
       
                if ($res->result->code == '000.200.100') {
                   
	                return route('mobile.pay.index',[
	                    'order'=>$order,
	                    'checkoutId'=>$res->id,
	                    'type'=>$type
	                    ]);
                    
                } else {
                    return false;
                }
           
		   
    }
    
    
    public function paymentstatus($id,Request $req){
        
          
          
          
          $order=Order::withoutGlobalScopes()->where('orders_id',$id)->where('order_status',1);
          
          if(!$order->exists())
            abort(404);
          else{
              $order=$order->first();
          }
          $payments_setting=SELF::paymentSetting();
          
          $info ['payment']= $order->payment_method;
          
          if($info['payment']=="visa"){
            $entity = $payments_setting['entityid']->value;
          }else if($info['payment']=="mada"){
            $entity = $payments_setting['entityidmada']->value;
          }else{
            $entity = $payments_setting['entityidmada']->value;
           }
          
           //dd($entity);
           $url = "https://eu-prod.oppwa.com/".$req['resourcePath'];
           $url .= "?entityId=".$entity;
           
           
        	$ch = curl_init();
        	curl_setopt($ch, CURLOPT_URL, $url);
        	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                           'Authorization:Bearer '.$payments_setting['userid']->value));
        	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	$responseData = curl_exec($ch);
        	if(curl_errno($ch)) {
        		return curl_error($ch);
        	}
        	curl_close($ch);
            
        	 $data = json_decode($responseData);
        	 
                DB::table('response')->insert([
                    'response' => json_encode($data)
                    
                ]);
        
                $success = false ; 
                $error = false;
                if (preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $data->result->code)) {
                    
                        $order->payment_method='Hyper Pay';
                        $order->order_status=2;
                        $order->save();
                        return view('website.payment_status')->with([
                            'success'=>'تم الدفع واضافة الطلب بنجاح',
                            'error'=>false
                            ]);
                
                
                } else {
                    
                    $order->order_status=4;
                    $order->save();
                    return view('website.payment_status')->with([
                        
                            'success'=>false,
                            'error'=>'لم تتم عملية الدفع'
                            ]);
                }
                
        	
 }
 
    public static function paymentSetting(){
         $payments_setting = DB::table('payment_methods_detail')
            ->leftjoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
            ->leftjoin('payment_methods', 'payment_methods.payment_methods_id', '=', 'payment_methods_detail.payment_methods_id')
            ->select('payment_methods_detail.*', 'payment_description.name', 'payment_methods.environment', 'payment_methods.status', 'payment_methods.payment_method')
            ->where('language_id', session('language_id'))
            ->where('payment_description.payment_methods_id', 6)
            ->orwhere('language_id', 1)
            ->where('payment_description.payment_methods_id', 6)
            ->get()->keyBy('key');
          return $payments_setting;
     }
    
}
