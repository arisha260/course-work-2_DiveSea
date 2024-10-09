<?php

namespace App\Jobs;

use App\Models\Nft;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CloseAuctionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        // Конструктор оставляем пустым, если не передаем параметры в Job
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Получаем все активные аукционы, где время истекло
        $now = Carbon::now();

        $expiredAuctions = Nft::where('sale_type', 'put_on_sale')
            ->where('end_time', '<=', $now)
            ->whereNotNull('current_bid_user_id') // Только если есть победитель
            ->get();

        foreach ($expiredAuctions as $nft) {
            DB::transaction(function () use ($nft) {
                $winner = User::find($nft->current_bid_user_id);

                // Проверяем, есть ли у победителя достаточно средств
                if ($winner->balance >= $nft->currentBid) {
                    // Списываем средства
                    $winner->balance -= $nft->currentBid;
                    $winner->save();

                    // Переносим NFT к новому владельцу
                    $nft->owner_id = $winner->id;
                    $nft->save();

                    // Опционально: логика для передачи роялти автору
                    $author = $nft->author;
                    if ($author) {
                        $royaltyAmount = $nft->currentBid * ($nft->royalty / 100);
                        $author->balance += $royaltyAmount;
                        $author->save();
                    }
                } else {
                    // Если средств недостаточно, можно реализовать возврат NFT на аукцион или уведомление
                    // Пока просто логируем ошибку
                    \Log::warning('Недостаточно средств у пользователя для завершения аукциона', [
                        'user_id' => $winner->id,
                        'nft_id' => $nft->id,
                    ]);
                }
            });
        }
    }
}
