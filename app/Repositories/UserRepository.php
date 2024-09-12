<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function getUserByLogin(string $login): User
    {
        return User::where('login', $login)->first();
    }
}
