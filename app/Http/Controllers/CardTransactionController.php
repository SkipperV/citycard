<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Repositories\TransactionRepository;
use Illuminate\Http\RedirectResponse;
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

    public function index(Request $request, Card $card): Response|RedirectResponse
    {
        $request['page'] = $request->query('page', 1);
        if ($card->user_id == $request->user()->id) {
            if (!($request->query('type')) || $request->query('type') == 'outcome') {
                return Inertia::render('TransactionsHistory/Index', [
                    'card' => $card,
                    'transactions' => $this->transactionRepository->getAllOutcomeCardTransactionsList($card),
                    'transactionsType' => false,
                ]);
            } else {
                return Inertia::render('TransactionsHistory/Index', [
                    'card' => $card,
                    'transactions' => $this->transactionRepository->getAllIncomeCardTransactionsList($card),
                    'transactionsType' => true,
                ]);
            }
        }

        return to_route('user.home.index');
    }
}
