<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class approveNft extends Model
{
    use HasFactory;
    protected $guarded = false;
    protected $fillable = [
        'title',
        'description',
        'royalty',
        'put_on_sale',
        'direct_sale',
        'currentBid',
        'in_stock',
        'author_id',
        'img',
        'price',
    ];
}
