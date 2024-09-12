<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CardRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Rules\CardToUserConnectionValidationRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;
    private CardRepositoryInterface $cardRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        CardRepositoryInterface $cardRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->cardRepository = $cardRepository;
    }

    /**
     * Register
     *
     * @OA\Post (
     *     path="/api/register",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="login", type="string", pattern="^\+380\d{9}$"),
     *                      @OA\Property( property="password", type="string"),
     *                      @OA\Property( property="password_confirmation", type="string")
     *                 ),
     *                 example={
     *                     "login": "+380999999999",
     *                     "password": "johnjohn1",
     *                     "password_confirmation": "johnjohn1"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="login", type="string", example="+380999999999"),
     *                 @OA\Property(property="id", type="number", example="1")
     *             ),
     *             @OA\Property(property="token", type="string", example="1|randomtokenasfhajskfhajf398rureuuhfdshk")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The login field format is invalid."),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="login", type="array", collectionFormat="multi",
     *                     @OA\Items(type="string", example="The login field format is invalid.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $fields = $request->validate([
            'login' => ['required', 'regex:/^\+380\d{9}$/', 'unique:users,login'],
            'card_number' => [new CardToUserConnectionValidationRule],
            'password' => ['required', 'confirmed', 'min:6']
        ]);
        $fields['password'] = bcrypt($fields['password']);

        $user = $this->userRepository->createUser($fields);

        if ($request->card_number) {
            $this->cardRepository->connectCardToUser($user, $fields['card_number']);
        }

        $token = $user->createToken('usertoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * Log in
     *
     * @OA\Post (
     *     path="/api/login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(property="login", type="string", pattern="^\+380\d{9}$"),
     *                      @OA\Property( property="password", type="string")
     *                 ),
     *                 example={
     *                     "login": "+380999999999",
     *                     "password": "johnjohn1"
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="number", example="1"),
     *                 @OA\Property(property="login", type="string", example="+380999999999")
     *             ),
     *             @OA\Property(property="token", type="string", example="1|randomtokenasfhajskfhajf398rureuuhfdshk"),
     *             @OA\Property(property="role", type="string", example="user")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Incorrect login credentials")
     *         )
     *     )
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $fields = $request->validate([
            'login' => ['required'],
            'password' => ['required']
        ]);

        $user = $this->userRepository->getUserByLogin($fields['login']);
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json(['message' => 'Incorrect login credentials'], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('usertoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token,
            'role' => $user->is_admin ? 'admin' : 'user'
        ];

        return response()->json($response);
    }

    /**
     * Log out
     *
     * @OA\Post (
     *     path="/api/logout",
     *     tags={"Auth"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
