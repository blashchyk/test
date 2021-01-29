<?php

namespace App\Providers;

use App\Repositories\{AppClientUserRepository,
    CdnImagesRepository,
    LinkRepository,
    MongoClientsRepository,
    OauthClientsRepository,
    PriceCloneRepository,
    ReferrerRepository,
    UserRepository};
use App\Repositories\Contracts\{AppClientUserInterface,
    CdnImagesInterface,
    LinkInterface,
    MongoClientsInterface,
    OauthClientsInterface,
    PriceCloneInterface,
    ReferrerInterface,
    UserInterface};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MongoClientsInterface::class, MongoClientsRepository::class);
        $this->app->bind(CdnImagesInterface::class, CdnImagesRepository::class);
        $this->app->bind(OauthClientsInterface::class, OauthClientsRepository::class);
        $this->app->bind(PriceCloneInterface::class, PriceCloneRepository::class);
        $this->app->bind(LinkInterface::class, LinkRepository::class);
        $this->app->bind(AppClientUserInterface::class, AppClientUserRepository::class);
        $this->app->bind(ReferrerInterface::class, ReferrerRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
    }
}
