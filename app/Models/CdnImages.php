<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class CdnImages extends Model
{
    protected $collection = 'cdn_images';
    protected $connection = 'mongodb';
    protected $fillable = [
        'project_id',
        'images'
    ];
}
