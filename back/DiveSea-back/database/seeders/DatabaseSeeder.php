<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Сначала создаем пользователей
        $this->call(UserSeeder::class);

        // Затем создаем NFT
        $this->call(NftSeeder::class);
    }
}
