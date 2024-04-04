<x-layout>
    <div class="m-auto max-w-screen-xl">
        <p class="mb-6">
            <a class="text-accent hover:text-neutral" href='{{ route('cities.index') }}'>
                Список міст
            </a>
        </p>

        <h1>Маршрути, {{$city->name}}</h1>

        @if(count($transportRoutes)==0)
            Список пустий
        @else
            <table class="w-full text-sm text-left rtl:text-right">
                <thead class="uppercase bg-gray-700">
                <tr class="border">
                    <th class="px-6 py-3 border-r">№</th>
                    <th class="px-6 py-3 border-r">Тип</th>
                    <th class="px-6 py-3 border-r">Кінцева 1</th>
                    <th class="px-6 py-3 border-r">Кінцева 2</th>
                    <th class="px-6 py-3 border-r">Змінити</th>
                    <th class="px-6 py-3">Видалити</th>
                </tr>
                </thead>
                @foreach($transportRoutes as $transportRoute)
                    <tbody>
                    <tr class="border">
                        <td class="px-6 py-3 border-r">{{$transportRoute->route_number}}</td>
                        <td class="px-6 py-3 border-r">{{$transportRoute->transport_type}}</td>
                        <td class="px-6 py-3 border-r">{{$transportRoute->route_endpoint_1}}</td>
                        <td class="px-6 py-3 border-r">{{$transportRoute->route_endpoint_2}}</td>
                        <td class="px-6 py-3 border-r">
                            <a class="text-accent hover:text-neutral"
                               href="{{ route('transport.edit', ['city' => $city, 'transport' => $transportRoute]) }}">
                                Редагувати
                            </a>
                        </td>
                        <td class="px-6 py-3">
                            <form method="POST"
                                  action="{{ route('transport.destroy', ['city' => $city, 'transport' => $transportRoute]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-accent hover:text-neutral">Видалити</button>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
        @endif
        <a class="text-accent hover:text-neutral" href="{{ route('transport.create', ['city' => $city]) }}">
            Додати маршрут
        </a>
    </div>
</x-layout>
