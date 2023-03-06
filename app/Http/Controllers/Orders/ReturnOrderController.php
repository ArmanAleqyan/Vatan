<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderTranzaction;

class ReturnOrderController extends Controller
{
    public function successOrder(Request $request){

        $get = OrderTranzaction::where('order_id', $request->orderId)->get();

            dd($get);
    }
}
