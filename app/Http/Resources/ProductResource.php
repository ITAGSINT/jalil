<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class ProductResource extends JsonResource
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
            'products_quantity' => $this->products_quantity,
            'products_price' => $this->products_price,
            // 'original_price' => $this->original_price,
            'discount_price' => ($this->discount_price==0)? null : $this->discount_price,
            'categories_name' => CategoryResource::collection($this->category),
            'description' => $this->description,
            // 'attributes' => $this->attributes,
            'main_image' =>$this->mainImage,

        ];
        //return parent::toArray($request);
    }
}
