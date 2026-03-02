<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->resource ? [
            'LoanDate' => $this->LoanDate,
            'LoanDescription' => $this->LoanDesc,
            'LoanAmount' => $this->LoanAmount,
        ] : null;
    }
}
