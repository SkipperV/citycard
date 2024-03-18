<x-layout>
    @if(count($cards)==0)
        <p>Немає карток, зв'язаних із вашим номером телефону</p>
    @else
        <header class="text-center">
            <h2 class="text-2xl font-bold mb-1">Ваші картки</h2>
        </header>
    @endif
    @foreach($cards as $card)
        <x-elements-card>
            @include('cards.show')
        </x-elements-card>
    @endforeach
</x-layout>
