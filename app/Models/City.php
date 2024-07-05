<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope('hidden', function ( $builder) {
            $builder->where('is_hidden', 0);
        });
    }
}
