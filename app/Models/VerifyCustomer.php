<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="Verify Customer Request",
 *      description="Verify customer request",
 *      type="object",
 *      required={"username","firstName","lastName","gender","dob","mobileNumber"}
 * )
 */
class VerifyCustomerRequest extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *      title="username",
     *      description="Username",
     *      example="henok"
     * )
     *
     * @var string
     */
    public $username;

    /**
     * @OA\Property(
     *      title="firstName",
     *      description="First name",
     *      example="Henok"
     * )
     *
     * @var string
     */
    public $firstName;

    /**
     * @OA\Property(
     *      title="lastName",
     *      description="Last name",
     *      example="Abebe"
     * )
     *
     * @var string
     */
    public $lastName;

    /**
     * @OA\Property(
     *      title="email",
     *      description="Email",
     *      example="
     * )
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="gender",
     *     description="Gender",
     *      example="M"
     * )
     * @var string
     */
    public $gender;

    /**
     * @OA\Property(
     *      title="dob",
     *      description="Date of birth",
     *      example="1990-01-01"
     * )
     * @var string
     */
    public $dob;

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
