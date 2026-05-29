<?php

namespace App\Helpers;

class HighlightHelper
{
    /**
     * 텍스트에서 검색어를 강조 표시
     */
    public static function highlight(string $text, ?string $search): string
    {
        if (!$search) {
            return e($text);  // 일반 텍스트 (XSS 방어)
        }
        
        // 검색어를 정규식 안전하게 처리
        $pattern = '/(' . preg_quote($search, '/') . ')/i';
        
        // HTML 이스케이프 먼저!
        $escapedText = e($text);
        
        // 검색어 부분만 <mark> 태그로 감싸기
        return preg_replace($pattern, '<mark class="bg-yellow-200">$1</mark>', $escapedText);
    }
}