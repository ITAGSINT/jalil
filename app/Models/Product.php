<?php

namespace App\Models;

use App\Scopes\LangScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    // protected $primaryKey = 'products_id';
    protected $guarded = [];


    /**
     *  public function categoryName(){
     *   return $this->hasMany(products_to_categories::class,'products_to_categories_id','products_id');
     *}
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(product_manufacturers::class, 'manufacturer_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function models()
    {
        return $this->belongsToMany(CarModel::class, 'products_models', 'product_id', 'model_id');
    }

    public function models_id()
    {
        return $this->belongsToMany(CarModel::class, 'products_models', 'product_id', 'model_id')->select('model_id');
    }

    public function mainImage(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => URL::asset($value),
            set: function ($file) {
                if (is_string($file)) {
                    return $file;
                } else {
                    $name = uniqid('img_') . '.' . $file->getClientOriginalExtension();
                    $path = 'images';
                    $file->storeAs('public/' . $path, $name);
                    return 'storage/' . $path . '/' . $name;
                }
            }
        );
    }
}
