<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nft\AuthorResource;
use App\Http\Resources\Nft\NftResource;
use App\Models\Author;
use App\Models\Nft;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function __invoke()
    {
        $author = Author::all();
//        $author = Author::with('nfts')->get();
        return AuthorResource::collection($author);
    }
}
