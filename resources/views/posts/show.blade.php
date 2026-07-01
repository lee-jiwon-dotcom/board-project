<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            写真の詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 text-green-800 p-4 mb-6 rounded">
                    <p class="font-medium">✓ {{ session('success') }}</p>
                </div>
            @endif

            {{-- 投稿エリア --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">

                    @if($post->category)
                        <span class="inline-block px-3 py-1 mb-3 text-xs font-medium bg-indigo-50 text-indigo-700 rounded-full">
                            {{ $post->category->name }}
                        </span>
                    @endif

                    <h1 class="text-2xl font-bold text-gray-900 mb-4">
                        {{ $post->title }}
                    </h1>

                    <div class="flex items-center text-sm text-gray-500 pb-4 mb-6 border-b border-gray-200">
                        <span class="font-medium text-gray-700">{{ $post->user->name }}</span>
                        <span class="mx-2 text-gray-300">|</span>
                        <span>{{ $post->created_at->format('Y-m-d H:i') }}</span>
                        <span class="mx-2 text-gray-300">|</span>
                        <span>閲覧 {{ $post->view_count }}</span>
                    </div>

                    @if($post->content)
                        <div class="prose max-w-none mb-8 text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $post->content }}</div>
                    @endif

            {{-- 添付画像 --}}
            @if($post->attachments->count() > 0)
                <div class="mb-8 space-y-4">
                    @foreach($post->attachments as $attachment)
                        <img src="{{ asset('storage/' . $attachment->path) }}"
                            alt="{{ $attachment->original_name }}"
                            class="max-w-full rounded-lg shadow">
                    @endforeach
                </div>
            @endif

                  <div class="flex items-center justify-between pt-4 border-t border-gray-200">
    {{-- 左：一覧へ --}}
    <a href="{{ route('posts.index') }}"
       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition">
        ← 一覧へ
    </a>

    {{-- 右：いいね + 編集 + 削除 --}}
    <div class="flex items-center space-x-3">
        {{-- いいねボタン --}}
        @auth
            <form action="{{ route('posts.like', $post) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-50 transition">
                    @if($post->isLikedBy(auth()->user()))
                        <span class="text-2xl">❤️</span>
                    @else
                        <span class="text-2xl">🤍</span>
                    @endif
                    <span class="text-sm font-medium text-gray-700">{{ $post->likes()->count() }}</span>
                </button>
            </form>
        @else
            <div class="flex items-center gap-2 px-3 py-2">
                <span class="text-2xl">🤍</span>
                <span class="text-sm font-medium text-gray-700">{{ $post->likes()->count() }}</span>
            </div>
        @endauth

        {{-- 編集ボタン（投稿者のみ） --}}
        @can('update', $post)
            <a href="{{ route('posts.edit', $post) }}"
               class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none transition">
                編集
            </a>
        @endcan

        {{-- 削除ボタン（投稿者のみ） --}}
        @can('delete', $post)
            <form action="{{ route('posts.destroy', $post) }}"
                  method="POST"
                  class="inline"
                  onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none transition">
                    削除
                </button>
            </form>
        @endcan
    </div>
</div>

                </div>
            </div>

{{-- コメントエリア --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-bold mb-4">
                        💬 コメント ({{ $post->comments->count() }})
                    </h3>

                    {{-- コメント投稿フォーム --}}
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6">
                        @csrf
                        <textarea name="content"
                                  rows="3"
                                  placeholder="コメントを入力してください..."
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <div class="mt-2 text-right">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-sm text-white hover:bg-indigo-700 focus:outline-none transition">
                                コメント投稿
                            </button>
                        </div>
                    </form>

                    {{-- コメント一覧 --}}
                    <div class="space-y-3 bg-gray-50 p-4 rounded-lg">
                        @forelse($post->comments as $comment)
                            <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                                {{-- コメントヘッダー --}}
                                <div class="flex justify-between items-center mb-3">
                                    <div class="flex items-center">
                                        <span class="font-medium text-sm text-gray-800">
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
                                              onsubmit="return confirm('コメントを削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-xs text-red-500 hover:text-red-700 px-2 py-1">
                                                削除
                                            </button>
                                        </form>
                                    @endcan
                                </div>

                                {{-- コメント本文 --}}
                                <div class="text-sm text-gray-700 whitespace-pre-wrap mb-3">{{ $comment->content }}</div>

                                {{-- コメントいいねボタン --}}
                                <div>
                                    @auth
                                        <form action="{{ route('comments.like', $comment) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 text-sm hover:bg-gray-100 px-2 py-1 rounded transition">
                                                @if($comment->isLikedBy(auth()->user()))
                                                    <span>❤️</span>
                                                @else
                                                    <span>🤍</span>
                                                @endif
                                                <span class="text-gray-600">{{ $comment->likes()->count() }}</span>
                                            </button>
                                        </form>
                                    @else
                                        <div class="inline-flex items-center gap-1 text-sm px-2 py-1">
                                            <span>🤍</span>
                                            <span class="text-gray-600">{{ $comment->likes()->count() }}</span>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-8">
                                まだコメントがありません。最初のコメントを投稿してください！
                            </p>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>