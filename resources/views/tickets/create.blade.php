<x-layout>
    <h1>Додати тип квитка</h1>
    <form method="POST" action="/admin/cities/{{$city_id}}/tickets">
        @csrf
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
            <label for="ticket_type">Тип квитка</label>
            <select name="ticket_type" value="{{old('ticket_type')}}">
                <option value="" selected disabled hidden></option>
                <option value="Стандартний">Стандартний</option>
                <option value="Дитячий">Дитячий</option>
                <option value="Студентський">Студентський</option>
                <option value="Пільговий">Пільговий</option>
                <option value="Спеціальний">Спеціальний</option>
            </select>
            @error('ticket_type')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <label for="price">Ціна проїзду</label>
            <input type="text" name="price" value="{{old('price')}}">
            @error('price')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <button>
                Додати
            </button>
            <a href="/admin/cities/{{$city_id}}/tickets">Назад</a>
        </div>
    </form>
</x-layout>
