<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Repositories\TransactionRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CardTransactionController extends Controller
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index(Request $request, Card $card): View|RedirectResponse
    {
        $request['page'] = $request->query('page', 1);
        if ($card->user_id == $request->user()->id) {
            if (!($request->query('type')) || $request->query('type') == 'outcome') {
                return view('cards.transactions.index', [
                    'card' => $card,
                    'transactions' => $this->transactionRepository->getOutcomeCardTransactions($request, $card),
                    'transactionsType' => false,
                ]);
            } else {
                return view('cards.transactions.index', [
                    'card' => $card,
                    'transactions' => $this->transactionRepository->getIncomeCardTransactions($request, $card),
                    'transactionsType' => true,
                ]);
            }
        }

        return redirect()->route('user.profile.index');
    }
}
