<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'name' => $this->name,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'birthDate' => $this->birth_date,
            'dui' => $this->dui,
            'office' => new OfficeResource($this->whenLoaded('office')),
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
