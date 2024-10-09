<?php

namespace App\Http\Controllers\BuyAuction;

use App\Http\Requests\BuyAuction\BuyAuctionRequest;
use App\Models\Nft;
use App\Models\AuctionBid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class MakeAuctionBidController
{
    public function __invoke($id, BuyAuctionRequest $request)
    {
        // Получаем текущего пользователя
        $user = Auth::user();

        // Находим NFT
        $nft = Nft::findOrFail($id);

        // Авторизация пользователя на совершение действия
        Gate::authorize('buyAuction', $nft);

        // Проверяем, что текущий пользователь не является автором последней ставки
        if ($nft->current_bid_user_id === $user->id) {
            return response()->json(['error' => 'You have already placed your last bet!'], 400);
        }

        // Проверяем, достаточно ли у пользователя баланса
        if ($user->balance < $nft->price) {
            return response()->json(['error' => 'Top up your balance!'], 400);
        }

        // Проверяем, что ставка пользователя превышает текущую цену хотя бы на шаг (например, на 100)
        $minimumBid = $nft->price + 100; // Минимальный шаг 100
        if ($request->input('bid') < $minimumBid) {
            return response()->json(['error' => 'The bid must be at least ' . $minimumBid], 400);
        }

        // Проверяем, что пользователь делает ставку не превышающую его баланс
        if ($user->balance < $request->input('bid')) {
            return response()->json(['error' => 'There are not enough funds on the balance!'], 400);
        }

        // Обновляем NFT: новый пользователь, новая ставка
        DB::transaction(function () use ($user, $nft, $request) {
            // Обновляем NFT
            $nft->current_bid_user_id = $user->id;
            $nft->currentBid = $request->input('bid');
            $nft->price = $nft->currentBid;
            $nft->save();

            // Создаём запись в таблице auction_bids
            AuctionBid::create([
                'user_id' => $user->id,
                'nft_id' => $nft->id,
                'bid_amount' => $nft->currentBid,
            ]);
        });

        return response()->json(['message' => 'Ставка принята', 'nft' => $nft], 201);
    }
}
