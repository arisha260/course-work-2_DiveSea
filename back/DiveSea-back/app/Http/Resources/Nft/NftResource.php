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
//        return[
//            'id' => $this->id,
//            'img' => $this->img,
//            'title' => $this->title,
//            'currentBid' => $this->currentBid,
//            'price' => $this->price,
////            'author_id' => new AuthorResource($this->whenLoaded('author_id')), // Используем Eager Loaded данные
////            'owner_id' => new OwnerResource($this->whenLoaded('owner_id')),   // Используем Eager Loaded данные
//            'author_id' => $this->author_id,
//            'owner_id' => $this->owner_id,
//        ];
        return [
            'id' => $this->id,
            'img' => $this->img,
            'title' => $this->title,
            'description' => $this->description,
            'royalty' => $this->royalty,
            'put_on_sale' => $this->put_on_sale,
            'direct_sale' => $this->direct_sale,
            'currentBid' => $this->currentBid,
            'in_stock' => $this->in_stock,
            'author' => $this->author ? [
                'id' => $this->author->id,
                'img' => $this->author->img,
                'name' => $this->author->name,
                'surname' => $this->author->surname,
                'nickname' => $this->author->nickname,
                'email' => $this->author->email,
            ] : null,
            'owner' => $this->owner ? [
                'id' => $this->owner->id,
                'img' => $this->owner->img,
                'name' => $this->owner->name,
                'surname' => $this->owner->surname,
                'nickname' => $this->owner->nickname,
                'email' => $this->owner->email,
            ] : null,
        ];

    }
}
