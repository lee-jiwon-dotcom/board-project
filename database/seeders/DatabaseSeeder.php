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
        // 1. 테스트 유저 5명 생성
        User::factory(5)->create();
        
        // 2. 게시글 30개 생성 (랜덤 작성자)
        Post::factory(30)->create();
        
        // 3. 댓글 100개 생성 (랜덤 작성자, 랜덤 게시글)
        Comment::factory(100)->create();
        
        // 4. 특정 테스트 유저 만들기 (선택)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}