<?php

namespace App\Http\Controllers;

use App\Models\CardTransaction;
use Illuminate\Http\Request;

class CardTransactionController extends Controller
{
    public function index(Request $request, $card_id)
    {
        if (!($request->type) or $request->type == "outcome")
            return view('cards.transactions.index', [
                'transactions' => CardTransaction::where('card_id', $card_id)
                    ->where('transaction_type', false)->get(),
                'transaction_type' => false,
            ]);
        else
            return view('cards.transactions.index', [
                'transactions' => CardTransaction::where('card_id', $card_id)
                    ->where('transaction_type', true)->get(),
                'transaction_type' => true,
            ]);
    }
}
