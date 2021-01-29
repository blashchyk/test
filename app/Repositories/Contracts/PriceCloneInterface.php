<?php


namespace App\Repositories\Contracts;


interface PriceCloneInterface
{
    public function createPriceClone(int $siteId, int $parentId);
}
