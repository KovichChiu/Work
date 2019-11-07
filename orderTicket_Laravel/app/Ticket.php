<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public $timestamps = false;
    protected $table = 'ticket';
    protected $primaryKey = 't_id';

    public function order()
    {
        return $this->hasMany('App\Order', 'o_tid', 't_id');
    }
}
