<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function create($user_id,$paper_id,$mac,$profit,$method="daily")
    {
        Order::create([
            'user_id' => $user_id,
            'paper_id' => $paper_id,
            'mac' => $mac,
            'method' => $method,
            '$profit' =>$profit
        ]);
    }
}
