<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class OrderUserResource2 extends JsonResource
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
            'car' =>
            // $this->car,
            new CarResource($this->car,$this->products),
            'product' => $this->products->only(['id','name','main_image']),
            'driver' => ($this->driverName) ? $this->driverName->only(['id','name','phone','address']) : null,
            'customers_address' => $this->address,
            'order_price' => $this->order_price,
            'discount_price' => $this->discount_price,
            'order_status' => $this->currents->status_id,
            'date'=> $this->date,
            'time'=>$this->time,
            'payment_method'=>$this->payment_method,
            'order_price'=>$this->order_price,
            'discount_price'=>$this->discount_price,
            'transaction_id'=>$this->transaction_id,
            'paymethod'=>$this->method->name
        ];
        //return parent::toArray($request);
    }
}
