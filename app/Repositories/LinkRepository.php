<?php


namespace App\Repositories;


use App\Models\Link;
use App\Repositories\Contracts\LinkInterface;
use Illuminate\Support\Str;

class LinkRepository implements LinkInterface
{
    protected $model = Link::class;

    public function create($appName, $referrerId, $whiteLabelId): Link
    {
        return $this->model::create([
            'name' => $appName,
            'code' => Str::random(8),
            'page' => '/',
            'referrer_id' => $referrerId,
            'app_id' => $whiteLabelId
        ]);
    }
}
