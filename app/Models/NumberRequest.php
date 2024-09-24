<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="Number Request",
 *      description="Request that requires just a number",
 *      type="object",
 *      required={"number"}
 * )
 */
class NumberRequest extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *      title="number",
     *      description="Number",
     *      example="0557001000"
     * )
     *
     * @var string
     */
    public $number;
}
