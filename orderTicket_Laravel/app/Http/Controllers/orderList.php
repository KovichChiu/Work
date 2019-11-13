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
            'tname',
            'tprice',
            'tcontent',
            'tid',
        ];
        $ticket = Ticket::all($arr);
        return $ticket;
    }
}
