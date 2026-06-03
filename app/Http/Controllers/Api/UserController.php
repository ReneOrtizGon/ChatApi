<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
/**
 * @OA\Tag(
 *     name="Users",
 *     description="API Endpoints de usuarios"
 * )
 */
class UserController extends Controller
{
    private UserInterface $UserRepository;

    public function __construct(UserInterface $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }
/**
     * @OA\Get(
     *      path="/user/all",
     *      tags={"getUser"},
     *      summary="Obtiene la lista de usuarios pertenecientes al sistema",
     *      @OA\Response(
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
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
        $data = $this->UserRepository->index();

       return response()->ok(UserResource::collection($data));
    }
    /**
     * @OA\Get(
     *      path="/api/user",
     *      tags={"getUser"},
     *      summary="Obtiene la informacion del usuario autenticado",
     *      @OA\Response(
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
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
    public function GetUser(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        return response()->ok(new UserResource($user));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

/**
     * @OA\Pot(
     *      path="/user",
     *      tags={"postUser"},
     *      summary="Registra un usurio en el sistema",
     *      @OA\Response(
     *          response=201,
     *          description="created",
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
    public function store(StoreUserRequest $request)
    {

        $details = [
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
        ];

        DB::beginTransaction();

        try {
            $user = $this->UserRepository->create($details);
            DB::commit();
            return response()->created();
        } catch (\Exception $e) {
            return response()->badRequest($e,$e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *      path="/user/{id}",
     *      tags={"getUserByID"},
     *      summary="Obtiene un usuario registrado en elsistema",
     *      @OA\Response(
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
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
    public function show(Request $request)
    {

        $user = $this->UserRepository->read($request->id);

        if($user === null){
            return response()->notFound('User not found');
        }

        return response()->ok(new UserResource($user));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $User)
    {
        //
    }

    /**
     * @OA\PUT(
     *      path="/user/{id}",
     *      tags={"editUser"},
     *      summary="Actualiza la informacion de un usuarios",
     *      @OA\Response(
     *          response=204,
     *          description="No content",
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
    public function update(UpdateUserRequest $request, $id)
    {
        $updateDetails = $request->only([
            'name', 'email'
        ]);
        DB::beginTransaction();
        try {
            $this->UserRepository->update($updateDetails, $id);
            DB::commit();
            return response()->NoContent();
        } catch (\Exception $e) {
            return response()->badRequest($e,$e->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *      path="/user/{id}",
     *      tags={"deleteUser"},
     *      summary="Eliminar un usuario del sistema",
     *      @OA\Response(
     *          response=204,
     *          description="no content",
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
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->UserRepository->delete($request->id);
            DB::commit();
            return response()->NoContent();
        } catch (\Exception $e) {
            return response()->badRequest($e,$e->getMessage());
        }
    }
}
