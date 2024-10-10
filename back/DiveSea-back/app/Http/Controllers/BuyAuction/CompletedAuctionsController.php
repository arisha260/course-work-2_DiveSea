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

        // Находим завершенные аукционы, где пользователь делал ставки
        $completedAuctions = Nft::where('end_time', '<', Carbon::now())
            ->where('current_bid_user_id', $user->id)
            ->where('owner_id', null)
            ->get();

        // Возвращаем аукционы
        return NftResource::collection($completedAuctions);
    }
}
