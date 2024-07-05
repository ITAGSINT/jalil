<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class upload extends Controller
{
    public function imgUpload(Request $request){
        
$data = $request->image;

list($type, $data) = explode(';', $data);
list(, $data) = explode(',', $data);

$data = base64_decode($data);
$imageName ='sub'.time().'.png';
$time = now();
$path = '/home/makffkkr/belucci-test.shop/public/images/media/' . date_format($time, 'Y') . '/' . date_format($time, 'm').'/';
$path1 = 'public/images/media/' . date_format($time, 'Y') . '/' . date_format($time, 'm').'/';

file_put_contents($path.$imageName, $data);

return "/".$path1.$imageName;
    }
}

