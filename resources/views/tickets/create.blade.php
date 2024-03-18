<x-layout>
    <x-elements-card class="mx-4">
        <header class="text-center">
            <h2 class="text-2xl font-bold mb-1">Додати тип квитка</h2>
        </header>

        <form method="POST" action="/admin/cities/{{$city_id}}/tickets">
            @csrf

            <div class="mb-6">
                <label for="transport_type" class="inline-block text-lg mb-2">
                    Тип транспорту
                </label>
                <select name="transport_type" class="border border-gray-200 rounded p-2 w-full text-black"
                        value="{{old('transport_type')}}">
                    <option value="" selected disabled hidden></option>
                    <option value="Автобус">Автобус</option>
                    <option value="Тролейбус">Тролейбус</option>
                </select>

                @error('transport_type')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="ticket_type" class="inline-block text-lg mb-2">
                    Тип квитка
                </label>
                <select name="ticket_type" class="border border-gray-200 rounded p-2 w-full text-black"
                        value="{{old('ticket_type')}}">
                    <option value="" selected disabled hidden></option>
                    <option value="Стандартний">Стандартний</option>
                    <option value="Дитячий">Дитячий</option>
                    <option value="Студентський">Студентський</option>
                    <option value="Пільговий">Пільговий</option>
                    <option value="Спеціальний">Спеціальний</option>
                </select>

                @error('ticket_type')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="price" class="inline-block text-lg mb-2">
                    Ціна проїзду
                </label>
                <input type="text" name="price" value="{{old('price')}}"
                       class="border border-gray-200 rounded p-2 w-full text-black">

                @error('price')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-accent hover:bg-neutral px-3 py-1">
                    Додати
                </button>
                <a class="text-accent hover:text-neutral" href="/admin/cities/{{$city_id}}/tickets">Назад</a>
            </div>
        </form>
    </x-elements-card>
</x-layout>
