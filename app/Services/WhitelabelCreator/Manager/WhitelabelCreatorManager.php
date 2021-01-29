<?php


namespace App\Services\WhitelabelCreator\Manager;


use App\Repositories\Contracts\CdnImagesInterface;
use App\Repositories\Contracts\MongoClientsInterface;
use App\Repositories\Contracts\OauthClientsInterface;
use App\Repositories\Contracts\PriceCloneInterface;
use App\Services\WhitelabelCreator\Contracts\ControlVersionManagerInterface;
use App\Services\WhitelabelCreator\Contracts\PartnerManagerInterface;
use App\Services\WhitelabelCreator\Contracts\WhitelabelCreatorManagerInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class WhitelabelCreatorManager implements WhitelabelCreatorManagerInterface
{
    const PARENT = [
        4 => 'speedypaper.com',
        5 => 'papercoach.net',
        10 => 'rocketpaper.net',
        25 => 'writepaperfor.me',
        32 => 'resume101.org',
        37 => 'nursingessaywriting.com',
        44 => 'mypaperedit.com',
        60 => 'eduvinci.com',
        63 => 'homeworkfor.me'
    ];

    private $mongoClients;
    private $cdnImages;
    private $oauthClients;
    private $priceClone;
    private $partnerManager;
    private $bladeManager;

    public function __construct(
        MongoClientsInterface $mongoClients,
        CdnImagesInterface $cdnImages,
        OauthClientsInterface $oauthClients,
        PriceCloneInterface $priceClone,
        PartnerManagerInterface $partnerManager,
        ControlVersionManagerInterface $bladeManager

    ) {
        $this->mongoClients = $mongoClients;
        $this->cdnImages = $cdnImages;
        $this->oauthClients = $oauthClients;
        $this->priceClone = $priceClone;
        $this->partnerManager = $partnerManager;
        $this->bladeManager = $bladeManager;
    }

    public function createACloneOfTheSite($input): string
    {
        $validator = Validator::make($input, [
            "creator" => "required",
            "creatorEmail" => "required",
            "parentSite" => 'required',
            "nameNewSite" => 'required',
            "abbreviation" => "required",
            "pathLogo" => "required",
            "mobileLogo" => "required",
            "pathFavicon" => "required",
            "phoneNumber" => "required",
            "idSales" => "required",
            "idCollectors" => "required",
            "email" => "required",
            "parentPriceId" => "required",
            "messenger" => "required",
            "emailWebMaster" => "required",
            "pages" => "required"
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $key = array_search($input['parentSite'], self::PARENT);


        if (!$key) {
            throw new ModelNotFoundException('Site not found by name ' . $input['parentSite']);
        }

        $newId = $this->mongoClients->copy($key, $input);
        $this->cdnImages->copy($key, $newId, $input);
        $newProject = $this->oauthClients->createNewProject($newId, $input['nameNewSite'], $input['abbreviation'], $key);
        $this->priceClone->createPriceClone($newId, $input['parentPriceId']);
        if ($input['emailWebMaster']) {
            $this->partnerManager->run($input['emailWebMaster'], $newProject->id);
        }
        if (Arr::get($input, 'createBlades', true)) {
            $this->bladeManager->createNewPullRequest($input);
        }

        return 'WL created';
    }
}
