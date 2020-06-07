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
            'user' => User::find($this->user_id),
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'status' => $this->status,
            'saldo' => Wallet::find($this->id),
            'created_at' => $this->created_at,
            'avatar' => 'https://i.pravatar.cc',
        ];
    }
}
