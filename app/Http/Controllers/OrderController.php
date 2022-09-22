<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;

class OrderController extends Controller
{

    public function validateOrder()
    {
        $order = Order::create([
            "user_id" => Auth::user()->id,
            "date_order" => Date::now()
        ]);
        $itemsCart = Auth::user()->items()->get();
        $total = Auth::user()->items()->sum('price');

        foreach($itemsCart as $item) {
            $order->items()->attach($item);
            $item->users()->detach(Auth::user());
        };
    }

    public function index(Request $request)
    {
        $order = Auth::user()->orders()->with('items')->get();

        return response()->json($order);
    }
}
