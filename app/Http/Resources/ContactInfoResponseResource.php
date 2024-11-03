<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
// use Illuminate\Support\Collection;

use App\Http\Resources\ContactInfoResource;

class ContactInfoResponseResource extends JsonResource
{
    public function __construct($resource, $statusCode = 200, $statusDesc = 'Success')
    {
        parent::__construct($resource);
        $this->statusCode = $statusCode;
        $this->statusDesc = $statusDesc;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'StatusCode' => $this->statusCode,
            'StatusDesc' => $this->statusDesc,
            'Result' => $this->resource ? new ContactInfoResource($this->resource) : null,
        ];
    }
}
