<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AccountResource;

class AccountResponseResource extends JsonResource
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
            'StatusCode' => $this->responseCode,
            'StatusDesc' => $this->responseMessage,
            'Result' => $this->resource ? new AccountResource($this->resource) : null,
            'Client' => $this->client,
        ];
    }
}
