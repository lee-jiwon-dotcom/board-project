<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * 게시글 목록 보기 - 누구나 가능 (로그인만 했으면)
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * 게시글 상세 보기 - 누구나 가능
     */
    public function view(User $user, Post $post): bool
    {
        return true;
    }

    /**
     * 게시글 작성 - 로그인한 사람 누구나
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * 게시글 수정 - 작성자 본인만!
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * 게시글 삭제 - 작성자 본인만!
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}