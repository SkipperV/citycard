<?php

namespace App\Repositories;

use App\Models\Card;
use App\Models\User;
use App\Repositories\Interfaces\CardRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CardRepository implements CardRepositoryInterface
{
    public function getAllCardsByAuthUser(): Collection
    {
        return auth()->user()->cards;
    }

    public function getCardByNumber(int $cardNumber): Card
    {
        return Card::where('number', $cardNumber)->firstOrFail();
    }

    public function connectCardToUser(User $user, int $cardNumber): bool
    {
        $card = $this->getCardByNumber($cardNumber);

        return $card->update(['user_id' => $user->id]);
    }
}
