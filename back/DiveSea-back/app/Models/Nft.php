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
}
