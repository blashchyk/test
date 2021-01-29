<?php


namespace App\Services\WhitelabelCreator\Contracts;


interface WhitelabelCreatorManagerInterface
{
    public function createACloneOfTheSite($input): string;
}

