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
//        'put_on_sale',
//        'direct_sale',
        'sale_type',
        'currentBid',
        'in_stock',
        'author_id',
        'img',
        'price',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    // Связь с владельцем (один к одному)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
