<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RespuestaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $respuesta = [
			"id"           => $this->id,
    		"pregunta_id"  => $this->pregunta_id,
			"respuesta"    => $this->respuesta,
			"descripcion"  => $this->descripcion,
			"orden"        => $this->orden,
			"abierta"      => $this->abierta,
			"estatus"      => $this->estatus,
        ];


        return $respuesta;
    }
}
