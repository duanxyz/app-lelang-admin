<?php

namespace App\Http\Resources;

use App\Laravue\Models\Deposit_info;
use App\Laravue\Models\Member;
use App\Laravue\Models\Wallet;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositInfoResource extends JsonResource
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
            'user' => Member::find($this->wallet_id),
            'saldo' => Wallet::find($this->wallet_id)->balance,
            'deposit' => parent::toArray($request),
        ];
    }
}
