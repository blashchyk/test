<?php


namespace App\Repositories\Contracts;


use App\Models\Link;

interface LinkInterface
{
    public function create(string $appName, int $referrerId, int $whiteLabelId): Link;
}
