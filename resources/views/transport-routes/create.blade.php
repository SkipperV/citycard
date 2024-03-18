<x-layout>
    <x-elements-card class="mx-4">
        <header class="text-center">
            <h2 class="text-2xl font-bold mb-1">Додати тип квитка</h2>
        </header>

        <form method="POST" action="/admin/cities/{{$city_id}}/transport">
            @csrf

            <div class="mb-6">
                <label for="route_number" class="inline-block text-lg mb-2">
                    Номер маршруту
                </label>
                <input type="text" name="route_number" class="border border-gray-200 rounded p-2 w-full text-black"
                       value="{{old('route_number')}}">

                @error('route_number')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

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
                <label for="route_endpoint_1" class="inline-block text-lg mb-2">
                    Кінцева зупинка 1
                </label>
                <input type="text" name="route_endpoint_1" class="border border-gray-200 rounded p-2 w-full text-black"
                       value="{{old('route_endpoint_1')}}">

                @error('route_endpoint_1')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="route_endpoint_2" class="inline-block text-lg mb-2">
                    Кінцева зупинка 2
                </label>
                <input type="text" name="route_endpoint_2" class="border border-gray-200 rounded p-2 w-full text-black"
                       value="{{old('route_endpoint_2')}}">

                @error('route_endpoint_2')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-accent hover:bg-neutral px-3 py-1">
                    Додати
                </button>
                <a class="text-accent hover:text-neutral" href="/admin/cities/{{$city_id}}/transport">Назад</a>
            </div>
        </form>
    </x-elements-card>
</x-layout>
