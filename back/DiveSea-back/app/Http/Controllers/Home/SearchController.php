<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nft\AuthorResource;
use App\Http\Resources\Nft\NftResource;
use App\Models\Author;
use App\Models\Nft;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('query');

        // Поиск по NFT
        $nfts = NFT::where('title', 'like', "%$query%")->limit(5)->get();

        // Поиск по авторам
        $authors = Author::where('name', 'like', "%$query%")->limit(5)->get();

        // Возвращаем объединенные результаты
        return response()->json([
            'nfts' => $nfts,
            'authors' => $authors,
        ]);
    }
}
