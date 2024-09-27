<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{

    protected $model = Author::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'img' => $this->faker->imageUrl(67, 67,),
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'nickname' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
