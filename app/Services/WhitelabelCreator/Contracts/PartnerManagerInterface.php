<?php


namespace App\Services\WhitelabelCreator\Contracts;


interface PartnerManagerInterface
{
    public function run($webmasterEmail, $whiteLabelId);
}
