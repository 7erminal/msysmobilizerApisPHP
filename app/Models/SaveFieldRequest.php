<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *      title="Save field Request",
 *      description="Save field request",
 *      type="object",
 *      required={"accountNumber"}
 * )
 */
class SaveFieldRequest extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *      title="accountNumber",
     *      description="Account number",
     *      example="1000010001"
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
     *      title="mobileNumber",
     *      description="Mobile number",
     *      example="0557888100"
     * )
     *
     * @var string
     */
    public $mobileNumber;
}
