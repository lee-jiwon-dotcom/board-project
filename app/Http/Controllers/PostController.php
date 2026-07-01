<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class PostController extends Controller
{
    /**
     * 게시글 목록 (GET /posts)
     */
//   public function index(Request $request): View
// {
//     // 검색어 받기
//     $search = $request->input('search');
    
//     // 쿼리 빌더 시작
//     $query = Post::with('user')->latest();
    
//     // 검색어가 있으면 필터링
//     if ($search) {
//         $query->where(function($q) use ($search) {
//             $q->where('title', 'like', "%{$search}%")
//               ->orWhere('content', 'like', "%{$search}%");
//         });
//     }
    
//     // 페이지네이션 (검색 상태 유지!)
//     $posts = $query->paginate(10)->withQueryString();
    
//     return view('posts.index', compact('posts', 'search'));
// }


public function index(Request $request): View
{
    $search = $request->input('search');
    $categorySlug = $request->input('category');   // ?category=sunset

    $query = Post::with(['user', 'category', 'attachments'])  // 미리 로드
                 ->search($search)
                 ->latest();

    // 카테고리 필터: slug가 들어오면 그 카테고리 글만
    if ($categorySlug) {
        $category = Category::where('slug', $categorySlug)->first();
        if ($category) {
            $query->where('category_id', $category->id);
        }
    }

    $posts = $query->paginate(12)->withQueryString();
    $categories = Category::all();   // 사이드바용

    return view('posts.index', compact('posts', 'search', 'categories', 'categorySlug'));
}
    /**
     * 게시글 작성 폼 (GET /posts/create)
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * 게시글 저장 (POST /posts)
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. 유효성 검사
       $validated = $request->validate([
        'title'       => 'required|string|max:200',
        'content'     => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'images'      => 'required|array|min:1',
        'images.*'    => 'image|max:5120',
    ], [
        'category_id.required' => 'カテゴリーを選択してください。',
        'title.required'       => 'タイトルを入力してください。',
        'images.required'      => '写真を最低1枚アップロードしてください。',
        'images.*.image'       => '画像ファイルのみアップロードできます。',
        'images.*.max'         => '写真は1枚あたり5MB以下にしてください。',
    ]);

        // 2. 현재 로그인한 유저의 게시글로 저장
        $post = $request->user()->posts()->create($validated);
        
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('attachments', 'public');
            $post->attachments()->create([
                'path'          => $path,
                'original_name' => $image->getClientOriginalName(),
            ]);
        }
    }
        // 3. 목록 페이지로 이동
        return redirect()->route('posts.index')
                         ->with('success', '写真を投稿しました！');
    }

    /**
     * 게시글 상세 (GET /posts/{post})
     */
    public function show(Post $post): View
{
    // 조회수 증가
    $post->increment('view_count');
    
    // 댓글 + 댓글 작성자 미리 로드 (N+1 방지!)
    $post->load(['comments.user', 'category']);
    
    return view('posts.show', compact('post'));
}

    /**
     * 게시글 수정 폼 (GET /posts/{post}/edit)
     */
    public function edit(Post $post): View
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    /**
     * 게시글 수정 (PUT/PATCH /posts/{post})
     */
    public function update(Request $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);
        // 1. 유효성 검사
        $validated = $request->validate([
            'title'     => 'required|string|max:200',
            'content'   => 'nullable|string',
            'images.*'  => 'nullable|image|max:5120',
        ]);

        // 2. 수정
        $post->update($validated);

        // 3. 새로 첨부된 사진이 있으면 추가 저장 (store와 동일한 패턴)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('attachments', 'public');
                $post->attachments()->create([
                    'path'          => $path,
                    'original_name' => $image->getClientOriginalName(),
                ]);
            }
        }

        // 4. 상세 페이지로 이동
        return redirect()->route('posts.show', $post)
                         ->with('success', '写真を更新しました！');
    }

    /**
     * 게시글 삭제 (DELETE /posts/{post})
     */
    public function destroy(Post $post): RedirectResponse
    {
         $this->authorize('delete', $post);

        // 실제 파일 먼저 삭제 (cascade는 DB 행만 지우므로 직접 처리)
        foreach ($post->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->path);
        }

        $post->delete();   // 글 삭제 → attachments 행은 cascade로 자동 삭제

        return redirect()->route('posts.index')
                         ->with('success', '写真を削除しました！');
    }
}