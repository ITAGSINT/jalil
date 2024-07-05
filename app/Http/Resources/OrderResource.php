<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'order_id' => $this->id,
            'car' => new CarResource($this->car,$this->products),
            'product' => $this->products,
            // 'driver_name' => ($this->driverName) ? $this->driverName->name : 'no driver assigned',
            // 'driver_location' => $this->driver_location,
            // 'customers_id' => $this->customers_id,
            // 'customers_name' => $this->customers_name,
            'customers_address' => $this->address,
            // 'customers_phone' => $this->customers_phone,
            // 'date' => $this->date,
            // 'time' => $this->time,
            // 'payment_method' => $this->payment_method,
            'order_price' => $this->order_price,
            'discount_price' => $this->discount_price,
            // 'coupon_code' => $this->coupon_code,
            // 'coupon_amount' => $this->coupon_amount,
            'order_status' => $this->currents->status_id,
            // 'customer_comment' => $this->customer_comment,



            // 'quantity' => $this->orders_products_count

            //   'total_after_discount' => $this->total_after_discount,


        ];
        //return parent::toArray($request);
    }
}
