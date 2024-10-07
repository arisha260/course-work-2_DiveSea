<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionBid extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $fillable = [
        'nft_id',
        'user_id',
        'bid_amount',
    ];

    // Связь с таблицей NFT
    public function nft()
    {
        return $this->belongsTo(Nft::class, 'nft_id', 'id');
    }

    // Связь с таблицей Users (кто сделал ставку)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
