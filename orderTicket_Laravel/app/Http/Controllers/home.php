<?php

namespace App\Http\Controllers;

use App\Ticket;

class home extends Controller
{
    public function __invoke()
    {
        return view('home', ['data' => $this->getData()]);
    }

    protected function getData()
    {
        $arr = [
            'tname',
            'tcontent',
        ];
        $ticket = Ticket::all($arr);
        return $ticket;
    }
}
