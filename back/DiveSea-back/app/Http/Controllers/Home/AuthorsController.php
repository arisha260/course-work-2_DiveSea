<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nft\UserResource;
use App\Http\Resources\Nft\NftResource;
use App\Models\Author;
use App\Models\Nft;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function __invoke()
    {
        $author = User::where('role', 'author')->get();
//        $author = Author::with('nfts')->get();
        return UserResource::collection($author);
    }
}
