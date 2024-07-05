<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduledOrderResource extends JsonResource
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
            'date' => $this->date,
            'time' => $this->time,
            'city' => $this->address->city,
            'car' => $this->car->model()->withoutGlobalScopes()->first()->manufacture->name,
            'service' => ($this->products->category_id == 2) ? 'Car Wash' :
             (($this->products->category_id == 3) ? 'Tyre Change' :
              'Battery Change'),
        ];
    }
}
