<?php

namespace App\Http\Resources\BuyAuction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActionBitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nft_id' => $this->nft_id,
            'user' => $this->author ? [
                'id' => $this->author->id,
                'img' => $this->author->img,
                'name' => $this->author->name,
                'nickname' => $this->author->nickname,
                'email' => $this->author->email,
            ] : null,
            'nft' => $this->nft ? [
                'id' => $this->nft->id,
                'title' => $this->nft,
                'sale_type' => $this->nft,
                'price' => $this->nft,
            ] : null,
            'bid_amount' => $this->bid_amount,
        ];

    }
}
