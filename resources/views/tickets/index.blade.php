<x-layout>
    <div class="m-auto max-w-screen-xl">
        <p class="mb-6">
            <a class="text-accent hover:text-neutral" href='{{ route('cities.index') }}'>
                Список міст
            </a>
        </p>

        <h1 class="mb-4">Типи квитків, {{$city->name}}</h1>

        @if(count($tickets)==0)
            Список пустий
        @else
            <table class="w-full text-sm text-left rtl:text-right">
                <thead class="uppercase bg-gray-700">
                <tr class="border">
                    <th class="px-6 py-3 border-r">Тип транспорту</th>
                    <th class="px-6 py-3 border-r">Тип квитка</th>
                    <th class="px-6 py-3 border-r">Ціна, грн</th>
                    <th class="px-6 py-3 border-r">Змінити</th>
                    <th class="px-6 py-3">Видалити</th>
                </tr>
                </thead>
                @foreach($tickets as $ticket)
                    <tbody>
                    <tr class="border">
                        <td class="px-6 py-3 border-r">{{$ticket->transport_type}}</td>
                        <td class="px-6 py-3 border-r">{{$ticket->ticket_type}}</td>
                        <td class="px-6 py-3 border-r">{{$ticket->price}}</td>
                        <td class="px-6 py-3 border-r">
                            <a class="text-accent hover:text-neutral"
                               href="{{ route('tickets.edit', ['city' => $city, 'ticket' => $ticket]) }}">
                                Редагувати
                            </a>
                        </td>
                        <td class="px-6 py-3">
                            <form method="POST"
                                  action="{{ route('tickets.destroy', ['city' => $city, 'ticket' => $ticket]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-accent hover:text-neutral">
                                    Видалити
                                </button>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
        @endif
        <a class="text-accent hover:text-neutral" href="{{ route('tickets.create', ['city' => $city]) }}">
            Додати тип квитка
        </a>
    </div>
</x-layout>
