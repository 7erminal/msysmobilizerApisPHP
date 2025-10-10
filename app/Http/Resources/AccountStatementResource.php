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
            'Product' => $this->Product,
            'AccountNumber' => $this->AccountNumber,
            'AccountName' => $this->AccountName
        ] : null;
    }
}
