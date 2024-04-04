<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CardTransactionController extends Controller
{
    public function index(Request $request, Card $card): View|RedirectResponse
    {
        if ($card->user_id == $request->user()->id) {
            if (!($request->query('type')) or $request->query('type') == 'outcome') {
                return view('cards.transactions.index', [
                    'card' => $card,
                    'transactions' => $card->cardTransactions->where('transaction_type', false),
                    'transactionsType' => false,
                ]);
            } else {
                return view('cards.transactions.index', [
                    'card' => $card,
                    'transactions' => $card->cardTransactions->where('transaction_type', true),
                    'transactionsType' => true,
                ]);
            }
        }

        return redirect()->route('user.profile.index');
    }
}
