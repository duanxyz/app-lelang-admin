<?php

namespace App\Http\Resources;

use App\Laravue\Models\Item;
use Illuminate\Http\Resources\Json\JsonResource;

class AuctionHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'item_id' => $this->item_id,
            'item_name' => Item::find($this->item_id)->item_name,
            'initial_price' => Item::find($this->item_id)->initial_price,
            'final_price' => $this->final_price,
            'auction_winner' => $this->auction_winner,
            'created_at' => $this->created_at,
        ];
    }
}
