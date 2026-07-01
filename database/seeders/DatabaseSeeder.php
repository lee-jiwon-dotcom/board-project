<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 카테고리 먼저! (노을/사람)
        $this->call(CategorySeeder::class);

        // 로그인용 테스트 유저 하나
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 가짜 게시글/댓글은 갤러리엔 안 맞으니 잠시 꺼둠
        // Post::factory(30)->create();
        // Comment::factory(100)->create();
    }
}