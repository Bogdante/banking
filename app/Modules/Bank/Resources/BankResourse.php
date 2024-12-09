<?php

namespace App\Modules\Bank\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankResourse extends JsonResource
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
            'number_offices' => $this->num_offices,
            'number_atms' => $this->num_atms,
            'number_employees' => $this->num_employees,
            'number_clients' => $this->num_clients,
            'rating' => $this->rating,
            'amount' => $this->amount,
            'percentage_rate' => $this->percentage_rate
        ];
    }
}
