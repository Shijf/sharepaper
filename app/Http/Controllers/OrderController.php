<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function create($user_id,$paper_id,$mac,$proxy_id,$profit,$method="daily")
    {
        Order::create([
            'user_id' => $user_id,
            'paper_id' => $paper_id,
            'proxy_id' => $proxy_id,
            'mac' => $mac,
            'method' => $method,
            'profit' =>$profit
        ]);
    }
}
