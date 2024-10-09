<?php

namespace App\Console\Commands;

use App\Models\Nft;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CloseAuctions extends Command
{
    protected $signature = 'auction:close';
    protected $description = 'Close auctions and assign winners when auction ends';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Получаем все активные аукционы, которые должны завершиться
        $expiredAuctions = NFT::where('sale_type', 'auction')
            ->where('status', 'open')
            ->where('end_time', '<', Carbon::now())
            ->get();

        foreach ($expiredAuctions as $auction) {
            // Проверяем, есть ли победитель (например, current_bid_user_id не null)
            if ($auction->current_bid_user_id) {
                // Имитируем списание денег с победителя
                $winner = $auction->currentBidUser; // предполагаем, что у тебя есть связь между NFT и пользователем

                if ($winner->balance >= $auction->price) {
                    $winner->balance -= $auction->price; // уменьшаем баланс
                    $winner->save();

                    // Назначаем владельцем NFT победителя
                    $auction->owner_id = $auction->current_bid_user_id;
                    $auction->status = 'sold'; // статус меняется на "продано"
                    $auction->save();
                } else {
                    // Если средств недостаточно, можно отменить покупку или передать право следующему
                }
            }
        }

        return Command::SUCCESS;
    }
}
