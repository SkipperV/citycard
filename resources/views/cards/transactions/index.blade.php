<x-layout>
    <div class="transaction-history-tabs">
        @if(!$transaction_type)
            <p class="active tab">Історія використання картки (історія
                поїздок)</p>
            <a class="tab" href="{{'/'.Request::path().'?type=income'}}">Історія поповнення картки</a>
        @else
            <a class="tab" href="{{'/'.Request::path().'?type=outcome'}}">Історія використання картки (історія
                поїздок)</a>
            <p class="active tab">Історія поповнення картки</p>
        @endif
    </div>
    <div>
        @if(count($transactions) == 0)
            Список пустий
        @else
            <table>
                <thead>
                <tr>
                    <th>Дата, час</th>
                    <th>Зміна балансу</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{$transaction->created_at}}</td>
                        <td>{{($transaction_type ? "+" : "-") . $transaction->balance_change}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-layout>
