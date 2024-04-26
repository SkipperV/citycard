<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Database\Eloquent\Collection;

class CardController extends Controller
{
    public function index(): Collection
    {
        return auth()->user()->cards;
    }

    public function show(Card $card): Card
    {
        return $card;
    }
}
