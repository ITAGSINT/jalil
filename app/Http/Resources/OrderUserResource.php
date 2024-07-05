<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class OrderUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $date=new DateTime( $this->date.' '. $this->time);
        return [
            'order_id' => $this->id,
            'car' =>
            // $this->car,
            new CarResource($this->car, $this->products),
            'product' => $this->products->only(['id', 'name']),
            'service' => ($this->products->category->id != 2 && $this->products->category->id != 3) ? 'Battery Change' : $this->products->category->name,
            'driver' => ($this->driverName) ? $this->driverName->only(['id', 'name', 'phone', 'address']) : null,
            // 'driver_location' => $this->driver_location,
            // 'customers_id' => $this->customers_id,
            // 'customers_name' => $this->customers_name,
            'customers_address' => $this->address,
            // 'customers_phone' => $this->customers_phone,
            'date' =>$this->date.' '. $this->time,
            //  $this->date,
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
