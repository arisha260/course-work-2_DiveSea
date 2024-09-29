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
        'put_on_sale',
        'direct_sale',
        'currentBid',
        'in_stock',
        'author_id',
        'img',
    ];

    // Связь с автором (один к одному)
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    // Связь с владельцем (один к одному)
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }
}
