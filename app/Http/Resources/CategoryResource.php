<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class CategoryResource extends JsonResource
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
            'cat_id' => $this->id,
            // 'cat_image'=>URL::asset($this->image->path()),
            'name' => $this->name,
            'products' => ProductResource2::collection($this->products),
            'price' => $this->products->max('products_price'),

        ];
    }
}
