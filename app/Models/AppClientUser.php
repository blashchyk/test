<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AppClientUser extends Model
{
    protected $table = 'app_client_user';
    protected $connection = 'mysql';
    public $timestamps = false;
    public $fillable = [
        'app_client_id',
        'user_id',
    ];
}
