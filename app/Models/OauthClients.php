<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OauthClients extends Model
{
    const SPEEDYPAPER_CODE = 4;
    const PAPERCOACH_CODE = 5;
    const WRITEPAPER_FOR_ME = 25;
    const RESUME_101_ORG = 32;

    protected $table = 'oauth_clients';
    protected $connection = 'mysql';
    public $fillable = [
        'id',
        'secret',
        'name',
        'user_id',
        'new_id',
        'codename',
        'parent_id'
    ];
}
