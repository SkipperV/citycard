<?php

namespace App\Repositories;

use App\Models\Card;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class TransactionRepository
{
    public function formatCardTransactionsList(Request $request, HasMany $transactions): Collection|Paginator
    {
        if ($request->query('from', null)) {
            $transactions = $transactions->where('created_at', '>', $request->query('from', null));
        }
        if ($request->query('to', null)) {
            $transactions = $transactions->where('created_at', '<', $request->query('to', null));
        }
        if ($request->query('perPage') || $request->query('page')) {
            $perPage = $request->query('perPage', 20);
            $page = $request->query('page', 1);

            return $transactions->paginate($perPage);
        }
        return $transactions->get();
    }

    public function getAllCardTransactions(Request $request, Card $card): Collection|Paginator
    {
        return $this->formatCardTransactionsList($request, $card->cardTransactions());
    }

    public function getIncomeCardTransactions(Request $request, Card $card): Collection|Paginator
    {
        return $this->formatCardTransactionsList($request, $card->cardTransactions()->where('transaction_type', true));
    }

    public function getOutcomeCardTransactions(Request $request, Card $card): Collection|Paginator
    {
        return $this->formatCardTransactionsList($request, $card->cardTransactions()->where('transaction_type', false));
    }
}
