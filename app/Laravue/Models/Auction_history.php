<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Auction_history extends Model
{
    protected $guarded = [];

    public function item()
    {
        return $this->belongsToMany(Item::class);
    }
}
