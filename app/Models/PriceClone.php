<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PriceClone extends Model
{
    protected $table = 'price_clones';
    protected $connection = 'mysql';
    public $timestamps = false;
    public $fillable = [
        'id',
        'site_id',
        'parent_id',
    ];
}
