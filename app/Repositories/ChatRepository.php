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
