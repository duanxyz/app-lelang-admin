<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    public function auction()
    {
        return $this->hasMany(Auction::class);
    }

    public function auction_history()
    {
        return $this->hasMany(Auction_history::class);
    }
}
