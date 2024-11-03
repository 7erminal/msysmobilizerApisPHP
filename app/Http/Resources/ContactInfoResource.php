<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->resource ? [
            'CorporateName' => $this->CorporateName,
            'Telephone' => $this->Telephone,
            'EmailAddress' => $this->EmailAddress,
            'WebAddress' => $this->WebAddress
        ] : null;
    }
}
