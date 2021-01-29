<?php


namespace App\Repositories;


use App\Models\Referrer;
use App\Repositories\Contracts\ReferrerInterface;

class ReferrerRepository implements ReferrerInterface
{
    protected $model = Referrer::class;

    public function get(int $webmasterId): Referrer
    {
        return $this->model::where('user_id', $webmasterId)
            ->where('referrer_type_id', Referrer::TYPE_WEBMASTER_TRAFIC)
            ->first();
    }
}
