<x-layout>
    <x-elements-card class="mx-4">
        <header class="text-center">
            <h2 class="text-2xl font-bold mb-1">Редагування <u>{{$city->name}}</u></h2>
        </header>

        <form method="POST" action="{{ route('cities.update', ['city' => $city]) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="region" class="inline-block text-lg mb-2">
                    Область
                </label>
                <input type="text" name="region" class="border border-gray-200 rounded p-2 w-full text-black"
                       value="{{$city->region}}">

                @error('region')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2">
                    Назва міста
                </label>
                <input type="text" name="name" class="border border-gray-200 rounded p-2 w-full text-black"
                       value="{{$city->name}}">

                @error('name')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-accent hover:bg-neutral px-3 py-1">
                    Змінити
                </button>
                <a class="text-accent hover:text-neutral" href="{{ route('cities.index') }}">Назад</a>
            </div>
        </form>
    </x-elements-card>
</x-layout>
