<?php

namespace App\Http\Controllers\BuyAuction;

use App\Http\Requests\Buy\BuyRequest;
use App\Http\Requests\Nft\StoreRequest;
use App\Http\Resources\Nft\NftResource;
use App\Models\Nft;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IndexController
{
    public function __invoke()
    {
        $user = Auth::user();
        $nft = Nft::where('current_bid_user_id', $user->id)->where('owner_id', null)->get();
        return NftResource::collection($nft);
    }
}
