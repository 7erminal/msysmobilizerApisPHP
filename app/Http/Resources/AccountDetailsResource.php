<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->resource ? [
            'AvailableBalance' => $this->AvailBalance,
            'ClearBalance' => $this->ClearBalance,
            // 'Lien' => $this->Lien,
            // 'OverDraft' => $this->OverDraft,
            // 'HseChqBalance' => $this->HseChqBalance,
            'LoanBalance' => $this->LoanBalance,
            'AccountStatus' => $this->AccStatus,
            // 'SMSAlert' => $this->SMSAlert,
            // 'EmailAlert' => $this->EmailAlert,
            'SharesBalance' => $this->SharesBalance
        ] : null;
    }
}
