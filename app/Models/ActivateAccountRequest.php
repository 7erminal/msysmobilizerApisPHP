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
class ActivateAccountRequest extends Model
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
     *      title="mobileNumber",
     *      description="Mobile number",
     *      example="0557888100"
     * )
     *
     * @var string
     */
    public $mobileNumber;
}
