<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;
    protected $table = 'orders_status_history';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];


    public function statusDesc()
    {
        //   return $this->hasOne(Application_status_log::class, 'application_id', 'id')->latestOfMany();
        return $this->hasOne(OrderStatus::class, 'id', 'status_id');
    }
}
