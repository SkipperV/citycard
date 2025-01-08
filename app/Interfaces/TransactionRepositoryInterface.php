<?php

namespace App\Interfaces;

use App\Models\Card;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

interface TransactionRepositoryInterface
{
    public function formatCardTransactionsList(Request $request, HasMany $transactions);

    public function getIncomeCardTransactions(Request $request, Card $card);

    public function getOutcomeCardTransactions(Request $request, Card $card);
}
