<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="Create Field Account Request",
 *      description="Create Field Account request",
 *      type="object",
 *      required={"firstName","lastName","gender","mobileNumber", "fieldAgentMobileNumber"}
 * )
 */
class CreateFieldAccountRequest extends Model
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
     *      description="Customer's mobile number",
     *      example="0557001000"
     * )
     *
     * @var string
     */
    public $mobileNumber;

    /**
     * @OA\Property(
     *      title="fieldAgentMobileNumber",
     *      description="Field Officer's mobile number",
     *      example="0557001006"
     * )
     *
     * @var string
     */
    public $agentMobileNumber;
}
