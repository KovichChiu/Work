<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public $timestamps = false;
    protected $table = 'ticket';
    protected $primaryKey = 't_id';

    public function getTicket($tid)
    {
        return $this->where("t_id", $tid)->first();
    }

    public function existsTicket($tid)
    {
        return $this->where("t_id", $tid)->exists();
    }
}
