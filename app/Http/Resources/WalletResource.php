<?php

namespace App\Http\Resources;

use App\Laravue\Models\Deposit_info;
use App\Laravue\Models\Spending;
use App\Laravue\Models\Withdrawal_info;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            'data' => [
                'id' => $this->id,
                'member_id' => $this->member_id,
                'balance' => $this->balance,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'deposit' => Deposit_info::whereIn('wallet_id', [$this->id])->get(),
            'withdraw' => Withdrawal_info::whereIn('wallet_id', [$this->id])->get(),
            'spending' => Spending::whereIn('wallet_id', [$this->id])->get(),
        ];
    }
}
