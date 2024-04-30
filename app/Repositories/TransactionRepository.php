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
        if ($request->query('dateFrom', null)) {
            $transactions = $transactions->where('created_at', '>', $request->query('dateFrom', null));
        }
        if ($request->query('dateTo', null)) {
            $transactions = $transactions->where('created_at', '<', $request->query('dateTo', null));
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
        return $this->formatCardTransactionsList($request, $card->cardTransactions()->latest());
    }

    public function getIncomeCardTransactions(Request $request, Card $card): Collection|Paginator
    {
        return $this->formatCardTransactionsList(
            $request,
            $card->cardTransactions()->where('transaction_type', true)->latest()
        );
    }

    public function getOutcomeCardTransactions(Request $request, Card $card): Collection|Paginator
    {
        return $this->formatCardTransactionsList(
            $request,
            $card->cardTransactions()->where('transaction_type', false)->latest()
        );
    }
}
