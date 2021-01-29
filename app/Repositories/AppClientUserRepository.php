<?php


namespace App\Repositories;


use App\Models\AppClientUser;
use App\Models\OauthClients;
use App\Repositories\Contracts\AppClientUserInterface;

class AppClientUserRepository implements AppClientUserInterface
{
    protected $model = AppClientUser::class;

    public function add($whiteLabelId, $webmasterId)
    {
        $this->model::insert([
            ['app_client_id' => $whiteLabelId, 'user_id' => $webmasterId],
            ['app_client_id' => OauthClients::SPEEDYPAPER_CODE, 'user_id' => $webmasterId],
            ['app_client_id' => OauthClients::PAPERCOACH_CODE, 'user_id' => $webmasterId],
            ['app_client_id' => OauthClients::WRITEPAPER_FOR_ME, 'user_id' => $webmasterId],
            ['app_client_id' => OauthClients::RESUME_101_ORG, 'user_id' => $webmasterId],
        ]);
    }
}
