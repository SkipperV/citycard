<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CardTransactionController extends Controller
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index(Request $request, Card $card): Response
    {
        $request['page'] = $request->query('page', 1);
        if (!($request->query('type')) || $request->query('type') == 'outcome') {
            return Inertia::render('TransactionsHistory/Index', [
                'card' => $card,
                'transactions' => $this->transactionRepository->getOutcomeCardTransactions($request, $card),
                'transactionsType' => false,
            ]);
        } else {
            return Inertia::render('TransactionsHistory/Index', [
                'card' => $card,
                'transactions' => $this->transactionRepository->getIncomeCardTransactions($request, $card),
                'transactionsType' => true,
            ]);
        }
    }
}
