<x-layout>
    <div class="m-auto max-w-screen-xl">
        <h1>Міста</h1>
        <div class="mb-4">
            @include('partials._search')
            @if(Request::get('search')!='')
                <p>
                    Результат пошуку "<b>{{Request::get('search')}}"</b>
                    <a class="text-accent hover:text-neutral" href="{{ route('cities.index') }}">
                        Скинути
                    </a>
                </p>
            @endif
        </div>
        @if(count($cities) == 0)
            <p>Список пустий</p>
        @else
            <table class="w-full text-sm text-left rtl:text-right">
                <thead class="uppercase bg-gray-700">
                <tr class="border">
                    <th class="px-6 py-3 border-r">Місто, область</th>
                    <th class="px-6 py-3 border-r">Транспорт</th>
                    <th class="px-6 py-3 border-r">Квитки</th>
                    <th class="px-6 py-3 border-r">Змінити</th>
                    <th class="px-6 py-3">Видалити</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cities as $city)
                    <tr class="border">
                        <td class="px-6 py-3 border-r">
                            {{$city->name}}, {{$city->region}} область
                        </td>
                        <td class="px-6 py-3 border-r">
                            <a class="text-accent hover:text-neutral"
                               href="{{ route('transport.index', ['city' => $city]) }}">
                                Переглянути транспорт
                            </a>
                        </td>
                        <td class="px-6 py-3 border-r">
                            <a class="text-accent hover:text-neutral"
                               href="{{ route('tickets.index', ['city' => $city]) }}">
                                Переглянути типи квитків
                            </a>
                        </td>
                        <td class="px-6 py-3 border-r">
                            <a class="text-accent hover:text-neutral"
                               href="{{ route('cities.edit', ['city' => $city]) }}">
                                Редагувати
                            </a>
                        </td>
                        <td class="px-6 py-3">
                            <form method="POST" action="{{ route('cities.destroy', ['city' => $city]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-accent hover:text-neutral">Видалити</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        <a class="text-accent hover:text-neutral" href="{{ route('cities.create') }}">Додати місто</a>
    </div>
</x-layout>
