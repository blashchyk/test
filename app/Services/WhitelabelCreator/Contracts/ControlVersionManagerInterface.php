<?php


namespace App\Services\WhitelabelCreator\Contracts;


interface ControlVersionManagerInterface
{
    public function createNewPullRequest($input);
    public function show($directory);
    public function createRull($input);
}
