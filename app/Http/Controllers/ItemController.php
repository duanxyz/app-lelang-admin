<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Laravue\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $itemQuery = Item::query();
        $limit = Arr::get($searchParams, 'limit');
        $category = Arr::get($searchParams, 'category', '');
        $keyword = Arr::get($searchParams, 'keyword', '');
        $status = Arr::get($searchParams, 'date', '');
        if (!empty($category)) {
            $itemQuery->where('category', 'LIKE', '%' . $category . '%');
        }

        if (!empty($keyword)) {
            $itemQuery->where('item_name', 'LIKE', '%' . $keyword . '%');
        }

        if (!empty($status)) {
            $itemQuery->where('auction_date', 'LIKE', '%' . $status . '%');
        }
        return itemResource::collection($itemQuery->paginate($limit));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        // $category = [
        //     "emas",
        //     "elektronik",
        //     "pertanian",
        //     "perikanan",
        //     "kendaraan",
        //     "sertifikat",
        // ];
        // $category = Item::all();
        // if(request()->input('pertanian')){
        //     $category->load('pertanian')
        // }

        // $category = $item->inpu

        // return new ItemResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
