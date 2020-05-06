<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit_info extends Model
{
    protected $guarded = [];

    public function wallet()
    {
        return $this->belongsToMany(Wallet::class);
    }
}
