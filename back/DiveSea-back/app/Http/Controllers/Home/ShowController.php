<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nft\NftResource;
use App\Models\Author;
use App\Models\Nft;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke(Nft $nft)
    {
//        $nft = Nft::with(['author', 'owner'])->findOrFail($id);
//        $nft = Nft::find(1)->phone;
        $nft->load('author', 'owner');
        return new NftResource($nft);
    }
}
