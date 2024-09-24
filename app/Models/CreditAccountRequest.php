<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="Credit account Request",
 *      description="Credit account",
 *      type="object",
 *      required={"accountNumber","amount"}
 * )
 */
class CreditAccountRequest extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *      title="accountNumber",
     *      description="Account number",
     *      example="10000001001"
     * )
     *
     * @var string
     */
    public $accountNumber;

    /**
     * @OA\Property(
     *      title="amount",
     *      description="Amount",
     *      example="20"
     * )
     *
     * @var string
     */
    public $amount;
}
