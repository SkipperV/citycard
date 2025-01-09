<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\TransactionRepositoryInterface;
use App\Models\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Get all card's top ups history (by cardId)
     *
     * @OA\Get (
     *     path="/api/cards/{cardId}/transactions/incomes",
     *     tags={"Card"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter (
     *         required=true,
     *         name="cardId",
     *         in="path",
     *         description="Card's ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter (
     *         name="dateFrom",
     *         in="query",
     *         description="Filter by date of transaction, from",
     *         @OA\Schema(type="date")
     *     ),
     *     @OA\Parameter (
     *         name="dateTo",
     *         in="query",
     *         description="Filter by date of transaction, to",
     *         @OA\Schema(type="date")
     *     ),
     *     @OA\Parameter (
     *         name="perPage",
     *         in="query",
     *         description="Number of items per page for pagination. By default all items return at once. If 'page' is present - default value is 20",
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter (
     *         name="page",
     *         in="query",
     *         description="Page number for pagination. By default all items return at once. If 'perPage' is present - default value is 1",
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="transactions", type="object",
     *                 @OA\Property(property="data", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="number", example="1"),
     *                         @OA\Property(property="card_id", type="number", example="1"),
     *                         @OA\Property(property="transaction_type", type="string", example="income"),
     *                         @OA\Property(property="balance_change", type="number", example="100"),
     *                         @OA\Property(property="created_at", type="date", example="28-04-2024 18:07:31"),
     *                         @OA\Property(property="updated_at", type="date", example="2024-04-28T18:07:31.000000Z")
     *                     )
     *                 ),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost:8080/api/cards/1/transactions/incomes?page=1"),
     *                 @OA\Property(property="from", type="number", example="1"),
     *                 @OA\Property(property="last_page", type="number", example="1"),
     *                 @OA\Property(property="last_page_url", type="string", example="http://localhost:8080/api/cards/1/transactions/incomes?page=1"),
     *                 @OA\Property(property="next_page_url", type="string", example="null"),
     *                 @OA\Property(property="path", type="string", example="http://localhost:8080/api/cards/1/transactions/incomes"),
     *                 @OA\Property(property="per_page", type="number", example="20"),
     *                 @OA\Property(property="prev_page_url", type="string", example="null"),
     *                 @OA\Property(property="to", type="number", example="1"),
     *                 @OA\Property(property="total", type="number", example="1"),
     *                 @OA\Property(property="links", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="url", type="string", example="null"),
     *                         @OA\Property(property="label", type="string", example="&laquo; Previous"),
     *                         @OA\Property(property="active", type="string", example="false"),
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=204, description="No Content"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     */
    public function incomes(Request $request, Card $card): JsonResponse
    {
        return response()->json([
            'transactions' => $this->transactionRepository->getIncomeCardTransactions($request, $card)
        ]);
    }

    /**
     * Get all card's usages history (by cardId)
     *
     * @OA\Get (
     *     path="/api/cards/{cardId}/transactions/outcomes",
     *     tags={"Card"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter (
     *         required=true,
     *         name="cardId",
     *         in="path",
     *         description="Card's ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter (
     *         name="dateFrom",
     *         in="query",
     *         description="Filter by date of transaction, from",
     *         @OA\Schema(type="date")
     *     ),
     *     @OA\Parameter (
     *         name="dateTo",
     *         in="query",
     *         description="Filter by date of transaction, to",
     *         @OA\Schema(type="date")
     *     ),
     *     @OA\Parameter (
     *         name="perPage",
     *         in="query",
     *         description="Number of items per page for pagination. By default all items return at once. If 'page' is present - default value is 20",
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter (
     *         name="page",
     *         in="query",
     *         description="Page number for pagination. By default all items return at once. If 'perPage' is present - default value is 1",
     *         @OA\Schema(type="number")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="transactions", type="object",
     *                 @OA\Property(property="data", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="number", example="1"),
     *                         @OA\Property(property="card_id", type="number", example="1"),
     *                         @OA\Property(property="transaction_type", type="string", example="outcome"),
     *                         @OA\Property(property="balance_change", type="number", example="14"),
     *                         @OA\Property(property="created_at", type="date", example="28-04-2024 18:07:31"),
     *                         @OA\Property(property="updated_at", type="date", example="2024-04-28T18:07:31.000000Z")
     *                     )
     *                 ),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost:8080/api/cards/1/transactions/outcomes?page=1"),
     *                 @OA\Property(property="from", type="number", example="1"),
     *                 @OA\Property(property="last_page", type="number", example="1"),
     *                 @OA\Property(property="last_page_url", type="string", example="http://localhost:8080/api/cards/1/transactions/outcomes?page=1"),
     *                 @OA\Property(property="next_page_url", type="string", example="null"),
     *                 @OA\Property(property="path", type="string", example="http://localhost:8080/api/cards/1/transactions/outcomes"),
     *                 @OA\Property(property="per_page", type="number", example="20"),
     *                 @OA\Property(property="prev_page_url", type="string", example="null"),
     *                 @OA\Property(property="to", type="number", example="1"),
     *                 @OA\Property(property="total", type="number", example="1"),
     *                 @OA\Property(property="links", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="url", type="string", example="null"),
     *                         @OA\Property(property="label", type="string", example="&laquo; Previous"),
     *                         @OA\Property(property="active", type="string", example="false")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response=204, description="No Content"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Resource not found")
     * )
     */
    public function outcomes(Request $request, Card $card): JsonResponse
    {
        return response()->json([
            'transactions' => $this->transactionRepository->getOutcomeCardTransactions($request, $card)
        ]);
    }
}
