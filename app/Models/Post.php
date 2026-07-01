<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;  // 👈 추가!
use Illuminate\Database\Eloquent\Builder;  // 👈 추가!


class Post extends Model
{
    use HasFactory;

    /**
     * 대량 할당 가능한 컬럼들 (보안)
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'category_id',
    ];

    /**
     * 작성자(User)와의 관계 설정
     * 게시글 N개는 → 1명의 User에 속함
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

     /**
     * 👇 새로 추가! 게시글의 댓글들
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

        /**
     * 👇 새로 추가! 검색 Scope
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) {
            return $query;
        }
        
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
        });
    }



        // 좋아요들 (한 글에 여러 좋아요)
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // 좋아요 한 사람들 (User 들)
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    // 특정 사용자가 좋아요 했는지 확인
    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    public function category(): BelongsTo
    {
    return $this->belongsTo(Category::class);
    }
}