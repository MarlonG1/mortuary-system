<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'customerId' => $this->customer_id,
            'officeId' => $this->office_id,
            'serviceId' => $this->service_id,
            'total' => $this->total,
            'saleDate' => $this->saleDate,
            'executionDate' => $this->executionDate,
            'services' => ServiceResource::collection($this->whenLoaded('service')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'office' => new OfficeResource($this->whenLoaded('office'))
        ];
    }
}
