<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Models\ChatMember;
use App\Interfaces\ChatInterface;

class ChatRepository implements ChatInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Chat::all();
    }
    /**
     * Regresa los chats del usuario logeado
     * incluye los miembros del chat
     * @param int $userId
     * @return collection<chats>
     */
    public function getAllByUser($userId)
    {
        /* Se obtiene los chats donde el usuario es miembro*/
        $data = Chat::whereHas('members', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->paginate(10);

        /* a cada chat se le gregan sus miembros correspondientes*/
        $data->load(['members.user' => function ($query) {
            $query->select('id','name', 'email');
        }]);

        return $data;
    }

































    /**
     * Store a newly created resource in storage.
     */
    public function create(array $data)
    {
        $chat = Chat::create($data);
        $this->addMembers($chat->id, $data['members']);
        return $chat;
    }

    /**
     * Display the specified resource.
     */
    public function read($id)
    {
        return Chat::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $data, $id)
    {
        $chat = Chat::find($id);
        if ($chat) {
            $chat->update($data);
            return $chat;
        }
        return null;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        return Chat::find($id)->delete();
    }

    public function addMembers($chatId, $members)
    {
        $chat = Chat::find($chatId);
        if (!$chat) {
            return null; // Chat not found
        }

        foreach ($members as $member) {
            ChatMember::create([
                'chat_id' => $chatId,
                'user_id' => $member['user_id'],
                'is_owner' => $member['is_owner'],
                'status' => $member['status'],
            ]);
        }

        return true; // Members added successfully
    }
}
