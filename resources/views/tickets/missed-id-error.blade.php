<x-layout>
    <x-elements-card class="mx-4">
        <h2 class="text-2xl font-bold mb-1 text-center">Помилка</h2>
        <p class="text-lg text-center mb-12">Не співпадають id міста та квитка</p>
        <div class="text-center">
            <a class="bg-accent hover:bg-neutral px-3 py-1 mr-2 rounded"
               href="{{ route('cities.index') }}">
                Список міст
            </a>
            <a class="bg-accent hover:bg-neutral px-3 py-1 rounded"
               href="{{ route('tickets.index', ['city' => $city]) }}">
                Список квитків міста {{$city->name}}
            </a>
        </div>
    </x-elements-card>
</x-layout>
