<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            게시판
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- 성공 메시지 --}}
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-400 text-green-800 p-4 mb-6 rounded">
                            <p class="font-medium">✓ {{ session('success') }}</p>
                        </div>
                    @endif

                   {{-- 상단 헤더 --}}
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-bold text-gray-900">
        @if($search)
            "{{ $search }}" 검색 결과 ({{ $posts->total() }})
        @else
            전체 게시글 ({{ $posts->total() }})
        @endif
    </h3>
    <a href="{{ route('posts.create') }}" 
       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none transition">
        ✏️ 글쓰기
    </a>
</div>

{{-- 👇 검색창 추가! --}}
<form action="{{ route('posts.index') }}" method="GET" class="mb-6" autocomplete="off">
    <div class="flex gap-2" >
        <input type="text" 
               name="search" 
               value="{{ $search }}"
               placeholder="제목 또는 내용으로 검색..."
               class="flex-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        <button type="submit" 
                class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:outline-none transition">
            🔍 검색
        </button>
        @if($search)
            <a href="{{ route('posts.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition">
                ✕ 초기화
            </a>
        @endif
    </div>
</form>

                    {{-- 게시글 테이블 --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">번호</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">제목</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">작성자</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">조회수</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">작성일</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($posts as $post)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $post->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('posts.show', $post) }}" 
                                               class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                                {{ $post->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $post->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $post->view_count }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $post->created_at->format('Y-m-d') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center">
                                            <p class="text-gray-500 text-sm">아직 작성된 게시글이 없습니다.</p>
                                            <a href="{{ route('posts.create') }}" 
                                               class="mt-4 inline-block text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                첫 게시글 작성하기 →
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- 페이지네이션 --}}
                    @if($posts->hasPages())
                        <div class="mt-6">
                           {{ $posts->links('pagination::tailwind') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>