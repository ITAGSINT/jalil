<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class UImage extends Model
{
    use HasFactory;
    protected $table='images';
    protected $fillable=['name','user_id','x','y','parent_id','description','description_ar'];
    protected $primaryKey = 'id';
    public function path(){
        $path=DB::table('image_categories')->where('image_id',$this->id)->get()->first()->path;
        return $path;
    }
    public function path2(){
        $reviews = DB::table('images')
        ->join('image_categories', 'image_categories.image_id', '=', 'images.id')
        ->where('parent_id','!=',0)
        ->where('parent_id','=',$this->id)
        ->select('images.*','image_categories.path')
        ->get()->first();
        if ($reviews != null)
        return  $reviews;
        
    }
   
}
