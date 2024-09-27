<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $guarded = false;

    // Связь один ко многим с NFT
    public function nfts()
    {
        return $this->hasMany(NFT::class, 'author_id', 'id');
    }
}
