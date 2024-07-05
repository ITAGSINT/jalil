<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function hidden_model()
    {
        return $this->belongsTo(CarModel::class)->withoutGlobalScopes();
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function scopeShown($query)
    {
        return $query->where('is_hidden', '=', 0);
    }
}
