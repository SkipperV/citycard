<x-layout>
    <p><a href='/admin/cities'>Список міст</a></p>
    <h1>Маршрути, {{$city->name}}</h1>
    @if(count($transport_routes)==0)
        Список пустий
    @else
    <table>
        <thead>
        <tr>
            <th>№</th>
            <th>Тип</th>
            <th>Кінцева 1</th>
            <th>Кінцева 2</th>
            <th>Змінити</th>
            <th>Видалити</th>
        </tr>
        </thead>
        @foreach($transport_routes as $transportRoute)
            <tbody>
            <tr>
                <td>{{$transportRoute->route_number}}</td>
                <td>{{$transportRoute->transport_type}}</td>
                <td>{{$transportRoute->route_endpoint_1}}</td>
                <td>{{$transportRoute->route_endpoint_2}}</td>
                <td><a href="/admin/cities/{{$city->id}}/transport/{{$transportRoute->id}}/edit">Редагувати</a></td>
                <td>
                    <form method="POST" action="/admin/cities/{{$city->id}}/transport/{{$transportRoute->id}}">
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
    <a href="/admin/cities/{{$city->id}}/transport/create">Додати маршрут</a>
</x-layout>
