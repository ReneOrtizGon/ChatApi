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

class UserController extends Controller
{
    private UserInterface $UserRepository;

    public function __construct(UserInterface $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->UserRepository->index();

       return response()->ok(UserResource::collection($data));
    }

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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
