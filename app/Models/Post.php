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

}