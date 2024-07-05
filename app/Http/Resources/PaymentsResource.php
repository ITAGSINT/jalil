<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'service' => $this->service_name,
            'method' => $this->method->name,
            'product' => $this->order->products->name,
            'amount' => $this->amount,
            'trans_date' => $this->trans_date,
            'status' => $this->status->name,
        ];
    }
}
