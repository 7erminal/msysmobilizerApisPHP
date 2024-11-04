<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="Change Pin Request",
 *      description="Request needed to change pin",
 *      type="object",
 *      required={"number","pin"}
 * )
 */
class ChangePinRequest extends Model
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
     *      title="old password",
     *      description="User Password or Pin",
     *      example="0000"
     * )
     *
     * @var string
     */
    public $oldPassword;

    /**
     * @OA\Property(
     *      title="new password",
     *      description="User Password or Pin",
     *      example="0000"
     * )
     *
     * @var string
     */
    public $newPassword;
}
