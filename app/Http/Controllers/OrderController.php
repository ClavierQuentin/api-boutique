<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;

class OrderController extends Controller
{

    public function store(OrderStoreRequest $request)
    {
        $order = Order::create([
            "id_user" => auth()->user()->id,
            "date_order" => Date::now()
        ]);
    }

}
