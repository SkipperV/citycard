<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CardTransactionController extends Controller
{
    public function index(Request $request, Card $card): Response
    {
        return Inertia::render('TransactionsHistory/Index', [
            'cardId' => $card->id,
        ]);
    }
}
