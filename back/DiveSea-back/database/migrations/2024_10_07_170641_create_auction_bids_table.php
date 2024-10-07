<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('auction_bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nft_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('bid_amount', 10, 2); // Сумма ставки
            $table->timestamps();

            // Внешний ключ на таблицу NFT
            $table->foreign('nft_id')->references('id')->on('nfts')->onDelete('cascade');

            // Внешний ключ на таблицу пользователей
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auction_bids');
    }
};
