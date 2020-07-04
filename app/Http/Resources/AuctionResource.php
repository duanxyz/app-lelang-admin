<?php

namespace App\Http\Resources;

use App\Laravue\Models\Auction;
use Illuminate\Http\Resources\Json\JsonResource;

class AuctionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        //     'item_id' => $this->item_id,
        //     'offer' => $this->offer,
        //     'bidder_username' => $this->bidder_username,
        //     'price_now' => Auction::max('offer'),
        //     'created_at',
        // ];
    }
}
