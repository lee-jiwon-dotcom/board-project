<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentLikeController extends Controller
{
    public function toggle(Comment $comment)
    {
        $user = Auth::user();
        
        $like = $comment->likes()->where('user_id', $user->id)->first();
        
        if ($like) {
            $like->delete();
        } else {
            $comment->likes()->create([
                'user_id' => $user->id,
            ]);
        }
        
        return back();
    }
}