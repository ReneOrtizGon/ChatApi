<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $members=[];
        $messages=[];
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

        $messages = new BasicMessageCollection($this->message);

        $respuesta = [
			"id"         => $this->id,
    		"name"       => ($this->is_group) ? $this->name : $name,
			"is_group"   => $this->is_group,
			"status"     => $this->status,
			"created_ap" => $this->created_at,
			"updated_at" => $this->updated_at,
			"deleted_at" => $this->deleted_at,
            "members"    => $members,
            "messages"   => $messages
        ];


        return $respuesta;
    }
}
