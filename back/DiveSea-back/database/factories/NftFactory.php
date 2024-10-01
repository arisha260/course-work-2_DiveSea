<?php

namespace Database\Factories;

use App\Models\Nft;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nft>
 */
class NftFactory extends Factory
{
    protected $model = Nft::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'img' => $this->faker->imageUrl(564, 560),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'royalty' => $this->faker->randomElement([0, 10, 20, 30, 40, 50]),
            'currentBid' => $this->faker->randomFloat(2, 1, 100),
            'price' => $this->faker->randomFloat(2, 100, 1000000),
            'in_stock' => str_pad($this->faker->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
//            'put_on_sale' => $this->faker->boolean(),
//            'direct_sale' => $this->faker->boolean(),
            'sale_type' => $this->faker->randomElement(['put_on_sale', 'direct_sale']),
            // Случайный автор из таблицы пользователей
            'author_id' => User::inRandomOrder()->first()->id,

            // Иногда назначаем владельца, а иногда оставляем NULL
            'owner_id' => $this->faker->boolean(70) ? User::inRandomOrder()->first()->id : null,
        ];
    }
}
