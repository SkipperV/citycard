<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Repositories\TransactionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index(Request $request, Card $card): JsonResponse
    {
        return response()->json([
            'transactions' => $this->transactionRepository->getAllCardTransactions($request, $card)
        ]);
    }

    public function incomes(Request $request, Card $card): JsonResponse
    {
        return response()->json([
            'transactions' => $this->transactionRepository->getIncomeCardTransactions($request, $card)
        ]);
    }

    public function outcomes(Request $request, Card $card): JsonResponse
    {
        return response()->json([
            'transactions' => $this->transactionRepository->getOutcomeCardTransactions($request, $card)
        ]);
    }
}
