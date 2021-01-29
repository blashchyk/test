<?php


namespace App\Services\WhitelabelCreator\Manager;


use App\Repositories\Contracts\AppClientUserInterface;
use App\Repositories\Contracts\LinkInterface;
use App\Repositories\Contracts\MongoClientsInterface;
use App\Repositories\Contracts\OauthClientsInterface;
use App\Repositories\Contracts\ReferrerInterface;
use App\Repositories\Contracts\UserInterface;
use App\Services\WhitelabelCreator\Contracts\PartnerManagerInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PartnerManager implements PartnerManagerInterface
{
    const PARENT_ID = [

    ];
    private $oauthClients;
    private $referrer;
    private $link;
    private $appClientUser;
    private $clientConfig;
    private $user;

    public function __construct(
        OauthClientsInterface $oauthClients,
        ReferrerInterface $referrer,
        LinkInterface $link,
        AppClientUserInterface $appClientUser,
        MongoClientsInterface $clientConfig,
        UserInterface $user
    ) {
        $this->oauthClients = $oauthClients;
        $this->referrer = $referrer;
        $this->link = $link;
        $this->appClientUser = $appClientUser;
        $this->clientConfig = $clientConfig;
        $this->user = $user;
    }

    public function run($webmasterEmail, $whiteLabelId)
    {
        $user = $this->user->getUserByUserName($webmasterEmail);
        if (!$user) {
            throw new ModelNotFoundException('User not found by email ' . $webmasterEmail);
        }

        $app = $this->oauthClients->get($whiteLabelId);
        $this->appClientUser->add($app->new_id, $user->id);
        $referrer = $this->referrer->get($user->id);
        $link = $this->link->create($app->name, $referrer->id, $whiteLabelId);
        $this->clientConfig->setReferrer($whiteLabelId, $link->id, $referrer->id);
    }
}

