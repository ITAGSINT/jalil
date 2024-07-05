<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    public function models()
    {
        return $this->belongsToMany(CarModel::class,'models_colors','model_id')->withPivot('image');
    }


    public function scopeShown($query)
    {
        return $query->where('is_hidden', '=', 0);
    }
}
