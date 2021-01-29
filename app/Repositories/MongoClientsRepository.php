<?php


namespace App\Repositories;


use App\Models\ClientConfig;
use App\Models\MongoConfig;
use App\Repositories\Contracts\MongoClientsInterface;
use App\Services\WhitelabelCreator\Transformers\Contracts\NewClientConfigTransformerInterface;


class MongoClientsRepository implements MongoClientsInterface
{
    protected $collection = ClientConfig::class;
    protected $mongoConfig;
    protected $newClientConfigTransformer;

    public function __construct(NewClientConfigTransformerInterface $newClientConfigTransformer)
    {
        $this->mongoConfig = new $this->collection;
        $this->newClientConfigTransformer = $newClientConfigTransformer;
    }

    private function getLastId()
    {
        $all = $this->mongoConfig->getAll();
        unset($all['defaults']);
        ksort($all);
        return collect($all)->last()['id'];
    }

    public function copy(int $id, $input): int
    {
        $newId = $this->getLastId() + 1;
        $base = $this->newClientConfigTransformer->transform($this->mongoConfig->get($id), $newId, $input);
        $this->mongoConfig->insert($newId, $base);
        return $newId;
    }

    public function updatePhone(int $id, $phone)
    {
        $contacts = $this->mongoConfig->get($id)['contacts'];
        $contacts['phone'] = $phone;
        $contacts['phone_formatted'] = $this->newClientConfigTransformer->transformPhone($phone);
        $this->mongoConfig->update($id, 'contacts', $contacts);
    }

    public function updateEmail(int $id, string $email)
    {
        $contacts = $this->mongoConfig->get($id)['contacts'];
        $contacts['email'] = $email;
        $this->mongoConfig->update($id, 'contacts', $contacts);
    }

    public function updateLiveChat(int $id, array $chat)
    {
        $this->mongoConfig->update($id, 'livechat_group_id', $chat);
    }

    public function setReferrer($id, $linkId, $referrerId)
    {
        $this->mongoConfig->update($id, 'link_id', $linkId);
        $this->mongoConfig->update($id, 'referrer_id', $referrerId);
    }
}
