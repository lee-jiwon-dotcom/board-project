<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * 대량 할당 가능한 컬럼
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    /**
     * 댓글은 한 게시글에 속함
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * 댓글은 한 유저에 속함
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

        // 댓글의 좋아요들
    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }

    // 특정 사용자가 이 댓글에 좋아요 했는지
    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}