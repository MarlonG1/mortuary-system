<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'employeeId' => $this->employee_id,
            'username' => $this->lastname,
            'email' => $this->email,
            'password' => $this->password,
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
        ];
    }
}
