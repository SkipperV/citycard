<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface CardRepositoryInterface
{
    public function getAllCardsByAuthUser();

    public function getCardByNumber(int $cardNumber);

    public function connectCardToUser(User $user, int $cardNumber);
}
