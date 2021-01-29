<?php


namespace App\Repositories;


use App\Models\OauthClients;
use App\Repositories\Contracts\OauthClientsInterface;
use Illuminate\Support\Str;

class OauthClientsRepository implements OauthClientsInterface
{
    protected $model = OauthClients::class;

    public function get(int $projectId): OauthClients
    {
        return $this->model::where('new_id', $projectId)->first();
    }

    public function createNewProject(int $projectId, string $name, string $codename, $key): OauthClients
    {
        return $this->model::create([
            'id' => $projectId,
            'secret' => Str::random(39),
            'name' => $name,
            'new_id' => $projectId,
            'codename' => strtoupper($codename),
            'user_id' => '',
            'parent_id' => $key
        ]);
    }

    public function getAbbreviationBySiteName(string $siteName) : string
    {
        return $this->model::where('name', $siteName)->first()->codename;
    }
}

