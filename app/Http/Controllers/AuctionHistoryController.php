<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuctionHistoryResource;
use App\Laravue\Models\Auction_history;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AuctionHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $resultQuery = Auction_history::query();
        $limit = Arr::get($searchParams, 'limit');
        $keyword = Arr::get($searchParams, 'keyword', '');
        $category = Arr::get($searchParams, 'category', '');
        $year = Arr::get($searchParams, 'year', '');

        if (!empty($keyword)) {
            $resultQuery->join('items', 'auction_histories.item_id', '=', 'items.id')
                ->select('auction_histories.*')
                ->where('item_name', 'LIKE', '%' . $keyword . '%');
        }
        if (!empty($category)) {
            $resultQuery->join('items', 'auction_histories.item_id', '=', 'items.id')
                ->where('category', $category);
        }
        if (!empty($year)) {
            $resultQuery->where('auction_histories.updated_at', 'LIKE', '%' . $year . '%');
        }
        $resultQuery->orderBy('auction_histories.created_at', 'desc');

        return AuctionHistoryResource::collection($resultQuery->paginate($limit));
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
     * @param  \App\Laravue\Models\auction_history  $auction_history
     * @return \Illuminate\Http\Response
     */
    public function show(auction_history $auction_history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\auction_history  $auction_history
     * @return \Illuminate\Http\Response
     */
    public function edit(auction_history $auction_history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\auction_history  $auction_history
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, auction_history $auction_history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\auction_history  $auction_history
     * @return \Illuminate\Http\Response
     */
    public function destroy(auction_history $auction_history)
    {
        //
    }
}
