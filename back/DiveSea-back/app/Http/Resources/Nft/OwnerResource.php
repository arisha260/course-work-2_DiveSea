<?php

namespace App\Http\Resources\Nft;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerResource extends JsonResource
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
            'surname' => $this->surname,
            'nickname' => $this->nickname,
            'email' => $this->email,
        ];
    }
}
