<div class="card">
    <h2>{{$card->type}} проїзний квиток (картка)</h2>
    <p>{{$card->number}}</p>
    <p>
        <balance>{{$card->current_balance}}</balance>
        <sup> UAH</sup></p>
    <a href="/cards/{{$card->id}}/history?type=outcome">Історія поїздок</a>
    <a href="/cards/{{$card->id}}/history?type=income">Історія поповнень</a>
</div>
