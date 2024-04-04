<div class="card">
    <header class="text-center">
        <h2 class="text-2xl font-bold mb-1">{{$card->type}} проїзний квиток (картка)</h2>
    </header>

    <p>{{$card->number}}</p>
    <p>
        {{$card->current_balance}}
        <sup> UAH</sup>
    </p>

    <div>
        <a class="text-accent hover:text-neutral mr-4"
           href="{{ route('cards.transactions.index', ['card' => $card]).'?type=outcome' }}">
            Історія поїздок
        </a>
        <a class="text-accent hover:text-neutral"
           href="{{ route('cards.transactions.index', ['card' => $card]).'?type=income' }}">
            Історія поповнень
        </a>
    </div>
</div>
