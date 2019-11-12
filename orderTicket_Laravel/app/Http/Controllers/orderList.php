<?php

namespace App\Http\Controllers;

use App\Ticket;

class orderList extends Controller
{
    public function __invoke()
    {
        return view('buyPages', ['data' => $this->getData()]);
    }

    protected function getData()
    {
        $arr = [
            't_name',
            't_price',
            't_content',
            't_id',
        ];
        $ticket = Ticket::all($arr);
        return $ticket;
    }
}
