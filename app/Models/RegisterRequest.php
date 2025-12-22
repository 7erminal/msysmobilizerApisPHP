<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="Register Request",
 *      description="Register request",
 *      type="object",
 *      required={"firstName","lastName","gender","mobileNumber"}
 * )
 */
class RegisterRequest extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *      title="firstName",
     *      description="User first name",
     *      example="John"
     * )
     *
     * @var string
     */
    public $firstName;

    /**
     * @OA\Property(
     *      title="lastName",
     *      description="User last name",
     *      example="Doe"
     * )
     *
     * @var string
     */
    public $lastName;

    /**
     * @OA\Property(
     *      title="gender",
     *      description="User's gender",
     *      example="m"
     * )
     *
     * @var string
     */
    public $gender;

    /**
     * @OA\Property(
     *      title="mobileNumber",
     *      description="User's mobile number",
     *      example="0557001000"
     * )
     *
     * @var string
     */
    public $mobileNumber;

    /**
     * @OA\Property(
     *      title="chargeAmount",
     *      description="Amount charged",
     *      example="1.0"
     * )
     *
     * @var string
     */
    public $chargeAmount;

    /**
     * @OA\Property(
     *      title="source",
     *      description="Source of the registration",
     *      example="WEB"
     * )
     *
     * @var string
     */
    public $source;

    /**
     * @OA\Property(
     *      title="txnRef",
     *      description="transaction Reference",
     *      example="TXN-220392"
     * )
     *
     * @var string
     */
    public $txnRef;
}
