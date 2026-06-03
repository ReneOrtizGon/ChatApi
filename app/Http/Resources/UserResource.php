<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="UserResource",
 *     description="Un usuario del sistema",
 *     @OA\Xml(
 *         name="UserResource"
 *     )
 * )
 */class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

        /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
      /**
     * @OA\Property(
     *     title="id",
     *     description="id del usuario",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     title="name",
     *     description="Nombre del usuario",
     *     format="string",
     *     example="",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     title="email",
     *     description="Email del usuario",
     *     format="string",
     *     example="",
     * )
     *
     * @var string
     */


    /**
     * @OA\Property(
     *     title="created_at",
     *     description="Fecha de creacion del chat",
     *     format="Date",
     *     example=""2026-06-03T08:43:47.000000Z",
     * )
     *
     * @var Date
     */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at
        ];
    }
}
