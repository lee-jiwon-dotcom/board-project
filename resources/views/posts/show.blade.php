<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            게시글 상세
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 text-green-800 p-4 mb-6 rounded">
                    <p class="font-medium">✓ {{ session('success') }}</p>
                </div>
            @endif

            {{-- 게시글 영역 --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">

                    <h1 class="text-2xl font-bold text-gray-900 mb-4">
                        {{ $post->title }}
                    </h1>

                    <div class="flex items-center text-sm text-gray-500 pb-4 mb-6 border-b border-gray-200">
                        <span class="font-medium text-gray-700">{{ $post->user->name }}</span>
                        <span class="mx-2 text-gray-300">|</span>
                        <span>{{ $post->created_at->format('Y-m-d H:i') }}</span>
                        <span class="mx-2 text-gray-300">|</span>
                        <span>조회 {{ $post->view_count }}</span>
                    </div>

                    <div class="prose max-w-none mb-8 text-gray-700 leading-relaxed whitespace-pre-wrap min-h-[200px]">
                        {{ $post->content }}
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <a href="{{ route('posts.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition">
                            ← 목록으로
                        </a>

                        <div class="flex items-center space-x-2">
                            @can('update', $post)
                                <a href="{{ route('posts.edit', $post) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none transition">
                                    수정
                                </a>
                            @endcan
                            
                            @can('delete', $post)
                                <form action="{{ route('posts.destroy', $post) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('정말 삭제하시겠습니까?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none transition">
                                        삭제
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>

                </div>
            </div>

            {{-- 👇 댓글 영역 추가! --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-bold mb-4">
                        💬 댓글 ({{ $post->comments->count() }})
                    </h3>

                    {{-- 댓글 작성 폼 --}}
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6">
                        @csrf
                        <textarea name="content" 
                                  rows="3" 
                                  placeholder="댓글을 작성해주세요..."
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <div class="mt-2 text-right">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none transition">
                                댓글 작성
                            </button>
                        </div>
                    </form>

                    {{-- 댓글 목록 --}}
                    <div class="space-y-4">
                        @forelse($post->comments as $comment)
                            <div class="border-l-4 border-indigo-300 bg-gray-50 p-4 rounded">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="font-semibold text-gray-800">
                                            {{ $comment->user->name }}
                                        </span>
                                        <span class="text-xs text-gray-500 ml-2">
                                            {{ $comment->created_at->format('Y-m-d H:i') }}
                                        </span>
                                    </div>
                                    
                                    @can('delete', $comment)
                                        <form action="{{ route('comments.destroy', $comment) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('댓글을 삭제하시겠습니까?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-xs text-red-500 hover:text-red-700">
                                                삭제
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                                <p class="text-gray-700 whitespace-pre-wrap">
                                    {{ $comment->content }}
                                </p>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">
                                아직 댓글이 없습니다. 첫 댓글을 작성해주세요!
                            </p>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>