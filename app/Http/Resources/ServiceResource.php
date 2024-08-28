<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'categoryId' => $this->category_id,
            'available' => $this->available,
            'details' => new ServiceDetailResource($this->whenLoaded('details')),
            'categories' => CategoryResource::collection($this->whenLoaded('category')),
            'sale' => new SaleResource($this->whenLoaded('sale'))
        ];
    }
}
