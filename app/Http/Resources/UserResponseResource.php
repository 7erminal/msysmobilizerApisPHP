<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\AccountRegResource;

class UserResponseResource extends JsonResource
{
    public function __construct($result="SUCCESS", $statusCode = 200, $statusDesc = 'Success')
    {
        $this->result = $result;
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
            'result' => $this->result
        ];
    }
}
