<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Models\Credentials;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     operationId="login",
     *     tags={"auth"},
     *     summary="get access-token",
     *     description="JWT Token. Required for all requests.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *      type="object",
     *      @OA\Property(property="email", type="string", example="teste@teste.com"),
     *      @OA\Property(property="password", type="string", example="123456"),
     *   ),
     * ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="access-token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     *          @OA\Property(property="token_type", type="string", example="bearer"),
     *          @OA\Property(property="expires_in", type="int", example="3600"),
     *       ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Incorrect username or password",
     *     @OA\JsonContent(
     *        type="object",
     *         @OA\Property(property="error", type="string", example="Unauthorized"),
     *      ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error while fetching data in database"
     *     ),
     * ),
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $token = auth()->setTTL(60)->attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     operationId="logout",
     *     security={{"bearerAuth": {}}},
     *     tags={"auth"},
     *     summary="logout",
     *     description="Logout endpoint",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="message", type="string", example="Successfully logged out"),
     *       ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Incorrect token",
     *     @OA\JsonContent(
     *        type="object",
     *         @OA\Property(property="error", type="string", example="Unauthorized."),
     *      ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error while fetching data in database"
     *     ),
     * ),
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            // 'user' => auth()->user(),
        ]);
    }

    public function verify()
    {
        $user = auth()->user();
        if ($user) {
            return response()->json($user, 200);
        }
    }

    public function revokeToken()
    {
        $user = auth()->user();
        $token = auth()->tokenById($user->id);
        auth()->invalidate();

        return response()->json([
            'user' => $user->name,
            'token' => $token,
            'msg' => 'Token invalidated'
        ], 200);
    }

    public function getPayload()
    {
        $payload = auth()->payload();

        return response()->json($payload, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     operationId="register",
     *     tags={"auth"},
     *     summary="sign up",
     *     description="Creates a user record with valid credentials in the database.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *      type="object",
     *      @OA\Property(property="nickname", type="string", example="janedoe"),
     *      @OA\Property(property="first_name", type="string", example="jane"),
     *      @OA\Property(property="last_name", type="string", example="doe"),
     *      @OA\Property(property="email", type="string", example="janedoe@test.com"),
     *      @OA\Property(property="password", type="string", example="12345678"),
     *   ),
     * ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *         type="object",
     *          @OA\Property(property="nickname", type="string", example="janedoe"),
     *          @OA\Property(property="first_name", type="string", example="jane"),
     *          @OA\Property(property="last_name", type="string", example="doe"),
     *          @OA\Property(property="updated_at", type="string", example="2099-01-01T00:00:00.000000Z"),
     *          @OA\Property(property="created_at", type="string", example="2099-01-01T00:00:00.000000Z"),
     *          @OA\Property(property="id", type="int", example="1"),
     *       ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     @OA\JsonContent(
     *        type="object",
     *         @OA\Property(property="message", type="string", example="The nickname has already been taken"),
     *      ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error while fetching data in database"
     *     ),
     * ),
     */
    public function register(SignupRequest $r)
    {
        $user = User::create([
            'nickname' => $r->nickname,
            'first_name' => $r->first_name,
            'last_name' => $r->last_name,
        ]);

        Credentials::create([
            'email' => $r->email,
            'password' => Hash::make($r->password),
            'user_id' => $user->id
        ]);

        return $user;
    }
}
