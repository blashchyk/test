<?php


namespace App\Services\WhitelabelCreator;

use App\Services\WhitelabelCreator\Contracts\{BladeCreatorInterface,
    ControlVersionManagerInterface,
    PartnerManagerInterface,
    WhitelabelCreatorManagerInterface};
use App\Services\WhitelabelCreator\Manager\{BladeCreator,
    ControlVersionManager,
    PartnerManager,
    WhitelabelCreatorManager};
use App\Services\WhitelabelCreator\Transformers\Contracts\NewClientConfigTransformerInterface;
use App\Services\WhitelabelCreator\Transformers\NewClientConfigTransformer;
use \Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->bind(WhitelabelCreatorManagerInterface::class, WhitelabelCreatorManager::class);
        $this->app->bind(NewClientConfigTransformerInterface::class, NewClientConfigTransformer::class);
        $this->app->bind(PartnerManagerInterface::class, PartnerManager::class);
        $this->app->bind(ControlVersionManagerInterface::class, ControlVersionManager::class);
        $this->app->bind(BladeCreatorInterface::class, BladeCreator::class);
    }
}

