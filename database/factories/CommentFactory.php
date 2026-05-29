<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'post_id' => Post::inRandomOrder()->first()?->id ?? Post::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'content' => fake()->paragraph(rand(1, 3)),
        ];
    }
}