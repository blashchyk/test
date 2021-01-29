<?php


namespace App\Repositories\Contracts;


use App\Models\OauthClients;

interface OauthClientsInterface
{
    public function get(int $projectId): OauthClients;
    public function createNewProject(int $projectId, string $name, string $codename, int $key): OauthClients;
    public function getAbbreviationBySiteName(string $siteName): string;
}
