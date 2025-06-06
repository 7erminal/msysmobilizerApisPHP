<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ValidationResponseResource extends JsonResource
{
    public function __construct($result, $statusCode = 200, $statusDesc = 'Success', $client = "")
    {
        $this->result = $result;
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
            'Result' => $this->result,
            'Client' => $this->client,
        ];
    }
}
