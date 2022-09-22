<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function validateOrder()
    {
        $order = Order::create([
            "user_id" => Auth::user()->id,
            "date_order" => Date::now()
        ]);
        $itemsCart = Auth::user()->items()->get();
        foreach($itemsCart as $item) {
            $order->items()->attach($item);
            $item->users()->detach(Auth::user());
        };

    }
}
