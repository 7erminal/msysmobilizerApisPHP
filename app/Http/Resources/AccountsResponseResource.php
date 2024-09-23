<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\AccountResource;

class AccountsResponseResource extends JsonResource
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
            'statusCode' => $this->statusCode,
            'statusDesc' => $this->statusDesc,
            'result' => $this->resource ? $this->resource->map(function ($item) {
                return new AccountResource($item);
            }) : null,
        ];
    }
}
