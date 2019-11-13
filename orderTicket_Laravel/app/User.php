<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'uid';

    public function checkLogin($acc, $pswd)
    {
        return $this->where('uacc', $acc)->where('upswd', $pswd)->first();
    }

    public function checkAccExists($uid)
    {
        return $this->where('uid', $uid)->exists();
    }

    public function addAccount($u_name, $u_acc, $u_pswd)
    {
        $this->uid = guid();
        $this->uname = $u_name;
        $this->uacc = $u_acc;
        $this->upswd = hash('sha512', $u_pswd);
        $this->save();
    }
}
