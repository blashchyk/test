<?php


namespace App\Repositories\Contracts;


interface AppClientUserInterface
{
    public function add(int $whiteLabelId, int $webmasterId);
}
