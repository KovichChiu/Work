<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;
    protected $table = 'u_account';
    protected $primaryKey = 'u_acc';

    public function checkLogin($acc){
        return $this->where('u_acc', '=', $acc)->first();
    }

    public function checkAccExists($acc)
    {
        return $this->where('u_acc', '=', $acc)->exists();
    }

    public function addAccount($u_id, $u_name, $u_acc, $u_pswd)
    {
        $this->u_id = $u_id;
        $this->u_name = $u_name;
        $this->u_acc = $u_acc;
        $this->u_pswd = hash('sha512', $u_pswd);
        $this->save();
    }
}
