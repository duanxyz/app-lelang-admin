<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $guarded = [];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function withdraw()
    {
        return $this->hasMany(Withdrawal_info::class);
    }

    public function deposit()
    {
        return $this->hasMany(Deposit_info::class);
    }

    public function spending()
    {
        return $this->hasMany(Spending::class);
    }

    public function history()
    {
        return $this->hasMany(Balance_history::class);
    }
}
