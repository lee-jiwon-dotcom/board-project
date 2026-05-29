<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();                                              // 댓글 ID
            $table->foreignId('post_id')                               // 어떤 게시글의 댓글?
                  ->constrained()
                  ->onDelete('cascade');                                // 게시글 삭제 시 댓글도 삭제
            $table->foreignId('user_id')                               // 작성자
                  ->constrained()
                  ->onDelete('cascade');                                // 회원 탈퇴 시 댓글도 삭제
            $table->text('content');                                   // 댓글 내용
            $table->timestamps();                                      // 작성일, 수정일
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};