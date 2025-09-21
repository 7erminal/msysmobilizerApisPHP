<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="Debit account Request",
 *      description="Debit account",
 *      type="object",
 *      required={"accountNumber","amount"}
 * )
 */
class DebitAccountRequest extends Model
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

    /**
     * @OA\Property(
     *      title="reference",
     *      description="Reference",
     *      example="Fees"
     * )
     *
     * @var string
     */
    public $reference;

    /**
     * @OA\Property(
     *      title="channel",
     *      description="Channel",
     *      example="USSD"
     * )
     *
     * @var string
     */
    public $channel;
}
