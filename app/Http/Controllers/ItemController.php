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

        return response()->json($cart);
    }

    public function deleteArticle(Item $item){

        $item->users()->detach(Auth::user());
    }

    public function ajoutArticle(Item $item)
    {
        $item->users()->attach(Auth::user());
    }
}

