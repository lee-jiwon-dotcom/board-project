<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $user = Auth::user();
        
        // 이미 좋아요 했는지 확인
        $like = $post->likes()->where('user_id', $user->id)->first();
        
        if ($like) {
            // 이미 좋아요 했으면 삭제 (취소)
            $like->delete();
            $liked = false;
        } else {
            // 아직 안 했으면 추가
            $post->likes()->create([
                'user_id' => $user->id,
            ]);
            $liked = true;
        }
        
        // 좋아요 총 개수
        $likeCount = $post->likes()->count();
        
        return back()->with([
            'liked' => $liked,
            'likeCount' => $likeCount,
        ]);
    }
}