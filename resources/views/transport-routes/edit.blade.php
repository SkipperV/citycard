<x-layout>
    <h1>Змінити параметри квитка</h1>
    <form method="POST" action="/admin/cities/{{$city_id}}/transport/{{$transport_route->id}}">
        @csrf
        @method('PUT')
        <div>
            <label for="route_number">Номер маршруту</label>
            <input type="text" name="route_number" value="{{$transport_route->route_number}}">
            @error('route_number')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <label for="transport_type">Тип транспорту</label>
            <select name="transport_type">
                @if($transport_route->transport_type=="Автобус")
                    <option value="Автобус" selected>Автобус</option>
                    <option value="Тролейбус">Тролейбус</option>
                @else
                    <option value="Автобус">Автобус</option>
                    <option value="Тролейбус" selected>Тролейбус</option>
                @endif
            </select>
            @error('transport_type')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <label for="route_endpoint_1">Кінцева зупинка 1</label>
            <input type="text" name="route_endpoint_1" value="{{$transport_route->route_endpoint_1}}">
            @error('route_endpoint_1')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <label for="route_endpoint_2">Кінцева зупинка 2</label>
            <input type="text" name="route_endpoint_2" value="{{$transport_route->route_endpoint_2}}">
            @error('route_endpoint_2')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <button>
                Змінити
            </button>
            <a href="/admin/cities/{{$city_id}}/transport">Назад</a>
        </div>
    </form>
</x-layout>
