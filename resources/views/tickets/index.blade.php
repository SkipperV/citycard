<x-layout>
    <p><a href='/admin/cities'>Список міст</a></p>
    <h1>Типи квитків, {{$city->name}}</h1>
    @if(count($tickets)==0)
        Список пустий
    @else
        <table>
            <thead>
            <tr>
                <th>Тип транспорту</th>
                <th>Тип квитка</th>
                <th>Ціна, грн</th>
                <th>Змінити</th>
                <th>Видалити</th>
            </tr>
            </thead>
            @foreach($tickets as $ticket)
                <tbody>
                <tr>
                    <td>{{$ticket->transport_type}}</td>
                    <td>{{$ticket->ticket_type}}</td>
                    <td>{{$ticket->price}}</td>
                    <td><a href="/admin/cities/{{$city->id}}/tickets/{{$ticket->id}}/edit">Редагувати</a></td>
                    <td>
                        <form method="POST" action="/admin/cities/{{$city->id}}/tickets/{{$ticket->id}}">
                            @csrf
                            @method('DELETE')
                            <button>Видалити</button>
                        </form>
                    </td>
                </tr>
                </tbody>
            @endforeach
        </table>
    @endif
    <a href="/admin/cities/{{$city->id}}/tickets/create">Додати тип квитка</a>
</x-layout>
