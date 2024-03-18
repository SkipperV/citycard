<x-layout>
    <x-elements-card class="mx-4">
        <header class="text-center">
            <h2 class="text-2xl font-bold mb-1">Редагування квитка</h2>
        </header>

        <form method="POST" action="/admin/cities/{{$city_id}}/tickets/{{$ticket->id}}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="transport_type" class="inline-block text-lg mb-2">
                    Тип транспорту
                </label>
                <select name="transport_type" class="border border-gray-200 rounded p-2 w-full text-black">
                    @if($ticket->transport_type=="Автобус")
                        <option value="Автобус" selected>Автобус</option>
                        <option value="Тролейбус">Тролейбус</option>
                    @else
                        <option value="Автобус">Автобус</option>
                        <option value="Тролейбус" selected>Тролейбус</option>
                    @endif
                </select>
                @error('transport_type')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="ticket_type" class="inline-block text-lg mb-2">
                    Тип квитка
                </label>
                <select name="ticket_type" class="border border-gray-200 rounded p-2 w-full text-black">
                    @foreach(['Стандартний', 'Дитячий', 'Студентський', 'Пільговий', 'Спеціальний'] as $ticket_type)
                        @if($ticket_type == $ticket->ticket_type)
                            <option value={{$ticket_type}} selected>{{$ticket_type}}</option>
                        @else
                            <option value={{$ticket_type}}>{{$ticket_type}}</option>
                        @endif
                    @endforeach
                </select>

                @error('ticket_type')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="price" class="inline-block text-lg mb-2">Ціна проїзду</label>
                <input type="text" name="price" class="border border-gray-200 rounded p-2 w-full text-black"
                       value="{{$ticket->price}}">

                @error('price')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-accent hover:bg-neutral px-3 py-1">
                    Змінити
                </button>
                <a class="text-accent hover:text-neutral" href="/admin/cities/{{$city_id}}/tickets">Назад</a>
            </div>
        </form>
    </x-elements-card>
</x-layout>
