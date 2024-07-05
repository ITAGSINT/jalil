<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    protected $additionalData;

    public function __construct($resource, $additionalData = null)
    {
        parent::__construct($resource);
        $this->additionalData = $additionalData;
    }
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'manufacturer' => $this->model()->withoutGlobalScopes()->first()->manufacture->name,
            'model' => $this->model()->withoutGlobalScopes()->first()->name,

            'model_image' => ($this->id == 1) ? $this->additionalData->main_image : 
            ((count($this->model()->withoutGlobalScopes()->first()->colors->where('id', $this->color_id)) > 0)
                ?
                $this->model()->withoutGlobalScopes()->first()->colors->where('id', $this->color_id)->first()->pivot->image
                :
                $this->model()->withoutGlobalScopes()->first()->colors->first()->pivot->image),
            'hex_code' => $this->hex_code,
            'plate_num' => $this->plate_num,
            'type' => $this->type,
        ];
    }
}
