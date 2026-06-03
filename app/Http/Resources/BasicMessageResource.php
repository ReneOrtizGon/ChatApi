<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="BasicMessageResource",
 *     description="Mensaje perteneciente a una conversacion, informacion minima ",
 *     @OA\Xml(
 *         name="BasicMessageResource"
 *     )
 * )
 */

class BasicMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
      /**
     * @OA\Property(
     *     title="id",
     *     description="id del mensaje",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

      /**
     * @OA\Property(
     *     title="owner_id",
     *     description="id del creador del mensaje",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */


    /**
     * @OA\Property(
     *     title="title",
     *     description="Titulo de la conversacion, si es una respuesta va vacio",
     *     format="string",
     *     example="",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     title="body",
     *     description="Cupero del mensaje",
     *     format="string",
     *     example="",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     title="principal",
     *     description="Si es el mensaje principal o inicial",
     *     format="int16",
     *     example="1",
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     title="status",
     *     description="Estado en que se encuentra el mensaje 1:Creado, 2:Contestado, 3:Eliminado",
     *     format="int16",
     *     example="1",
     * )
     *
     * @var integer
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
    /**
     * @OA\Property(
     *     title="updated_at",
     *     description="Fecha de ultima modificacion  del chat",
     *     format="Date",
     *     example="2026-06-03T08:43:47.000000Z",
     * )
     *
     * @var Date
     */
    /**
     * @OA\Property(
     *     title="deleted_at",
     *     description="Fecha de eliminacion del chat, solo si esta eliminado de lo cotraio regresa null",
     *     format="Date",
     *     example="2026-06-03T08:43:47.000000Z",
     * )
     *
     * @var Date
     */

    public function toArray(Request $request): array
    {
        $message = [
			"id"       => $this->id,
    		"owner_id" => $this->owner_id,
			"title"    => ($this->title == null)?'':$this->title,
			"body"     => $this->body,
			"status"    => $this->status,
			"principal"  => $this->principal,
			"updated_at" => $this->updated_at,
			"created_at" => $this->created_at,
            ];


        return $message;
    }
}
