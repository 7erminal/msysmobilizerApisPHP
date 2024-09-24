<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="Pin Validation Request",
 *      description="Pin Validation request",
 *      type="object",
 *      required={"number","password"}
 * )
 */
class PinValidationRequest extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *      title="number",
     *      description="User Number",
     *      example="0557881327"
     * )
     *
     * @var string
     */
    public $number;

    /**
     * @OA\Property(
     *      title="password",
     *      description="User Password or Pin",
     *      example="0000"
     * )
     *
     * @var string
     */
    public $password;
}
