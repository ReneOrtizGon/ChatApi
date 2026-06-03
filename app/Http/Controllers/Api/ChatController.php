<?php

namespace App\Http\Controllers\Api;

use App\Enums\GeneralStatus;
use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatRequest;
use App\Interfaces\ChatInterface;
use App\Interfaces\MessageInterface;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    private ChatInterface $ChatRepository;
    private MessageInterface $MessageRepository;

    public function __construct(ChatInterface $ChatRepository, MessageInterface $MessageRepository)
    {
        $this->ChatRepository = $ChatRepository;
        $this->MessageRepository = $MessageRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $data = $this->ChatRepository->index();
       //return response()->ok(ChatResource::collection($data));
       return response()->ok();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request)
    {
        $chat = [
            'title' => ($request->is_group) ? $request->title : null,
            'is_group' => $request->is_group,
        ];

        $message =[
            'chat_id' => null,
            'owner_id' => auth()->user()->id,
            'title' => $request->title,
            'body' => $request->message,
            'status' => GeneralStatus::ACTIVE->value,
            'principal' => MessageType::PRINCIPAL->value,
            'recipients' => $request->recipients,
        ];

        $chat_members = [
            [
                'chat_id' => null,
                'user_id' => auth()->user()->id,
                'is_owner' => true,
                'status' => GeneralStatus::ACTIVE->value,
            ],
        ];

         foreach ($request->recipients as $recipient) {
                $chat_members[] = [
                'chat_id' => null,
                'user_id' => $recipient,
                'is_owner' => false,
                'status' => GeneralStatus::ACTIVE->value,
                ];

            }

            $chat['members'] = $chat_members;

        DB::beginTransaction();

        try {
            $chat = $this->ChatRepository->create($chat);
            $message['chat_id'] = $chat->id;
            $this->MessageRepository->create($message);
            DB::commit();
            return response()->ok($chat);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->badRequest($e,$e->getMessage());
        }
    }

    public function responseMessage(Request $request)
    {
         DB::beginTransaction();

        try {
            $chat = $this->ChatRepository->read($request->chat_id);
            if($chat === null){
                return response()->notFound('Chat not found');
            }
            $recipients = $chat->members()->where('user_id', '!=', auth()->user()->id)->pluck('user_id')->toArray();

            $message =[
                'chat_id' => $request->chat_id,
                'owner_id' => auth()->user()->id,
                'title' => null,
                'body' => $request->message,
                'status' => GeneralStatus::ACTIVE->value,
                'principal' => MessageType::RESPONSE->value,
                'recipients' => $recipients
            ];

           $message = $this->MessageRepository->create($message);
            DB::commit();
            return response()->ok($message);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->badRequest($e,$e->getMessage());
        }
        return response()->ok($request->all());
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $chat = $this->ChatRepository->read($request->id);

        if($chat === null){
            return response()->notFound(' not found');
        }

        return response()->ok($chat->load('message'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
