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
        Schema::create('posts', function (Blueprint $table) {
         $table->id();                                           // 게시글 ID (자동 증가)
            $table->foreignId('user_id')                               // 작성자 ID
                  ->constrained()                               // users 테이블의 id 참조
                  ->onDelete('cascade');                     // 회원 탈퇴 시 게시글도 삭제
            $table->string('title', 200);                       // 제목 (200자 제한)
            $table->text('content');                                   // 본문 (긴 텍스트)
            $table->unsignedInteger('view_count')->default(0);       // 조회수 (기본값 0)
            $table->timestamps();                            // created_at, updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
