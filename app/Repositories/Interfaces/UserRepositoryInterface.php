<?php

namespace App\Repositories\Interfaces;

use App\Models\Card;

interface UserRepositoryInterface
{
    public function createUser(array $data);

    public function getUserByLogin(string $login);
}
