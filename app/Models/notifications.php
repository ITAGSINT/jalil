<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notifications extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = [];

    public function user_info()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
