<?php


namespace App\Models;


use App\Models\AbstractModels\MongoConfig;

class WhitelistedReferrersIds extends MongoConfig
{
    protected string $doc_index = 'whitelisted_referrers_ids';
}

