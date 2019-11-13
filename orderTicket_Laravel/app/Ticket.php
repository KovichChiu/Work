<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'tid';

    public function getTicket($tid)
    {
        return $this->where("tid",'=', $tid)->first();
    }

    public function existsTicket($tid)
    {
        return $this->where("tid",'=', $tid)->exists();
    }
}
