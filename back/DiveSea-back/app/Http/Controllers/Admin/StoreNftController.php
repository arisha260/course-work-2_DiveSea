<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApproveRequest;
use App\Models\Nft;
use App\Models\ApproveNft;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class StoreNftController extends Controller
{
    public function __invoke(ApproveRequest $request, $id)
    {
        Gate::authorize('create', Nft::class);  // Проверяем права на создание

        // Находим NFT в таблице ApproveNft
        $nftToApprove = ApproveNft::findOrFail($id);

        $data = $request->validated();

        if (isset($data['img'])) {
            $data['img'] = str_replace('http://localhost:8000/storage/', '', $data['img']); // Убираем базовый URL
        }

        if ($request->sale_type === 'put_on_sale') {
            $data['end_time'] = now()->addDays(2); // добавляем 48 часов
        }

        // Создаем запись в основной таблице Nft
        $nft = Nft::create($data);

        // Удаляем запись из таблицы ApproveNft
        $nftToApprove->delete();

        return response()->json($nft, 201);
    }
}
