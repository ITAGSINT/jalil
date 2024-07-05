<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $guarded = [];
    protected $casts = ['categories_status' => 'boolean'];
    // protected $primaryKey = 'id';

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }


    public function sun()
    {
        return $this->belongsTo(Category::class, 'id', 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function image(): Attribute
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
