<?php

namespace App\Http\Controllers;

use App\Order;

class orderShow extends Controller
{
    public function __invoke()
    {
        $order = new Order;
        return view('order', ['data' => $order->getOrder()]);
    }
}
