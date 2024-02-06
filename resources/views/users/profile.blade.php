<x-layout>
    @if(count($cards)==0)
        <p>Немає карток, зв'язаних із вашим номером телефону</p>
    @else
        <h1>Ваші картки</h1>
    @endif
    @foreach($cards as $card)
        @include('cards.show')
    @endforeach
</x-layout>
