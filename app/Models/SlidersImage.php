<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class SlidersImage extends Model
{
    use HasFactory;
    protected  $table = 'sliders_images';

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
