<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nft\NftResource;
use App\Models\Author;
use App\Models\Nft;
use Illuminate\Http\Request;

class LoadMoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = $request->query('page', 1); // Получаем текущую страницу
        $limit = 10;
        $nfts = Nft::skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        // Формируем ответ с использованием ресурса
        $nextPage = Nft::count() > $page * $limit ? $page + 1 : null;  //Проверка наличия следующей страницы

        return response()->json([
            'data' => NftResource::collection($nfts),
            'nextPage' => $nextPage,
        ]);
    }
}
