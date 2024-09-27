<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nft\NftResource;
use App\Models\Author;
use App\Models\Nft;
use Illuminate\Http\Request;

class AuthorWorksController extends Controller
{
    public function __invoke($authorId)
    {
        $nfts = Nft::where('author_id', $authorId)->get();
        return NftResource::collection($nfts);
    }
}
