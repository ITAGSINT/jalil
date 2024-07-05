<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'id' => $this->id,
            'is_active' => $this->is_active,
            'cash' => $this->cash,
            'pending' => $this->pending,
            'done' => $this->done,
            'scheduled' => $this->scheduled,
            'scheduledOrders' => ScheduledOrderResource::collection($this->driverOrders),
            // 'scheduledOrders2' => $this->driverOrders,

        ];
    }
}
