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
     *      title="altMobileNumber",
     *      description="User's alternative mobile number",
     *      example="0557001006"
     * )
     *
     * @var string
     */
    public $altMobileNumber;

    /**
     * @OA\Property(
     *      title="type",
     *      description="Registration type",
     *      example="CUSTOMER / FIELD"
     * )
     *
     * @var string
     */
    public $type;
}
