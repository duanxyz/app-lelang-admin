<?php

namespace App\Http\Resources;

use App\Laravue\Models\User;
use App\Laravue\Models\Wallet;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'user_id' => User::find($this->user_id)->id,
            'username' => User::find($this->user_id)->username,
            'email' => User::find($this->user_id)->email,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'status' => $this->status,
            'wallet_id' => Wallet::find($this->id)->id,
            'saldo' => Wallet::find($this->id)->balance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'avatar' => 'https://i.pravatar.cc',
            'proof' => Wallet::find($this->id)->deposit()
                ->where('wallet_id', $this->id)
                ->where('status', 'not approved')->first(),
        ];
    }
}
