<?php

namespace App\Http\Controllers\BuyAuction;

use App\Http\Requests\BuyAuction\BuyAuctionRequest;
use App\Http\Resources\Nft\NftResource;
use App\Models\Nft;
use App\Models\AuctionBid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CompletedAuctionsController
{
    public function __invoke(Request $request)
    {
        // Получаем текущего пользователя
        $user = Auth::user();

        // Находим завершенные аукционы
        $completedAuctions = Nft::where('end_time', '<', Carbon::now())->get();

        foreach ($completedAuctions as $auction) {
            DB::transaction(function () use ($auction) {
                // Проверяем, есть ли пользователь, который сделал ставку
                if ($auction->current_bid_user_id) {
                    // Если есть ставка, обновляем статус на "pending_payment"
                    $auction->status = 'pending_payment';
                } else {
                    // Если ставок нет, статус "inactive"
                    $auction->status = 'inactive';
                }

                // Сохраняем изменения
                $auction->save();
            });
        }

        // Возвращаем аукционы, где текущий пользователь сделал ставку и они завершены
        $userAuctions = $completedAuctions->where('current_bid_user_id', $user->id);
        return NftResource::collection($userAuctions);
    }
}
