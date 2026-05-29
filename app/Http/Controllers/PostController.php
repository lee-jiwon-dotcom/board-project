<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
    
    $posts = Post::with('user')
                 ->search($search)          // 👈 Scope 사용!
                 ->latest()
                 ->paginate(10)
                 ->withQueryString();
    
    return view('posts.index', compact('posts', 'search'));
}






    /**
     * 게시글 작성 폼 (GET /posts/create)
     */
    public function create(): View
    {
        return view('posts.create');
    }

    /**
     * 게시글 저장 (POST /posts)
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. 유효성 검사
        $validated = $request->validate([
            'title'   => 'required|string|max:200',
            'content' => 'required|string',
        ]);

        // 2. 현재 로그인한 유저의 게시글로 저장
        $request->user()->posts()->create($validated);

        // 3. 목록 페이지로 이동
        return redirect()->route('posts.index')
                         ->with('success', '게시글이 작성되었습니다!');
    }

    /**
     * 게시글 상세 (GET /posts/{post})
     */
    public function show(Post $post): View
{
    // 조회수 증가
    $post->increment('view_count');
    
    // 댓글 + 댓글 작성자 미리 로드 (N+1 방지!)
    $post->load(['comments.user']);
    
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
            'title'   => 'required|string|max:200',
            'content' => 'required|string',
        ]);

        // 2. 수정
        $post->update($validated);

        // 3. 상세 페이지로 이동
        return redirect()->route('posts.show', $post)
                         ->with('success', '게시글이 수정되었습니다!');
    }

    /**
     * 게시글 삭제 (DELETE /posts/{post})
     */
    public function destroy(Post $post): RedirectResponse
    {
         $this->authorize('delete', $post); 

        $post->delete();
        
        return redirect()->route('posts.index')
                         ->with('success', '게시글이 삭제되었습니다!');
    }
}