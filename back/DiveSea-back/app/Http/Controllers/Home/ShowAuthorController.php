<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nft\UserResource;
use App\Http\Resources\Nft\NftResource;
use App\Models\Author;
use App\Models\Nft;
use App\Models\User;
use Illuminate\Http\Request;

class ShowAuthorController extends Controller
{
    public function __invoke(User $author)
    {
        // Загружаем автора с его работами (NFT)
        $author = User::with('nfts')->findOrFail($author->id);

        // Возвращаем ресурс автора
        return new UserResource($author);
    }
}

