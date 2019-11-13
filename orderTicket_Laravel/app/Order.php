<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Order extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'oid';

    /**
     * 算出關聯
     */
    public function getOrder()
    {
        $uid = Session::get('uid');
        return $this->with('user', 'ticket')->where('uid', $uid)->orderBy('otime', 'DESC')->get();
    }

    public function addOrder($tid)
    {
        $uid = Session::get('uid');
        $this->otime = time();
        $this->oid = $this->makeOrderID($this->otime, $uid);
        $this->uid = $uid;
        $this->tid = $tid;
        $this->opics = 1;
        return $this->save();
    }

    public function user()
    {
        $uid = Session::get('uid');
        return $this->belongsTo('App\User', 'uid', 'uid')->where('users.uid', $uid);
    }

    public function ticket()
    {
        return $this->belongsTo('App\Ticket', 'tid', 'tid');
    }

    protected function makeOrderID($time, $uid)
    {
        $stamp = $time . $uid;
        return hash("sha1", $stamp);
    }
}
