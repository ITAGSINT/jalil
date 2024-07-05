<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class ProductResource2 extends JsonResource
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
            'product_id' => $this->id,
            'product_name' => $this->name,
            // 'products_quantity' => $this->products_quantity,
            'products_price' => $this->products_price,
            // 'original_price' => $this->original_price,
            'discount_price' => ($this->discount_price == 0) ? null : $this->discount_price,
            // 'categories_name' => CategoryResource::collection($this->category),

            // 'attributes' => $this->attributes,
            // 'main_image' => URL::asset($this->mainImage->path()),
            // 'images' => ImagesResource::collection($this->images),
            // 'weight' => $this->products_weight,
            // 'weight_unit' => $this->products_weight_unit,

        ];
        //return parent::toArray($request);
    }
}
