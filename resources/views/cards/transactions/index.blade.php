<x-layout>
    <div class="m-auto max-w-screen-xl">
        <div class="grid grid-cols-2 mb-4 h-12">
            @if(!$transactionsType)
                <div class="flex items-center bg-gray-700 border">
                    <p class="m-auto">
                        Історія використання картки (історія поїздок)
                    </p>
                </div>
                <a class="flex justify-center items-center bg-secondary border hover:bg-gray-800"
                   href="{{ route('cards.transactions.index', ['card' => $card]).'?type=income' }}">
                    Переглянути сторію поповнення картки
                </a>
            @else
                <a class="flex justify-center items-center bg-secondary border hover:bg-gray-800"
                   href="{{ route('cards.transactions.index', ['card' => $card]).'?type=outcome' }}">
                    Переглянути історію використання картки (історію поїздок)
                </a>
                <div class="flex items-center bg-gray-700 border border-l-0">
                    <p class="m-auto">
                        Історія поповнення картки
                    </p>
                </div>
            @endif
        </div>

        <div class="border">
            @if(count($transactions) == 0)
                Список пустий
            @else
                <table class="w-full text-sm text-left rtl:text-right">
                    <thead class="uppercase bg-gray-700">
                    <tr class="border grid grid-cols-2">
                        <th class="px-6 py-3 border-r">Дата, час</th>
                        <th class="px-6 py-3">Зміна балансу</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $transaction)
                        <tr class="border grid grid-cols-2">
                            <td class="px-6 py-3 border-r">{{ $transaction->created_at }}</td>
                            <td class="px-6 py-3">{{ ($transactionsType ? "+" : "-") . $transaction->balance_change }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($transactions->hasPages())
                    <div class="ml-5 mt-3">
                        {{$transactions->links()}}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-layout>
