<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'title' => fake()->sentence(rand(3, 8)),
            'content' => fake()->paragraphs(rand(3, 7), true),
            'view_count' => rand(0, 500),
        ];
    }
}