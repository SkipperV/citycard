<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class CardController extends Controller
{
    /**
     * Get all user's cards
     *
     * @OA\Get (
     *     path="/api/cards",
     *     tags={"Card"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(type="object",
     *                 @OA\Property(property="id", type="number", example="1"),
     *                 @OA\Property(property="user_id", type="number", example="1"),
     *                 @OA\Property(property="number", type="number", example="12345678909"),
     *                 @OA\Property(property="type", type="string", example="Спеціальний"),
     *                 @OA\Property(property="current_balance", type="number", example="104.5")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=204, description="No Content"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function index(): Collection|Response
    {
        $cards = auth()->user()->cards;
        return $cards->isNotEmpty() ? $cards : response([], 204);
    }

    /**
     * Get user's card by ID
     *
     * @OA\Get (
     *     path="/api/cards/{cardId}",
     *     tags={"Card"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter (
     *         required=true,
     *         name="cardId",
     *         in="path",
     *         description="ID of card to return",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="number", example="1"),
     *                  @OA\Property(property="user_id", type="number", example="1"),
     *                  @OA\Property(property="number", type="number", example="12345678909"),
     *                  @OA\Property(property="type", type="string", example="Спеціальний"),
     *                  @OA\Property(property="current_balance", type="number", example="104.5")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     */
    public function show(Card $card): Card
    {
        if (!auth()->user()->cards()->find($card->id)) {
            return abort(404);
        }
        return $card;
    }
}
