<x-layout>
    <h1>Додати маршрут</h1>
    <form method="POST" action="/admin/cities/{{$city_id}}/transport">
        @csrf
        <div>
            <label for="route_number">Номер маршруту</label>
            <input type="text" name="route_number" value="{{old('route_number')}}">
            @error('route_number')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <label for="transport_type">Тип транспорту</label>
            <select name="transport_type" value="{{old('transport_type')}}">
                <option value="" selected disabled hidden></option>
                <option value="Автобус">Автобус</option>
                <option value="Тролейбус">Тролейбус</option>
            </select>
            @error('transport_type')
                <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <label for="route_endpoint_1">Кінцева зупинка 1</label>
            <input type="text" name="route_endpoint_1" value="{{old('route_endpoint_1')}}">
            @error('route_endpoint_1')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <label for="route_endpoint_2">Кінцева зупинка 2</label>
            <input type="text" name="route_endpoint_2" value="{{old('route_endpoint_2')}}">
            @error('route_endpoint_2')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <button>
                Додати
            </button>
            <a href="/admin/cities/{{$city_id}}/transport">Назад</a>
        </div>
    </form>
</x-layout>
