<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\URL;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function avatar(): Attribute
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



    public function toggleActive()
    {
        $this->is_active = !$this->is_active;
        $this->save();
    }

    public function user_types()
    {
        return $this->hasOne(user_types::class, 'user_types_id', 'role_id');
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'default_address_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customers_id');
    }

    public function driverOrders()
    {
        return $this->hasMany(Order::class, 'driver_id');
    }

    // public function pendingDrivers()
    // {
    //     return $this->belongsToMany(User::class, 'orders_drivers','order_id', 'driver_id');
    // }
    public function pendingOrders()
    {
        return $this->belongsToMany(Order::class, 'orders_drivers', 'driver_id');
    }

    // Add a routeNotificationForFcm method
    public function routeNotificationForFcm()
    {
        return $this->fcm_token; // Assuming you store the FCM tokens in the users table
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class,'users_jobs');
    }
}
