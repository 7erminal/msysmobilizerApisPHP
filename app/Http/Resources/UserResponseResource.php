<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

use App\Http\Resources\AccountNumberResource;
use App\Http\Resources\AccountIdResource;

class UserResponseResource extends JsonResource
{
    public function __construct($resource, $statusCode = 200, $statusDesc = 'Success', $type = 'CUSTOMER', $client = "")
    {
        parent::__construct($resource);
        $this->statusCode = $statusCode;
        $this->statusDesc = $statusDesc;
        $this->type = $type;
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
            'Result' => $this->resource ? $this->type == "CUSTOMER" ? new AccountNumberResource($this->resource) : new AccountIdResource($this->resource) : null,
            'Client' => $this->client,
        ];
    }
}
