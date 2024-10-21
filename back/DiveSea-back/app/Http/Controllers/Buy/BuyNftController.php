<?php

namespace App\Http\Controllers\Buy;

use App\Http\Requests\Buy\BuyRequest;
use App\Http\Requests\Nft\StoreRequest;
use App\Http\Resources\Nft\NftResource;
use App\Models\Nft;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class BuyNftController
{
    public function __invoke($id)
    {
        // Получаем текущего пользователя
        $user = Auth::user();

        // Находим NFT
        $nft = Nft::findOrFail($id);

        // Авторизация пользователя на совершение действия
        Gate::authorize('buy', $nft);

        // Проверяем, достаточно ли у пользователя баланса
        if ($user->balance < $nft->price) {
            return response()->json(['error' => 'Top up your balance!'], 400);
        }
        // Выполняем покупку
        DB::transaction(function () use ($user, $nft) {
            // Снимаем средства с баланса
            $user->balance -= $nft->price;
            $user->save();

            $nft->status = 'sold';
            // Обновляем владельца NFT и статус
            $nft->owner_id = $user->id;
            $nft->save();
        });
        $nfts = Nft::all();
        return response()->json(['message' => 'Purchase successful', 'balance' => $user->balance, 'nfts' => NftResource::collection($nfts)]);
    }
}
