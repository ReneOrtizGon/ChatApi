<?php

namespace App\Repositories;

use App\Models\Message;
use App\Models\Recipient;
use App\Interfaces\MessageInterface;

class MessageRepository implements MessageInterface
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
        return Message::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(array $data)
    {
        $message = Message::create($data);
        foreach ($data['recipients'] as $recipient) {
            Recipient::create([
                'chat_id' => $data['chat_id'],
                'message_id' => $message->id,
                'user_id' => $recipient,
                'is_seen' => false,
            ]);
        }
        return $message;
    }

    /**
     * Display the specified resource.
     */
    public function read($id)
    {
        return Message::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $data, $id)
    {
        $message = Message::find($id);
        if ($message) {
            $message->update($data);
            return $message;
        }
        return null;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        return Message::find($id)->delete();
    }
}
