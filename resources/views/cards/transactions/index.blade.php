<x-layout>
    <div class="m-auto max-w-screen-xl border">
        <div class="grid grid-flow-col justify-stretch">
            @if(!$transactionsType)
                <p class="m-auto">
                    Історія використання картки (історія поїздок)
                </p>
                <a class="bg-accent text-center w-full"
                   href="{{ route('cards.transactions.index', ['card' => $card]).'?type=income' }}">
                    Історія поповнення картки
                </a>
            @else
                <a class="bg-accent text-center w-full"
                   href="{{ route('cards.transactions.index', ['card' => $card]).'?type=outcome' }}">
                    Історія використання картки (історія поїздок)
                </a>
                <p class="m-auto">
                    Історія поповнення картки
                </p>
            @endif
        </div>

        <div>
            @if(count($transactions) == 0)
                Список пустий
            @else
                <table class="w-full text-sm text-left rtl:text-right">
                    <thead class="uppercase bg-gray-700">
                    <tr class="border">
                        <th class="px-6 py-3 border-r">Дата, час</th>
                        <th class="px-6 py-3">Зміна балансу</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $transaction)
                        <tr class="border">
                            <td class="px-6 py-3 border-r">{{ $transaction->created_at }}</td>
                            <td class="px-6 py-3">{{ ($transactionsType ? "+" : "-") . $transaction->balance_change }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-layout>
