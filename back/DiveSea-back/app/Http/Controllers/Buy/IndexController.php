<?php

namespace App\Http\Controllers\Buy;

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

        $nft = Nft::where('owner_id', $user->id)->get();
//        $author = Author::with('nfts')->get();
        return NftResource::collection($nft);
    }
}
