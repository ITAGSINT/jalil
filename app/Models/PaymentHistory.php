<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;
    protected $table = 'payment_history';

    public function name()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(PaymentStatus::class, 'status_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id', 'transaction_id');
    }
}
