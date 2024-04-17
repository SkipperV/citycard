<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\User;
use App\Rules\CardToUserConnectionValidationRule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request): Response
    {
        $fields = $request->validate([
            'login' => ['required', 'regex:/^\+380\d{9}$/', 'unique:users,login'],
            'card_number' => [new CardToUserConnectionValidationRule],
            'password' => ['required', 'confirmed', 'min:6']
        ]);
        $fields['password'] = bcrypt($fields['password']);

        $user = User::create($fields);
        if ($request->card_number) {
            Card::where('number', $request->card_number)->update(['user_id' => $user->id]);
        }
        $token = $user->createToken('usertoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request): Response
    {
        $fields = $request->validate([
            'login' => ['required'],
            'password' => ['required']
        ]);

        $user = User::where('login', $fields['login'])->first();
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Incorrect login credentials'], 401);
        }

        $token = $user->createToken('usertoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(): Response
    {
        auth()->user()->tokens()->delete();

        return response(['message' => 'Logged out']);
    }
}
