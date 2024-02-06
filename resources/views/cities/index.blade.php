<x-layout>
    <h1>Міста</h1>
    @include('partials._search')
    @if(count($cities) == 0)
        Список пустий
    @else
        <table>
            <thead>
            <tr>
                <th>Місто, область</th>
                <th>Транспорт</th>
                <th>Квитки</th>
                <th>Змінити</th>
                <th>Видалити</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cities as $city)
                <tr>
                    <td>{{$city->name}}, {{$city->region}} область</td>
                    <td><a href="/admin/cities/{{$city->id}}/transport">Переглянути транспорт</a></td>
                    <td><a href="/admin/cities/{{$city->id}}/tickets">Переглянути типи квитків</a></td>
                    <td><a href="/admin/cities/{{$city->id}}/edit">Редагувати</a></td>
                    <td>
                        <form method="POST" action="/admin/cities/{{$city->id}}">
                            @csrf
                            @method('DELETE')
                            <button>Видалити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <a href="/admin/cities/create">Додати місто</a>
</x-layout>
