<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'models';

    public function manufacture()
    {
        return $this->belongsTo(CarManufacturer::class, 'manufacturer_id', 'id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'models_colors', 'model_id')->withPivot('image');
    }



    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_models', 'model_id', 'product_id');
    }

    protected static function booted(): void
    {
        static::addGlobalScope('hidden', function (Builder $builder) {
            $builder->where('is_hidden', 0);
        });
    }
}
