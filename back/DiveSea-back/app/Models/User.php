<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'img',
        'background',
        'nickname',
        'total_sales',
        'followers',
        'followings',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function nftsToApprove()
    {
        return $this->hasMany(ApproveNft::class, 'owner_id', 'id');
    }

    public function nfts()
    {
        return $this->hasMany(NFT::class, 'owner_id', 'id');
    }

    public function authorshipRequests()
    {
        return $this->hasMany(ApproveAuthorship::class, 'user_id', 'id');
    }

    public function bids()
    {
        return $this->hasMany(AuctionBid::class, 'user_id', 'id');
    }
}
