<?php


namespace App\Repositories;


use App\Models\PriceClone;
use App\Repositories\Contracts\PriceCloneInterface;

class PriceCloneRepository implements PriceCloneInterface
{
    protected $model = PriceClone::class;

    public function createPriceClone(int $siteId, int $parentId)
    {
        $this->model::create(['site_id' => $siteId, 'parent_id' => $parentId]);
    }
}
