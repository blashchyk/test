<?php


namespace App\Repositories\Contracts;


use App\Models\CdnImages;

interface CdnImagesInterface
{
    public function getImages(int $projectId) : CdnImages;
    public function copy(int $projectId, int $newId, array $input);
}
