<?php


namespace App\Models;

use App\Models\AbstractModels\MongoConfig;

class ClientConfig extends MongoConfig
{
    protected $doc_index = 'clients';
}
