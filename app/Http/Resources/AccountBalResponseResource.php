<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AccountDetailsResource;

class AccountBalResponseResource extends JsonResource
{
    public function __construct($resource, $statusCode = 200, $statusDesc = 'Success', $client = "")
    {
        parent::__construct($resource);
        $this->statusCode = $statusCode;
        $this->statusDesc = $statusDesc;
        $this->client = $client;
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
            'Result' => $this->resource ? new AccountDetailsResource($this->resource) : null,
            'Client' => $this->client,
        ];
    }
}
