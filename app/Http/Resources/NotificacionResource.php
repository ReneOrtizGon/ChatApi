<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "hbkey" => $this->hbkey,
            "hbkey" => $this->whenPivotLoaded('notificaciones_usuario', function () {
                return $this->pivot->hbkey;
            }),
            "ownerId" => $this->owner_id,
            "titulo" => $this->titulo,
            "texto" => $this->texto,
            "categoria" => $this->categoria,
            "icono" => $this->icono,
            "tipo" => $this->tipo,
            "importante" => $this->importante,
            "extra" => getnotnull($this->extra,'S'),
            "fechaNotificacion" => $this->fecha_notificacion,
            "estatusGeneral" => $this->estatus,
            "estatus" => $this->whenPivotLoaded('notificaciones_usuario', function () {
                return $this->pivot->estatus;
            }),
            "leido" => $this->whenPivotLoaded('notificaciones_usuario', function () {
                return $this->pivot->leido;
            }),
            "createdAt" => $this->created_at
        ];
    }
}
