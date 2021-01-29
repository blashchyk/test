<?php


namespace App\Repositories\Contracts;


interface MongoClientsInterface
{
    public function copy(int $id, array $input): int;
    public function updatePhone(int $id, string $phone);
    public function updateLiveChat(int $id, array $chat);
    public function updateEmail(int $id, string $email);
    public function setReferrer(int $id, int $linkId, int $referrerId);
}

