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
    public function index(Request $request)
    {
        $items = Item::all();

        return response()->json($items);
    }



    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Item $item)
    {
        $article = Item::find($item);

        return response()->json($article);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function cart(Request $request)
    {
        $cart = Auth::user()->items()->get();

        return response()->json($cart);
    }

    public function deleteArticle(Request $request, Item $item){

        $item->users()->detach(Auth::user());
    }

    public function ajoutArticle(Request $request, Item $item)
    {
        $item->users()->attach(Auth::user());
    }
}

