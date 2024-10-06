<?php

namespace App\Http\Resources\Nft;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'img' => $this->img,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'email' => $this->email,
            'total_sales' => $this->total_sales,
            'followers' => $this->followers,
            'followings' => $this->followings,
            'balance' => $this->balance,
            'bio' => $this->bio,
            'nfts' => NftResource::collection($this->whenLoaded('nfts')),
        ];
    }
}
