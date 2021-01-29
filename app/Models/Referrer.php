<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Referrer extends Model
{
    const TYPE_WEBMASTER_TRAFIC = 1;

    protected $table = 'referrers';
    protected $connection = 'mysql';
    protected $fillable = [
        'id',
        'user_id',
        'referrer_type_id',
        'sales_percent',
        'rebills_percent'
    ];
}
