<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="Account number Request",
 *      description="Request that requires an account number",
 *      type="object",
 *      required={"accountNumber"}
 * )
 */
class AccountRequest extends Model
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
}
