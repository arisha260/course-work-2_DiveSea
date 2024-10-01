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
        Schema::create('nfts', function (Blueprint $table) {
            $table->id();
            $table->string('img')->nullable();
            $table->string('title')->unique();
            $table->text('description');
            $table->integer('royalty');
//            $table->string('size');
//            $table->string('tags');
//            $table->boolean('put_on_sale');
//            $table->boolean('direct_sale');
            $table->string('sale_type');
            $table->decimal('currentBid')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('in_stock')->default(1);
            $table->timestamps();

            // Связь с таблицей authors
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');

            // Связь с таблицей users для владельцев
            $table->unsignedBigInteger('owner_id')->nullable(); // Владелец может быть null, если NFT еще не продано
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('set null');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nfts');
    }
};
