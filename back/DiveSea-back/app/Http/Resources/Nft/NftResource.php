<?php

namespace App\Http\Resources\Nft;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NftResource extends JsonResource
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
            'img' => $this->img
                ? (str_contains($this->img, 'http') ? $this->img : asset('storage/' . $this->img))
                : asset('images/default.png'), // Используем ссылку или загруженный файл
            'title' => $this->title,
            'description' => $this->description,
            'royalty' => $this->royalty,
//            'put_on_sale' => $this->put_on_sale,
//            'direct_sale' => $this->direct_sale,
            'sale_type' => $this->sale_type,
            'currentBid' => $this->currentBid,
            'in_stock' => $this->in_stock,
            'price' => $this->price,
            'author' => $this->author ? [
                'id' => $this->author->id,
                'img' => $this->author->img
                    ? (str_contains($this->author->img, 'http') ? $this->author->img : asset('storage/' . $this->author->img))
                    : asset('storage/users/avatars/default_user.png'),

                'background' => $this->author->background
                    ? (str_contains($this->author->background, 'http') ? $this->author->background : asset('storage/' . $this->author->background))
                    : asset('storage/users/background/basic.jpg'), // Используем ссылку или загруженный файл
                'name' => $this->author->name,
                'nickname' => $this->author->nickname,
                'email' => $this->author->email,
            ] : null,
            'owner' => $this->owner ? [
                'id' => $this->owner->id,
                'img' => $this->owner->img
                    ? (str_contains($this->owner->img, 'http') ? $this->owner->img : asset('storage/' . $this->owner->img))
                    : asset('storage/users/avatars/default_user.png'),

                'background' => $this->owner->background
                    ? (str_contains($this->owner->background, 'http') ? $this->owner->background : asset('storage/' . $this->owner->background))
                    : asset('storage/users/background/basic.jpg'), // Используем ссылку или загруженный файл
                'name' => $this->owner->name,
                'surname' => $this->owner->surname,
                'nickname' => $this->owner->nickname,
                'email' => $this->owner->email,
            ] : null,
            'end_time' => $this->end_time,
            'status'=> $this->status,
            'current_bid_user_id' => $this->currentBidUser ? [
                'id' => $this->currentBidUser->id,
                'img' => $this->currentBidUser->img
                    ? (str_contains($this->currentBidUser->img, 'http') ? $this->currentBidUser->img : asset('storage/' . $this->currentBidUser->img))
                    : asset('storage/users/avatars/default_user.png'),

                'background' => $this->currentBidUser->background
                    ? (str_contains($this->currentBidUser->background, 'http') ? $this->currentBidUser->background : asset('storage/' . $this->currentBidUser->background))
                    : asset('storage/users/background/basic.jpg'), // Используем ссылку или загруженный файл
                'name' => $this->currentBidUser->name,
                'surname' => $this->currentBidUser->surname,
                'nickname' => $this->currentBidUser->nickname,
                'email' => $this->currentBidUser->email,
            ] : null,

        ];

    }
}
