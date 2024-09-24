<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="Id Request",
 *      description="Request that requires just an ID",
 *      type="object",
 *      required={"id"}
 * )
 */
class IdRequest extends Model
{
    use HasFactory;

    /**
     * @OA\Property(
     *      title="id",
     *      description="ID",
     *      example="5"
     * )
     *
     * @var string
     */
    public $id;
}
