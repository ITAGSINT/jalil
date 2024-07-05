<?php

namespace App\Models;

use App\scopes\OrderScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'coupon_code' => 'array',
        'car_id' => 'integer',
        'order_id' => 'integer',
    ];

    // public function statusHistory()
    // {
    //     return $this->belongsToMany(OrderStatus::class, 'orders_status_history', 'orders_id', 'orders_status_id')->withPivot('date_added', 'comments')->orderByPivot('orders_status_history_id', 'desc');
    // }

    // public function status()
    // {
    //     return $this->belongsToMany(OrderStatus::class, 'orders_status_history', 'orders_id', 'orders_status_id')->withPivot('date_added', 'comments')->orderByPivot('orders_status_history_id', 'desc')->take(1);
    // }

    public function currents()
    {
        //   return $this->hasOne(Application_status_log::class, 'application_id', 'id')->latestOfMany();
        return $this->hasOne(OrderStatusHistory::class, 'order_id', 'id')->latestOfMany('id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id')->select(['id', 'name', 'loc_lat', 'loc_long', 'address', 'street', 'city', 'state']);
    }


    public function payment()
    {
        return $this->belongsTo(PaymentHistory::class, 'transaction_id', 'id');
    }


    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function driverName()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function pendingDrivers()
    {
        return $this->belongsToMany(User::class, 'orders_drivers','order_id', 'driver_id');
    }

    public function products()
    {
        return  $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function code()
    {
        return $this->belongsTo(Coupon::class, 'coupon_code', 'code');
    }
    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method', 'id');
    }

    // protected static function booted()
    // {
    //     static::addGlobalScope(new OrderScope);
    // }
}
