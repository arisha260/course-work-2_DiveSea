<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nft\AuthorResource;
use App\Http\Resources\Nft\NftResource;
use App\Models\Author;
use App\Models\Nft;
use Illuminate\Http\Request;

class ShowAuthorController extends Controller
{
    public function __invoke(Author $author)
    {
        // Загружаем автора с его работами (NFT)
        $author = Author::with('nfts')->findOrFail($author->id);

        // Возвращаем ресурс автора
        return new AuthorResource($author);
    }
}

