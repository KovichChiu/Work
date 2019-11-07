<?php

namespace App\Http\Controllers;

use App\Order;

class orderShow extends Controller
{
    public function __invoke()
    {
        $order = Order::with('user', 'ticket')->orderBy('o_time', 'DESC')->get();
        return view('order', ['data' => $order]);
    }
}
