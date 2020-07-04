<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuctionResource;
use App\Laravue\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Notifications\Action;
use Illuminate\Support\Arr;

use function GuzzleHttp\Promise\all;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Auction $auction)
    {
        $params = $request->all();
        $auctionQuery = Auction::query();
        $limit = Arr::get($params, 'limit');
        $auctionQuery->where('item_id', $params['item_id'])->limit(5)->get();
        // return AuctionResource::collection($auction->where('item_id', $params['item_id'])->get()->sortByDesc('created_at')->pagination($limit));
        return AuctionResource::collection($auctionQuery->orderBy('offer', 'desc')->paginate($limit));
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
    public function store(Request $request, Auction $auction)
    {
        $create = $auction->create($request->all());

        return new AuctionResource($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function show(auction $auction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function edit(auction $auction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, auction $auction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function destroy(auction $auction)
    {
        //
    }
}
