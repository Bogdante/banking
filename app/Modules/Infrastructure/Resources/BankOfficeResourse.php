<?php

namespace App\Modules\Infrastructure\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankOfficeResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'status' =>  $this->status,
            'can_top_up' => $this->can_top_up,
            'can_withdraw' => $this->can_withdraw,
            'can_credit' => $this->can_credit,
            'amount' => $this->amount
        ];
    }
}
