<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function validateOrder()
    {
        $itemsCart = Auth::user()->items()->get();
        if(count($itemsCart) == 0){
            return response()->json('Votre panier est vide');
        }
        $order = Order::create([
            "user_id" => Auth::user()->id,
            "date_order" => Date::now()
        ]);


        $total = Auth::user()->items()->sum('price');

        foreach($itemsCart as $item) {
            $order->items()->attach($item);
            $item->users()->detach(Auth::user());
        };

        $data = [
            'commande'=>$order,
            'items'=>$order->items()->get(),
            'total'=>$total
        ];

        Mail::to(Auth::user()->email)->send(new \App\Mail\OrderMail($data));

        Mail::to('clavier.quentin@gmail.com')->send(new \App\Mail\recapMail([
            'user'=>Auth::user(),
            'commande' =>$order,
            'total'=>$total
        ]));

        return response()->json([
            $order,
            $order->items()->get(),
            $total
        ]);
    }

    public function index(Request $request)
    {
        $order = $request->user()->orders()->with('items')->get();

        return response()->json($order);
    }
}
