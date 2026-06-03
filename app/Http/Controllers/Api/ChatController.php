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

use App\Http\Resources\ChatResource;
use App\Http\Resources\ChatListCollection;
use App\Http\Resources\MessageResource;

use OpenApi\Attributes as OA;

/**
 * @OA\Tag(
 *     name="Trhead",
 *     description="API Endpoints de Hilos"
 * )
 */
class ChatController extends Controller
{
    private ChatInterface $ChatRepository;
    private MessageInterface $MessageRepository;

    /**
     * Constructor.
     *
     * @param ChatInterface $ChatRepository
     * @param MessageInterface $MessageRepository
     */
    public function __construct(ChatInterface $ChatRepository, MessageInterface $MessageRepository)
    {
        $this->ChatRepository = $ChatRepository;
        $this->MessageRepository = $MessageRepository;
    }

    /**
     * @OA\Get(
     *      path="/trheads",
     *      tags={"getTrheads"},
     *      summary="Obtiene la lista de hilos pertenecientes al usuario",
     *      description="Regresa una lista de las conversaiones alas que pertenece el usuario",
     *      @OA\Response(
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/ChatListResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="No autenticado",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Prohibido"
     *      )
     * )
     */
    public function index()
    {
        $data = $this->ChatRepository->getAllByUser(auth()->user()->id);
        return response()->ok(new ChatListCollection($data));
    }


    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/trheads",
     *      tags={"postTrheads"},
     *      summary="Crea una conversaion con un mensaje inicial",
     *      description="Crea una nueva conversaion con un mensaj eincial creado por el usuario autenticado.",
     *      @OA\Response(
     *          response=201,
     *          description="Creado"
     *       ),
     *       @OA\Response(
     *          response=400,
     *          description="Error al procesar/Validar"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="No autenticado",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Prohibido"
     *      )
     * )
     */
    public function store(StoreChatRequest $request)
    {
        $chat = [
            'title' => ($request->is_group) ? $request->name : null,
            'is_group' => $request->is_group,
        ];

        $message = [
            'chat_id' => null,
            'owner_id' => auth()->user()->id,
            'title' => $request->title,
            'body' => $request->message,
            'status' => GeneralStatus::ACTIVE->value,
            'principal' => MessageType::PRINCIPAL->value,
            'recipients' => $request->recipients,
        ];
        //Se asigna al usuario autenticado como el owner del chat
        $chat_members = [
            [
                'chat_id' => null,
                'user_id' => auth()->user()->id,
                'is_owner' => true,
                'status' => GeneralStatus::ACTIVE->value,
            ],
        ];
        //Se agregan los demasmiembros del chat
        foreach ($request->recipients as $recipient) {
            if ($recipient != auth->user()->id) {
                $chat_members[] = [
                    'chat_id' => null,
                    'user_id' => $recipient,
                    'is_owner' => false,
                    'status' => GeneralStatus::ACTIVE->value,
                ];
            }
        }

        $chat['members'] = $chat_members;

        DB::beginTransaction();

        try {
            $chat = $this->ChatRepository->create($chat);
            $message['chat_id'] = $chat->id;
            $this->MessageRepository->create($message);
            DB::commit();
            return response()->created();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->badRequest($e, $e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *      path="/trheads/{id_trhead}/messages",
     *      tags={"postMessage"},
     *      summary="Crea una respuesta del chat indicadp",
     *      description="Crea una nueva respuesta en el hilo seleccionado",
     *      @OA\Parameter(name="id_thread", in="path", @OA\Schema(type="integer")),
     *      @OA\Response(
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/MessageResource")
     *       ),
     *       @OA\Response(
     *          response=400,
     *          description="Error al procesar/Validar"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="No autenticado",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Prohibido"
     *      )
     *)
     */
    public function responseMessage(Request $request, $chat_id)
    {
        DB::beginTransaction();

        try {
            $chat = $this->ChatRepository->read($chat_id);

            if ($chat === null) {
                return response()->notFound('Chat not found');
            }

            if ($chat->members()->where('user_id', auth()->user()->id)->doesntExist()) {
                return response()->forbidden('You are not a member of this chat');
            }

            $recipients = $chat->members()->where('user_id', '!=', auth()->user()->id)->pluck('user_id')->toArray();

            $message = [
                'chat_id' => $chat_id,
                'owner_id' => auth()->user()->id,
                'title' => null,
                'body' => $request->message,
                'status' => GeneralStatus::ACTIVE->value,
                'principal' => MessageType::RESPONSE->value,
                'recipients' => $recipients
            ];

            $message = $this->MessageRepository->create($message);
            DB::commit();
            return response()->ok(new MessageResource($message));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->badRequest($e, $e->getMessage());
        }
    }
    /**
     * @OA\Get(
     *      path="/trheads/{id_trhead}",
     *      tags={"readMessage"},
     *      summary="Devuelve una conversacion.",
     *      description="Devueve una conversacion con sus miembro y mensajes",
     *      @OA\Response(
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/ChatResource")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="No encontrado"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="No autenticado",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Prohibido"
     *      )
     * )
     */
    public function show(Request $request)
    {
        $chat = $this->ChatRepository->read($request->id)->load('message')->load('members');

        if ($chat === null) {
            return response()->notFound(' not found');
        }

        //return response()->ok($chat);
        return response()->ok(new ChatResource($chat));
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
