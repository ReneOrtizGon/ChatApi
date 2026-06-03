<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="ChatListResource",
 *     description="Lista de conversaciones del usuario ",
 *     @OA\Xml(
 *         name="ChatListResource"
 *     )
 * )
 */

class ChatListResource extends JsonResource
{
      /**
     * @OA\Property(
     *     title="id",
     *     description="id del chat",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */


    /**
     * @OA\Property(
     *     title="name",
     *     description="el nombre descriptivo de la conversacion, si e sgrupal proviene del modelo, si no lo se se creadinamico como 'Chat con...",
     *     format="string",
     *     example="Chat con Jhon Doe",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     title="is_group",
     *     description="Indica si un conversacion es grupal",
     *     format="int16",
     *     example="1",
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     title="status",
     *     description="Esattdo en que se encuentra la conversacion 1:Creado, 2:Contestado, 3:Eliminado",
     *     format="int16",
     *     example="1",
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     title="created_at",
     *     description="Fecha de creacion de la conversacion",
     *     format="Date",
     *     example=""2026-06-03T08:43:47.000000Z",
     * )
     *
     * @var Date
     */
    /**
     * @OA\Property(
     *     title="updated_at",
     *     description="Fecha de ultima modificacion  la conversacion",
     *     format="Date",
     *     example="2026-06-03T08:43:47.000000Z",
     * )
     *
     * @var Date
     */
    /**
     * @OA\Property(
     *     title="deleted_at",
     *     description="Fecha de eliminacion la conversacion, solo si esta eliminado de lo contraio regresa null",
     *     format="Date",
     *     example="2026-06-03T08:43:47.000000Z",
     * )
     *
     * @var Date
     */

    /**
     * @OA\Property(
     *     title="members",
     *     description="Array con losmiembros pertenecientes a la conversacion",
     *     format="array",
     *     example=' [
     *  {
     *   "id": 3,
     *   "user_id": 1,
     *   "is_owner": 1,
     *   "name": "Jane Doe",
     *   "email": "jane@chat.com"
     * },
     * {
     *   "id": 4,
     *   "user_id": 6,
     *   "is_owner": 0,
     *   "name": "Jhon Doe",
     *   "email": "jhon@chat.com"
     *  }
     *  ]',
     * )
     *
     * @var array
     */
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $members=[];
        $name = "";
        $aux =false;

        foreach($this->members as $member){
            $members[]=[
                "id" => $member->id,
                "user_id" => $member->user_id,
                "is_owner" => $member->is_owner,
                "name" => $member->user->name,
                "email" => $member->user->email,
            ];

            if($member->is_owner == 1 && $member->user_id != auth()->user()->id){
                $name = "Chat con {$member->user->name} ";
                $aux= true;
            }elseif(!$aux){
                    $name = "Chat con {$member->user->name}";
            }

        }

        $respuesta = [
			"id"         => $this->id,
    		"name"       => ($this->is_group) ? $this->name : $name,
			"is_group"   => $this->is_group,
			"status"     => $this->status,
			"created_ap" => $this->created_at,
			"updated_at" => $this->updated_at,
			"deleted_at" => $this->deleted_at,
            "members"    => $members
        ];


        return $respuesta;
    }
}
