<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class CardController extends Controller
{
    public function index(): Collection|Response
    {
        $cards = auth()->user()->cards;
        return $cards->isNotEmpty() ? $cards : response([], 204);
    }

    public function show(Card $card): Card
    {
        if (!auth()->user()->cards()->find($card->id)) {
            return abort(404);
        }
        return $card;
    }
}
