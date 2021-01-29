<?php


namespace App\Repositories;


use App\Models\CdnImages;
use App\Repositories\Contracts\CdnImagesInterface;

class CdnImagesRepository implements CdnImagesInterface
{
    protected $collection = CdnImages::class;

    public function getImages($projectId): CdnImages
    {
        return $this->collection::where('project_id', $projectId)->first();
    }

    public function copy($projectId, $newId, $input)
    {
        $parentImages = $this->getImages($projectId)->images;
        $parentImages['rateus_logo'] = $input['pathLogo'];
        $parentImages['favicon'] = $input['pathFavicon'];
        $parentImages['navbar']['logo'] = $input['pathLogo'];
        $parentImages['navbar']['mobile_logo'] = $input['mobileLogo'];
        $this->collection::create(['project_id' => $newId, 'images' => $parentImages]);
    }
}

