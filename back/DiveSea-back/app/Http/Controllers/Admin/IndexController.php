<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nft\NftResource;
use App\Models\ApproveNft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function __invoke()
    {
        $nfts = ApproveNft::all();
        return NftResource::collection($nfts);
   }
}
