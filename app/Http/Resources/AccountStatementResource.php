<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountStatementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->resource ? [
            'TransactionDate' => $this->TransDate,
            'TransactionDescription' => $this->TransDesc,
            'Debit' => $this->Debit,
            'Credit' => $this->Credit
        ] : null;
    }
}
