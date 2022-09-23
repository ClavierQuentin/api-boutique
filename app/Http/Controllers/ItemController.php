<?php

namespace App\Http\Controllers;


use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemUpdateRequest;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();

        return response()->json($items);
    }



    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $article = Item::find($item);

        return response()->json($article);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function cart()
    {
        $cart = Auth::user()->items()->get();
        $total = Auth::user()->items()->sum('price');

        return response()->json([$cart, 'total'=>$total]);
    }

    public function deleteArticle(Item $item, Request $request){

        $item->users()->detach(Auth::user());

        return response()->json('Article supprimé');
    }

    public function ajoutArticle(Item $item, Request $request)
    {
        $item->users()->attach($request->user());

        return response()->json('Article rajouté au panier');
    }
}

