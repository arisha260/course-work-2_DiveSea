<?php

namespace App\Http\Controllers\Buy;

use App\Http\Requests\Buy\BuyRequest;
use App\Http\Requests\Nft\StoreRequest;
use App\Models\Nft;
use Illuminate\Support\Facades\Auth;
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
        Gate::authorize('update', $user);
        Gate::authorize('buy', $nft);

        // Проверяем, достаточно ли у пользователя баланса
        if ($user->balance < $nft->price) {
            return response()->json(['error' => 'Top up your balance!'], 400);
        }
        // Выполняем покупку
        $user->balance -= $nft->price;
        $user->save();
        // Обновляем владельца NFT
        $nft->owner_id = $user->id;
        $nft->save();

        return response()->json(['message' => 'Purchase successful', 'balance' => $user->balance]);
    }
}
