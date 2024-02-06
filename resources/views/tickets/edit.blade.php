<x-layout>
    <h1>Змінити параметри квитка</h1>
    <form method="POST" action="/admin/cities/{{$city_id}}/tickets/{{$ticket->id}}">
        @csrf
        @method('PUT')
        <div>
            <label for="transport_type">Тип транспорту</label>
            <select name="transport_type">
                @if($ticket->transport_type=="Автобус")
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
            <label for="ticket_type">Тип квитка</label>
            <select name="ticket_type">
                @foreach(['Стандартний', 'Дитячий', 'Студентський', 'Пільговий', 'Спеціальний'] as $ticket_type)
                    @if($ticket_type == $ticket->ticket_type)
                        <option value={{$ticket_type}} selected>{{$ticket_type}}</option>
                    @else
                        <option value={{$ticket_type}}>{{$ticket_type}}</option>
                    @endif
                @endforeach
            </select>
            @error('ticket_type')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <label for="price">Ціна проїзду</label>
            <input type="text" name="price" value="{{$ticket->price}}">
            @error('price')
            <p style="color: firebrick">{{$message}}</p>
            @enderror
        </div>
        <div>
            <button>
                Змінити
            </button>
            <a href="/admin/cities/{{$city_id}}/tickets">Назад</a>
        </div>
    </form>
</x-layout>
