<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';
    protected $connection = 'mysql';
    protected $fillable = [
        'name',
        'code',
        'referrer_id',
        'app_id',
        'page'
    ];
}
