<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nft extends Model
{
    use HasFactory;
    protected $guarded = false;
    protected $fillable = [
        'title',
        'description',
        'royalty',
//        'put_on_sale',
//        'direct_sale',
        'sale_type',
        'currentBid',
        'price',
        'in_stock',
        'author_id',
        'img',
        'end_time',
        'balance',
        'status',
        'current_bid_user',
    ];

    // Связь с автором (один к одному)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function currentBidUser()
    {
        return $this->belongsTo(User::class, 'current_bid_user_id', 'id');
    }

    public function bids()
    {
        return $this->hasMany(AuctionBid::class, 'nft_id', 'id');
    }
}
