<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    // 권한 (반드시 true 로!)
    public function authorize(): bool
    {
        return true;
    }

    // 검증 규칙
    public function rules(): array
    {
        return [
            'title'   => 'required|string|max:200',
            'content' => 'required|string',
        ];
    }

    // 한글 에러 메시지 (선택)
    public function messages(): array
    {
        return [
            'title.required'   => '제목을 입력해주세요.',
            'title.max'        => '제목은 200자 이내로 작성해주세요.',
            'content.required' => '내용을 입력해주세요.',
        ];
    }
}