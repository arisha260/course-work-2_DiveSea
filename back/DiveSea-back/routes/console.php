<?php

use App\Models\Nft;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Планируем задачу для обновления статуса аукционов каждый час
Artisan::command('auctions:update-status', function () {
    // Обновляем аукционы, у которых истекло время
    Nft::where('end_time', '<', Carbon::now())
        ->where('status', 'active') // Обновляем только активные аукционы
        ->update(['status' => 'completed']); // Устанавливаем статус завершено

    $this->info('Auction statuses have been updated.');
})->purpose('Update auction statuses')->hourly(); // Выполняем каждый час
