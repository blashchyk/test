<?php


namespace App\Repositories\Contracts;


use App\Models\User;

interface UserInterface
{
    public function getUserByUserName(string $name): ?User;
}
