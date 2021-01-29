<?php


namespace App\Services\WhitelabelCreator\Contracts;


interface BladeCreatorInterface
{
    public function copy($oldFiles, $input);
}
