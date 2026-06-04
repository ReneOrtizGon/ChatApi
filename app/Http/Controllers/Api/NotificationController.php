<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use App\Http\Controllers\Controller;


class NotificationController extends Controller
{
    /**
     * @OA\Get(
     *      path="/notification",
     *      tags={"getNotification"},
     *      summary="Obtiene la lista de notificaciones pertenecientes al usuario",
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
        $data = DatabaseNotification::where('notifiable_id', auth()->user()->id)->latest()->paginate();
        return response()->ok($data);
    }


    /**
     * @OA\Get(
     *      path="/notification/{id_trhead}",
     *      tags={"readNotificacion"},
     *      summary="Devuelve una conversacion.",
     *      description="Devueve una notificacion",
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
    public function show(Request $request, $id)
    {
        $notification = DatabaseNotification::find($id);

        if ($notification === null) {
            return response()->notFound(' not found');
        }
        return response()->ok($notification);
    }
    /**
     * @OA\Put(
     *      path="/notification/{id_trhead}",
     *      tags={"readMessage"},
     *      summary="Marcala notificacion como leida",
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
    public function markAsRead(Request $request, $id)
    {
        $notification = DatabaseNotification::find($id);

        if ($notification === null) {
            return response()->notFound(' not found');
        }
        $notification->markAsRead();

        return response()->noContent();
    }


    public function destroy(Request $request, $id)
    {
        $notification = DatabaseNotification::find($id);

        if ($notification === null) {
            return response()->notFound(' not found');
        }
        $notification->destroy($id);

        return response()->noContent();
    }
}
