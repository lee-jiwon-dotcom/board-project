<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    /**
     * 댓글 저장
     */
    public function store(Request $request, Post $post): RedirectResponse
    {
        // 1. 유효성 검사
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // 2. 현재 로그인한 유저의 댓글로 저장
        $post->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $validated['content'],
        ]);

        // 3. 게시글 상세로 돌아가기
        return redirect()->route('posts.show', $post)
                         ->with('success', '댓글이 작성되었습니다!');
    }

    /**
     * 댓글 삭제
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        // 권한 체크
        $this->authorize('delete', $comment);

        $postId = $comment->post_id;
        $comment->delete();

        return redirect()->route('posts.show', $postId)
                         ->with('success', '댓글이 삭제되었습니다!');
    }
}