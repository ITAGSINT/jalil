<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'message', 'image', 'sent_at', 'read_at'];

    protected $dates = ['sent_at', 'read_at'];

    public function image(): Attribute
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

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
