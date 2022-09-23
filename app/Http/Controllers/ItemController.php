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
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\ItemStoreRequest  $request
    * @return \Illuminate\Http\Response
    */
    public function store(ItemStoreRequest $request)
    {
        $item = Item::create($request->except('_token'));
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
    * Update the specified resource in storage.
    *
    * @param \App\Http\Requests\Request $request
    * @param \App\Models\item $item
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Item $item)
    {
        $item->update($request->except('_token'));
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
        $item->users()->attach(Auth::user());

        return response()->json('Article rajouté au panier');
    }
}

