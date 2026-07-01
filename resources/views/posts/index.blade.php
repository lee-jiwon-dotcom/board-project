<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">ギャラリー</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 成功メッセージ --}}
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 text-green-800 p-4 mb-6 rounded">
                    <p class="font-medium">✓ {{ session('success') }}</p>
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-6">

                {{-- ① サイドバー（テーマ別） --}}
                <aside class="w-full md:w-56 flex-shrink-0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 h-full">
                        <h3 class="px-3 mb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">テーマ</h3>
                        <nav class="space-y-1">
                            {{-- すべて --}}
                            <a href="{{ route('posts.index') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ !$categorySlug ? 'bg-indigo-500 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h1.5A2.25 2.25 0 019.75 6v1.5A2.25 2.25 0 017.5 9.75H6A2.25 2.25 0 013.75 7.5V6zM3.75 16.5A2.25 2.25 0 016 14.25h1.5a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 017.5 20.25H6A2.25 2.25 0 013.75 18v-1.5zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v1.5A2.25 2.25 0 0118 9.75h-2.25A2.25 2.25 0 0113.5 7.5V6zM13.5 16.5a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-1.5z" />
                                </svg>
                                すべて
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('posts.index', ['category' => $category->slug]) }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ $categorySlug === $category->slug ? 'bg-indigo-500 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M6 18.75h12A2.25 2.25 0 0020.25 16.5V7.5A2.25 2.25 0 0018 5.25H6A2.25 2.25 0 003.75 7.5v9A2.25 2.25 0 006 18.75zm9.75-9.75h.008v.008h-.008V9z" />
                                    </svg>
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </aside>

                {{-- ② メイン（グリッド） --}}
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-900">
                            写真 ({{ $posts->total() }})
                        </h3>
                        <a href="{{ route('posts.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            ✏️ 写真を投稿
                        </a>
                    </div>

                    {{-- グリッド --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @forelse($posts as $post)
                            <a href="{{ route('posts.show', $post) }}"
                               class="group block bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                                {{-- サムネイル：最初の写真 --}}
                                <div class="aspect-square bg-gray-100 overflow-hidden">
                                    @if($post->attachments->first())
                                        <img src="{{ asset('storage/' . $post->attachments->first()->path) }}"
                                             alt="{{ $post->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                                            画像なし
                                        </div>
                                    @endif
                                </div>
                                {{-- 投稿者 + タイトル --}}
                                <div class="p-3">
                                    <p class="text-xs text-gray-500">{{ $post->user->name }}</p>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $post->title }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full py-16 text-center">
                                <p class="text-gray-500 text-sm">まだ写真がありません。</p>
                                <a href="{{ route('posts.create') }}"
                                   class="mt-4 inline-block text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                    最初の写真を投稿 →
                                </a>
                            </div>
                        @endforelse
                    </div>

                    {{-- ページネーション --}}
                    @if($posts->hasPages())
                        <div class="mt-8">
                            {{ $posts->links('pagination::tailwind') }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>