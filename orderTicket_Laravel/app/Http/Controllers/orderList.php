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
        $ticket = Ticket::all();
        return $ticket;
    }
}
