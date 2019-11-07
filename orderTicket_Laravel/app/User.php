<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;
    protected $table = 'u_account';
    protected $primaryKey = 'u_acc';

    public function order()
    {
        return $this->hasMany('App\Order', 'o_uid', 'u_id');
    }
}
