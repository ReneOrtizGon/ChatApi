<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="API Endpoints de authenticacion"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\POST(
     *      path="/api/login",
     *      tags={"login"},
     *      summary="Loguea alusuario al sistema.",
     *      @OA\Response(
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
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
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $token = Auth::guard('api')->attempt($credentials);

        if (!$token) {
            return response()->badRequest('Validation Failure',['Invalid credentials']);
        }

        return response()->json([
            'user' => Auth::guard('api')->user(),
            'authorisation' => $token,
            'type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * @OA\GET(
     *      path="/api/logout",
     *      tags={"logout"},
     *      summary="Cierra la sesion e invalida un token del usuario .",
     *      @OA\Response(
     *          response=204,
     *          descrption="no content"
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
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
    /**
     * @OA\GET(
     *      path="/api/refresr",
     *      tags={"refreshToken"},
     *      summary="Revaida un toekn activo.",
     *      @OA\Response(
     *          response=200,
     *          descrption="Token"
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
    public function refresh()
    {
        return response()->json([
            'authorization' => Auth::guard('api')->refresh(),
            'type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}
