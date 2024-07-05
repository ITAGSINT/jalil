<?php

namespace App\Models;

use App\Scopes\LangScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductOption extends Model
{
    use HasFactory;
    protected $table = 'products_options';
    protected $primarKey = 'products_options_id';
      public $timestamps = false;
    protected $fillable = [
        'products_options_name'
    ];
    public function description()
    {
        
      return $this->hasMany(products_options_descriptions::class,'products_options_id','products_options_id')->withGlobalScope(3,LangScope::class);
    }
    public function descriptionFE()
    {
      return $this->hasMany(products_options_descriptions::class,'products_options_id','products_options_id');
    }
    public function name1($value_id)
    {
        $name = DB::table('products_options_values')
        ->join('products_options_values_descriptions','products_options_values.products_options_values_id','products_options_values_descriptions.products_options_values_id')
        ->where('products_options_values.products_options_id', $this->products_options_id)

        ->where('products_options_values.products_options_values_id',$value_id)
        ->get(['products_options_values_descriptions.options_values_name as value_name','products_options_values_descriptions.products_options_values_id as value_id','product_act_val'])->first()->product_act_val;
        return $name;
    }
    public function name()
    {
        if (LaravelLocalization::getCurrentLocale() == 'ar')
            $lang = 4;
        else
            $lang = 1;
        $name = DB::table('products_options_descriptions')->where('products_options_id', $this->products_options_id)->where('language_id', $lang)->select(['options_name'])->first()->options_name;
        return $name;
    }
    public function values(){
        if (LaravelLocalization::getCurrentLocale() == 'ar')
            $lang = 4;
        else
            $lang = 1;
        $name = DB::table('products_options_values')
        ->join('products_options_values_descriptions','products_options_values.products_options_values_id','products_options_values_descriptions.products_options_values_id')
        ->where('products_options_values.products_options_id', $this->products_options_id)->where('language_id', $lang)->get(['options_values_name as value_name','products_options_values.products_options_values_id as value_id']);
        return $name;
    }
    
      public function valueName($value_id){
            if (LaravelLocalization::getCurrentLocale() == 'ar')
                $lang = 4;
            else
                $lang = 1;
            $name = DB::table('products_options_values')
            ->join('products_options_values_descriptions','products_options_values.products_options_values_id','products_options_values_descriptions.products_options_values_id')
            ->where('products_options_values.products_options_id', $this->products_options_id)
            ->where('language_id', $lang)
            ->where('products_options_values.products_options_values_id',$value_id)
            ->get(['products_options_values_descriptions.options_values_name as value_name','products_options_values_descriptions.products_options_values_id as value_id'])->first()->value_name;
            return $name;

    }
    public function valueName1($value_id,$products_options_id){
        if (LaravelLocalization::getCurrentLocale() == 'ar')
            $lang = 4;
        else
            $lang = 1;
        $name = DB::table('products_options_values')
        ->join('products_options_values_descriptions','products_options_values.products_options_values_id','products_options_values_descriptions.products_options_values_id')
        ->where('products_options_values.products_options_id', 'products_options_id')
        ->where('language_id', $lang)
        ->where('products_options_values.products_options_values_id',$value_id)
        ->get(['products_options_values_descriptions.options_values_name as value_name','products_options_values_descriptions.products_options_values_id as value_id'])->first()->value_name;
        return $name;

}
}
