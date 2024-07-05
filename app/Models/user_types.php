<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_types extends Model
{
    use HasFactory;
    
    protected $table = 'user_types';
    protected $primaryKey = 'user_types_id';
    public $timestamps = false;
    protected $fillable = [
        'user_types_name', 'isActive'
    ];
    
   
}


