<?php

namespace App\Repositories;

use App\Enums\TransactionType;
use App\Interfaces\TransactionRepositoryInterface;
use App\Models\Card;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function formatCardTransactionsList(Request $request, HasMany $transactions): LengthAwarePaginator
    {
        if ($request->query('dateFrom', null)) {
            $transactions = $transactions->where('created_at', '>', $request->query('dateFrom', null));
        }
        if ($request->query('dateTo', null)) {
            $transactions = $transactions->where('created_at', '<', $request->query('dateTo', null));
        }
        $perPage = $request->query('perPage', 20);

        return $transactions->paginate($perPage);
    }

    public function getIncomeCardTransactions(Request $request, Card $card): Paginator
    {
        return $this->formatCardTransactionsList(
            $request,
            $card->cardTransactions()->where('transaction_type', TransactionType::Income)->latest()
        );
    }

    public function getOutcomeCardTransactions(Request $request, Card $card): Paginator
    {
        return $this->formatCardTransactionsList(
            $request,
            $card->cardTransactions()->where('transaction_type', TransactionType::Outcome)->latest()
        );
    }
}
