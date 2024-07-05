<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    use HasFactory;

    protected $primaryKey='coupans_id';
    protected $guarded = [ ];

    protected $casts=[
        'product_ids'=>'array',
        'email_restrictions'=>'array',
        'excluded_product_categories'=>'array',
        'exclude_product_ids'=>'array',

    ];


    public function type(){
    return $this->belongsTo(CouponType::class,'coupon_type');

    }

}
