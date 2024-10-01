<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'img' => $this->faker->imageUrl(67, 67,),
            'name' => fake()->name(),
            'nickname' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'total_sales' => $this->faker->numberBetween(0, 1000), // Генерируем число от 0 до 1000
            'followers' => $this->faker->numberBetween(0, 10000), // Генерируем число от 0 до 10000
            'followings' => $this->faker->numberBetween(0, 5000),
            'bio' => $this->faker->paragraph,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
