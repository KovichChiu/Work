<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Order extends Model
{
    public $timestamps = false;
    protected $table = 'order';
    protected $primaryKey = 'o_id';

    public function user()
    {
        $uid = Session::get('u_id');
        return $this->belongsTo('App\User', 'o_uid', 'u_id')->where('u_id', '=', $uid);
    }

    public function ticket()
    {
        return $this->belongsTo('App\Ticket', 'o_tid', 't_id');
    }
}
