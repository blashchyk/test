<?php


namespace App\Repositories\Contracts;


use App\Models\Referrer;

interface ReferrerInterface
{
    public function get(int $webmasterId): Referrer;
}
