<?php


namespace App\Services\WhitelabelCreator\Transformers\Contracts;


interface NewClientConfigTransformerInterface
{
    public function transform(array $input, $newId, array $data);
    public function transformPhone($phone);
}

