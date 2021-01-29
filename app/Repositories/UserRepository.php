<?php


namespace App\Repositories;


use App\Models\User;
use App\Repositories\Contracts\UserInterface;

class UserRepository implements UserInterface
{
    protected $model = User::class;

    public function getUserByUserName(string $name): ?User
    {
        return $this->model::where('username', $name)->first();
    }
}
