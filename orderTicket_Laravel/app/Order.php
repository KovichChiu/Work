<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Order extends Model
{
    public $timestamps = false;
    protected $table = 'order';
    protected $primaryKey = 'o_id';

    /**
     * 算出關聯
     */
    public function getOrder()
    {
        return $this->with('user', 'ticket')->orderBy('o_time', 'DESC')->get();
    }

    public function addOrder($orderingNO, $time, $u_id, $tid, $tpic)
    {
        $this->o_no = $orderingNO;
        $this->o_time = $time;
        $this->o_uid = $u_id;
        $this->o_tid = $tid;
        $this->o_tpics = $tpic;
        return $this->save();
    }

    public function user()
    {
        $uid = Session::get('u_id');
        return $this->belongsTo('App\User', 'o_uid', 'u_id')
                    ->where('u_id', '=', $uid);
    }

    public function ticket()
    {
        return $this->belongsTo('App\Ticket', 'o_tid', 't_id');
    }
}
