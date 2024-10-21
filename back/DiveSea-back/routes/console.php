<?php

use App\Events\AuctionStatusUpdated;
use App\Models\Nft;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Планируем задачу для обновления статуса аукционов каждый час
Artisan::command('auctions:update-status', function () {
    // Находим аукционы, у которых истекло время и которые еще активны
    $completedAuctions = Nft::where('end_time', '<', Carbon::now())
        ->where('status', 'active') // Только активные аукционы
        ->get();

    // Обрабатываем каждый аукцион
    foreach ($completedAuctions as $auction) {
        DB::transaction(function () use ($auction) {
            // Проверяем, есть ли ставка (current_bid_user_id)
            if ($auction->current_bid_user_id) {
                // Если есть ставка, обновляем статус на "pending_payment"
                $auction->status = 'pending_payment';
            } else {
                // Если ставок нет, меняем статус на "inactive"
                $auction->status = 'inactive';
            }

            // Сохраняем изменения
            $auction->save();
        });
    }

    // Выводим сообщение о завершении обновления
    $this->info('Auction statuses have been updated.');
})->purpose('Update auction statuses based on bids')->everyMinute()->timezone('Europe/Moscow');
